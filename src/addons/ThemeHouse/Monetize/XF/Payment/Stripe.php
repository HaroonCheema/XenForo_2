<?php

namespace ThemeHouse\Monetize\XF\Payment;

use ThemeHouse\Monetize\Entity\Coupon;
use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class Stripe extends XFCP_Stripe
{
    protected function getStripeCustomer(PurchaseRequest $purchaseRequest, PaymentProfile $paymentProfile, Purchase $purchase, &$error = null)
    {
        $customer = parent::getStripeCustomer($purchaseRequest, $paymentProfile, $purchase, $error);

        if (!$customer) {
            return $customer;
        }

        if ($purchase->purchasableTypeId != 'user_upgrade') {
            return $customer;
        }

        // attaching a coupon to a customer won't work for one-off payments
        if (!$purchase->recurring) {
            return $customer;
        }

        if (!$couponCode = \XF::app()->session()->upgradeCoupon) {
            return $customer;
        }

        $coupon = \XF::app()->finder('ThemeHouse\Monetize:Coupon')->byCode($couponCode)->fetchOne();

        if ($coupon->type == 'amount' && $coupon->value > $purchase->cost) {
            throw new \LogicException(\XF::phrase('thmonetize_discounted_total_must_be_greater_than_zero'));
        }

        $extraData = $purchaseRequest->extra_data;
        // don't want to set discounted_total here, we'll use the calculated value Stripe sends for that
        $extraData += [
            'coupon_id' => $coupon->coupon_id,
            'coupon_type' => $coupon->type,
            'coupon_value' => $coupon->value,
        ];
        $purchaseRequest->extra_data = $extraData;
        $purchaseRequest->saveIfChanged();

        $stripeCoupon = $this->createStripeCoupon($coupon);

        // we can't directly attach a coupon to the subscription when creating it as that API call is buried inside processPayment() - it's not abstracted enough to be able to extend it
        // by attaching it to the customer, it will be applied to the next payment they make, i.e. the initial subscription payment
        // we need it to be applied forever on the subscription, but the problem with attaching it to the customer forever is it'll apply the discount if the upgrade is ever re-purchased in future even if the coupon isn't applied at the point of purchase
        // it's also not very robust or clear to have it applied at customer level
        // so to get everything how it should be, the coupon will be removed from the customer and applied to the subscription later
        \Stripe\Customer::update($customer->id, [
            'coupon' => $stripeCoupon->id,
        ]);

        return $customer;
    }

    protected function createPaymentIntent(PurchaseRequest $purchaseRequest, Purchase $purchase, &$error = null)
    {
        $paymentIntent = parent::createPaymentIntent($purchaseRequest, $purchase, $error);

        if (!$couponCode = \XF::app()->session()->upgradeCoupon) {
            return $paymentIntent;
        }

        $coupon = \XF::app()->finder('ThemeHouse\Monetize:Coupon')->byCode($couponCode)->fetchOne();

        // coupons cannot be applied to Payment Intents, so we need to manually work out the new total
        // https://support.stripe.com/questions/support-for-coupons-using-payment-intents-api
        $amount = $this->getStripeFormattedCost($purchaseRequest, $purchase);
        $discount = 0;

        switch ($coupon->type) {
            case 'amount':
                $discount = $this->prepareCost($coupon->value, $purchase->currency);
                break;
            case 'percent':
                $discount = $amount * ($coupon->value / 100);
                break;
        }
        $amount -= $discount;

        if ($amount <= 0) {
            throw new \LogicException(\XF::phrase('thmonetize_discounted_total_must_be_greater_than_zero'));
        }

        $extraData = $purchaseRequest->extra_data;
        $extraData += [
            'coupon_id' => $coupon->coupon_id,
            'coupon_type' => $coupon->type,
            'coupon_value' => $coupon->value,
            'discounted_total' => $amount,
        ];
        $purchaseRequest->extra_data = $extraData;
        $purchaseRequest->saveIfChanged();

        \Stripe\PaymentIntent::update($paymentIntent->id, [
            'amount' => $amount,
        ]);

        return $paymentIntent;
    }

    public function validateCost(CallbackState $state)
    {
        $purchaseRequest = $state->getPurchaseRequest();

        if (empty($purchaseRequest->extra_data['coupon_id'])) {
            return parent::validateCost($state);
        }

        $currency = $purchaseRequest->cost_currency;
        $cost = $this->prepareCost($purchaseRequest->cost_amount, $currency);

        $subtotal = $total = $amountPaid = $discount = null;
        $balanceChange = 0;

        switch ($state->eventType) {
            case 'charge.succeeded':
                $amountPaid = $state->event['amount'];
                break;
            case 'invoice.payment_succeeded':
                $subtotal = $state->event['subtotal'];
                $total = $state->event['total'];
                $amountPaid = $state->event['amount_paid'];
                $discount = $state->event['total_discount_amounts'][0]['amount'];
                break;
        }

        if ($amountPaid !== null) {
            switch ($state->eventType) {
                case 'charge.succeeded':
                    $costValidated = (
                        $amountPaid === $purchaseRequest->extra_data['discounted_total'] &&
                        strtoupper($state->event['currency']) === $currency
                    );
                    break;
                case 'invoice.payment_succeeded':
                    $costValidated = (
                        $subtotal === $cost &&
                        $amountPaid === $total &&
                        ($subtotal - $discount) == $amountPaid &&
                        strtoupper($state->event['currency']) === $currency
                    );
                    break;
            }

            if (!$costValidated) {
                $state->logType = 'error';
                $state->logMessage = 'Invalid cost amount';
                return false;
            }

            $extraData = $purchaseRequest->extra_data;
            $extraData['discounted_total'] = $total;

            if (!empty($state->event['subscription']) && empty($extraData['coupon_applied_to_subscription'])) {
                $paymentProfile = $state->getPaymentProfile();
                $this->setupStripe($paymentProfile);

                $coupon = \XF::app()->em()->find('ThemeHouse\Monetize:Coupon', $extraData['coupon_id']);

                if ($coupon) {
                    // remove from the customer...
                    $customer = \Stripe\Customer::retrieve($state->event['customer']);
                    $customer->deleteDiscount();

                    // ... and apply to the subscription
                    \Stripe\Subscription::update($state->event['subscription'], [
                        'coupon' => $this->getStripeCouponId($coupon),
                    ]);

                    $extraData['coupon_applied_to_subscription'] = true;
                }
            }

            $purchaseRequest->extra_data = $extraData;

            return true;
        }

        return true;
    }

    protected function getStripeCouponId(Coupon $coupon)
    {
        return 'coupon_' . md5(
            $coupon->title . $coupon->code . $coupon->type . $coupon->value
        );
    }

    protected function createStripeCoupon(Coupon $coupon)
    {
        $couponId = $this->getStripeCouponId($coupon);

        try
        {
            /** @var \Stripe\Coupon $stripeCoupon */
            $stripeCoupon = \Stripe\Coupon::retrieve($couponId);
        }
        catch (\Stripe\Exception\ExceptionInterface $e)
        {
            // likely means no existing coupon, so lets create it
            try
            {
                $couponData = [
                    'id' => $couponId,
                    'name' => $coupon->stripe_name,
                    'duration' => 'forever',
                ];

                switch ($coupon->type) {
                    case 'amount':
                        $couponData['amount_off'] = $this->prepareCost($coupon->value, $purchase->currency);
                        break;
                    case 'percent':
                        $couponData['percent_off'] = $coupon->value;
                        break;
                }

                /** @var \Stripe\Coupon $stripeCoupon */
                $stripeCoupon = \Stripe\Coupon::create($couponData);
            }
            catch (\Stripe\Exception\ExceptionInterface $e)
            {
                // failed to retrieve, failed to create
                $error = $e->getMessage();
                return false;
            }
        }

        return $stripeCoupon;
    }
}
