<?php

namespace FS\CancelMultipleSubscriptions\XF\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;

class Stripe extends XFCP_Stripe
{
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
            }

            return false;
        }

        return true;
    }

    public function cancelDublicatedPaymentSubscription(PaymentProfile $paymentProfile, $subscriptionId, $newAmount)
    {
        $this->setupStripe($paymentProfile);

        $customerId = "cus_QGd2PZGvQSJ383";

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
