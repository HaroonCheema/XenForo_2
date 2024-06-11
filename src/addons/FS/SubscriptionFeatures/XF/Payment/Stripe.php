<?php

namespace FS\SubscriptionFeatures\XF\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;

class Stripe extends XFCP_Stripe
{

    public function updatePaymentSubscription(PaymentProfile $paymentProfile, $subscriptionId, $newAmount)
    {
        $this->setupStripe($paymentProfile);

        /** @var \Stripe\Subscription $subscription */
        $subscription = \Stripe\Subscription::retrieve(
            $subscriptionId
        );

        if (!empty($subscription->items)) {
            $new_price = \Stripe\Price::create([
                'unit_amount' => $newAmount, // Amount in cents
                'currency' => $subscription->items->data[0]->price->currency,
                'recurring' => ['interval' => $subscription->items->data[0]->price->recurring->interval],
                'product' => $subscription->items->data[0]->price->product, // Replace with your product ID
            ]);

            $subscriptionItemId = $subscription->items->data[0]->id;

            $updatedSubscription = \Stripe\Subscription::update($subscriptionId, [
                'items' => [
                    [
                        'id' => $subscriptionItemId,
                        'price' => $new_price->id,
                    ],
                ],
            ]);
        }

        return $updatedSubscription;
    }
}
