<?php

namespace FS\CancelMultipleSubscriptions\XF\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;

class Stripe extends XFCP_Stripe
{

    public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
    {

        if (isset($purchaseRequest->extra_data['user_upgrade_id']) && $purchaseRequest->extra_data['user_upgrade_id'] && $purchaseRequest->user_id) {

            $providerId = "stripe";
            $finder = \XF::finder('XF:PaymentProfile');
            $paymentProfile = $purchase->paymentProfile;
            $this->setupStripe($paymentProfile);
            $userPurchasedRequests = \XF::app()->finder('XF:PurchaseRequest')->where('user_id', $purchaseRequest->user_id)->where('provider_id', $providerId)->where('purchasable_type_id', "user_upgrade")->where("provider_metadata", "!=", Null)->where("is_canceled", "!=", 1)->fetch();

            if (count($userPurchasedRequests)) {

                foreach ($userPurchasedRequests as $userPurchasedRequest) {

                    if (isset($userPurchasedRequest->extra_data['user_upgrade_id']) && $userPurchasedRequest->extra_data['user_upgrade_id'] == $purchaseRequest->extra_data['user_upgrade_id']) {

                        $subscription = \Stripe\Subscription::retrieve(
                            $userPurchasedRequest->provider_metadata
                        );

                        if (isset($subscription['id'])) {


                            if ($subscription->status == 'active') {

                                $purchaseRequest->delete();
                                throw new \XF\PrintableException(\XF::phrase('payment_clear_need_to_wait_for_account_upgradation'));
                            }
                        }
                    }
                }
            }
        }
        return $parent = parent::initiatePayment($controller, $purchaseRequest, $purchase);
    }


    public function canceledPaymentSubscription(PaymentProfile $paymentProfile, $subscriptionId)
    {
        $this->setupStripe($paymentProfile);

        /** @var \Stripe\Subscription $subscription */
        $subscription = \Stripe\Subscription::retrieve(
            $subscriptionId
        );

        if (isset($subscription['id'])) {

            if ($subscription->status == 'past_due') {
                $invoices = \Stripe\Invoice::all(['subscription' => $subscriptionId]);
                $failedPayments = 0;

                foreach ($invoices->data as $invoice) {
                    if ($invoice->status == 'unpaid') {
                        $failedPayments++;
                    }
                }

                if ($failedPayments >= 1) {
                    $subscription->delete();

                    return true;
                }
            } elseif ($subscription->status == 'canceled') {
                return true;
            }

            return false;
        }

        return true;
    }

    public function cancelMultiplesPaymentSubscription(PaymentProfile $paymentProfile, $subscriptionId)
    {
        $this->setupStripe($paymentProfile);

        /** @var \Stripe\Subscription $subscription */
        $subscription = \Stripe\Subscription::retrieve(
            $subscriptionId
        );

        $customerId = $subscription["customer"];

        $subscriptions = \Stripe\Subscription::all(['customer' => $customerId]);

        if (count($subscriptions)) {

            $subscriptionsByPurchasableId = [];

            foreach ($subscriptions->data as $subscription) {
                $purchasableId = $subscription->metadata['purchasable_id'];
                if (!isset($subscriptionsByPurchasableId[$purchasableId])) {
                    $subscriptionsByPurchasableId[$purchasableId] = [];
                }
                $subscriptionsByPurchasableId[$purchasableId][] = $subscription;
            }

            foreach ($subscriptionsByPurchasableId as $purchasableId => $subscriptions) {
                if (count($subscriptions) > 1) {
                    usort($subscriptions, function ($a, $b) {
                        return $b->created - $a->created;
                    });
                    $latestSubscription = $subscriptions[0];

                    foreach ($subscriptions as $subscription) {
                        if ($subscription->id !== $latestSubscription->id) {
                            $subscription->delete();
                        }
                    }
                }
            }
        }

        return true;
    }
}
