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

        // change the active subscription amount

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

            // delete the subscription Upcoming and Remaining items

            $customerId = $subscription["customer"];

            $upcomingInvoice = \Stripe\Invoice::upcoming(['customer' => $customerId]);

            foreach ($upcomingInvoice['lines']['data'] as $invoice) {

                if (substr($invoice["description"], 0, strlen("Unused time on")) === "Unused time on" || substr($invoice["description"], 0, strlen("Remaining time on")) === "Remaining time on") {
                    $invoiceItem = \Stripe\InvoiceItem::retrieve($invoice["id"]);

                    if (count($invoiceItem)) {
                        $invoiceItem->delete();
                    }
                }
            }

            // change the amount of metadata

            $customer = \Stripe\Customer::retrieve($customerId);

            foreach ($customer["subscriptions"]["data"] as $subscription) {

                if ($subscription->id == $subscriptionId) {
                    $existingMetadata = $subscription->metadata->toArray();

                    if (isset($existingMetadata['cost'])) {
                        unset($existingMetadata['cost']);

                        $existingMetadata['cost'] = $newAmount / 100;

                        \Stripe\Subscription::update(
                            $subscription->id,
                            [
                                'metadata' => $existingMetadata,
                            ]
                        );
                    }
                }
            }
        }

        return $updatedSubscription;
    }
}
