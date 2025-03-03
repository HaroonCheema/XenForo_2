<?php

namespace AddonFlare\PaidRegistrations\Job;

use XF\Payment\CallbackState;

class GuestPurchases extends \XF\Job\AbstractJob
{
    public function run($maxRunTime)
    {
        $app = \XF::app();
        $db = $app->db();

        $purchaseRequests = \XF::finder('XF:PurchaseRequest')
            ->where('af_pr_guest_pending', 1) // payments received that need to be applied
            ->where('user_id', '>', 0)
            ->where('purchasable_type_id', 'user_upgrade')
            ->with('Purchasable', true)
            ->with('PaymentProfile', true)
            ->with('PaymentProfile.Provider', true)
            ->with('User', true)
            ->keyedBy('request_key')->fetch();

        foreach ($purchaseRequests as $requestKey => $purchaseRequest)
        {
            if (!$paymentHandler = $purchaseRequest->PaymentProfile->getPaymentHandler())
            {
                continue;
            }
            $state = new CallbackState();
            $state->purchaseRequest = $purchaseRequest;
            $state->purchaser = $purchaseRequest->User;
            $state->purchasableHandler = $purchaseRequest->Purchasable->handler;
            $state->paymentProfile = $purchaseRequest->PaymentProfile;
            $state->paymentResult = CallbackState::PAYMENT_RECEIVED;
            $paymentHandler->completeTransaction($state);
            $purchaseRequest->fastUpdate('af_pr_guest_pending', 0);
        }

        return $this->complete();
    }

    public function getStatusMessage()
    {
        return 'Processing guest purchases...';
    }

    public function canCancel()
    {
        return false;
    }

    public function canTriggerByChoice()
    {
        return false;
    }
}