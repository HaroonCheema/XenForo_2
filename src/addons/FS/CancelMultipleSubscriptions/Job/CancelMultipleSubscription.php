<?php

namespace FS\CancelMultipleSubscriptions\Job;

use XF\Job\AbstractRebuildJob;

class CancelMultipleSubscription extends AbstractRebuildJob
{
    protected $rebuildDefaultData = [
        'steps' => 0,
        'start' => 0,
        'batch' => 100,
    ];

    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn($db->limit(
            "
                SELECT purchase_request_id
                FROM xf_purchase_request
                WHERE purchase_request_id > ?
                ORDER BY purchase_request_id
            ",
            $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        $providerId = "stripe";

        $purchaseRequest = $this->app->finder('XF:PurchaseRequest')->where('purchase_request_id', $id)->where('provider_id', $providerId)->where('purchasable_type_id', "user_upgrade")->where("provider_metadata", "!=", Null)->where("is_canceled", "!=", 1)->fetchOne();

        if (isset($purchaseRequest['purchase_request_id']) && $purchaseRequest['provider_metadata'] != Null) {

            $finder = \XF::finder('XF:PaymentProfile');
            $paymentProfile = $finder
                ->where('provider_id', $providerId)
                ->fetchOne();

            /** @var \XF\Entity\PaymentProvider $provider */
            $provider = \XF::em()->find('XF:PaymentProvider', $providerId);

            $handler = $provider->handler;

            $subscriptionId = $purchaseRequest['provider_metadata'];

            $handler->cancelMultiplesPaymentSubscription($paymentProfile, $subscriptionId);
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('fs_cancel_subscription_status_type');
    }
}
