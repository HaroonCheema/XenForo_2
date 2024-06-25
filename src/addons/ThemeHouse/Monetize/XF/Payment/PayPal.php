<?php

namespace ThemeHouse\Monetize\XF\Payment;

use ThemeHouse\Monetize\XF\Entity\UserUpgrade;
use XF\Entity\PurchaseRequest;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

/**
 * Class PayPal
 * @package ThemeHouse\Monetize\XF\Payment
 */
class PayPal extends XFCP_PayPal
{
    /**
     * @param bool $recurring
     * @return bool
     */
    public function thMonetizeSupportsCustomAmount($recurring = false)
    {
        return !$recurring;
    }

    /**
     * @param PurchaseRequest $purchaseRequest
     * @param Purchase $purchase
     * @return array
     */
    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
    {
        $params = parent::getPaymentParams($purchaseRequest, $purchase);

        if ($purchaseRequest->purchasable_type_id === 'user_upgrade') {
            if (!$purchase->recurring && isset($purchaseRequest->extra_data['user_upgrade_id'])) {
                $userUpgradeId = $purchaseRequest->extra_data['user_upgrade_id'];
                /** @var UserUpgrade $userUpgrade */
                $userUpgrade = \XF::em()->find('XF:UserUpgrade', $userUpgradeId);
                if ($userUpgrade->thmonetize_custom_amount) {
                    unset($params['amount']);
                }
            }

            if ($couponCode = \XF::app()->session()->upgradeCoupon) {
                $coupon = \XF::app()->finder('ThemeHouse\Monetize:Coupon')->byCode($couponCode)->fetchOne();

                $amount = $purchase->cost;
                $discount = 0;

                $extraData = $purchaseRequest->extra_data;

                switch ($coupon->type) {
                    case 'amount':
                        $discount = $coupon->value;
                        break;
                    case 'percent':
                        $discount = $amount * ($coupon->value / 100);
                        break;
                }
                $amount = number_format($amount - $discount, 2);

                if ($amount <= 0) {
                    throw new \LogicException(\XF::phrase('thmonetize_discounted_total_must_be_greater_than_zero'));
                }

                if ($purchase->recurring) {
                    $params['a3'] = $amount;
                } else {
                    $params['amount'] = $amount;
                }

                $extraData['coupon_type'] = $coupon->type;
                $extraData['coupon_value'] = $coupon->value;
                $extraData['discounted_total'] = $amount;
                $purchaseRequest->extra_data = $extraData;
                $purchaseRequest->saveIfChanged();
            }
        }

        return $params;
    }

    /**
     * @param CallbackState $state
     * @return bool
     */
    public function validateCost(CallbackState $state)
    {
        $purchaseRequest = $state->getPurchaseRequest();
        /** @noinspection PhpUndefinedFieldInspection */
        if (!$state->legacy && $purchaseRequest->purchasable_type_id === 'user_upgrade') {
            if (isset($purchaseRequest->extra_data['user_upgrade_id'])) {
                $userUpgradeId = $purchaseRequest->extra_data['user_upgrade_id'];
                /** @var UserUpgrade $userUpgrade */
                $userUpgrade = \XF::em()->find('XF:UserUpgrade', $userUpgradeId);
                if (!$userUpgrade->recurring && $userUpgrade->thmonetize_custom_amount) {
                    return true;
                }
            }

            if (!empty($purchaseRequest->extra_data['discounted_total'])) {
                switch ($state->transactionType) {
                    case 'web_accept':
                    case 'subscr_payment':
                        $cost = $purchaseRequest->extra_data['discounted_total'];
                        $currency = $purchaseRequest->cost_currency;

                        $costValidated = (
                            round(($state->costAmount - $state->taxAmount), 2) == round($cost, 2)
                            && $state->costCurrency == $currency
                        );

                        if (!$costValidated)
                        {
                            $state->logType = 'error';
                            $state->logMessage = 'Invalid cost amount. Discount applied incorrectly';
                            return false;
                        }

                        return true;
                }
            }
        }

        return parent::validateCost($state);
    }
}
