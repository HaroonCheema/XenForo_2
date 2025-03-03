<?php

namespace AddonFlare\PaidRegistrations\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;
use XF\Payment\CallbackState;

trait PaidRegistrationsTrait
{
    protected function isGuestPurchaseUserUpgrade(PurchaseRequest $purchaseRequest = null)
    {
        return (
            $purchaseRequest &&
            !$purchaseRequest->user_id &&
            !empty($purchaseRequest->extra_data['email']) &&
            $purchaseRequest->purchasable_type_id == 'user_upgrade' // make sure it's a user upgrade purchase
        );
    }

    protected function isFromRegistration()
    {
        return \XF::app()->request()->filter('registration', 'bool');
    }

    protected function logAsGuestPaidUserUpgrade(CallbackState $state, $logMessage = '')
    {
        // should always be true, but leave incase
        if ($state->paymentResult == CallbackState::PAYMENT_RECEIVED)
        {
            $state->httpCode = 200;
            $state->logType = 'payment';
            $state->logMessage = $logMessage ?: '(Guest) Payment received, upgraded/extended.';

            \XF::runLater(function() use ($state)
            {
                $purchaseRequest = $state->getPurchaseRequest();
                $extraData = $purchaseRequest->extra_data;

                // email user
                if (empty($extraData['emailSent']))
                {
                    $params = [
                        'purchaseRequest' => $purchaseRequest,
                    ];

                    \XF::app()->mailer()->newMail()
                        ->setTo($extraData['email'])
                        ->setTemplate('af_paidregistrations_receipt', $params)
                        ->send();

                    // prevent future emails
                    $extraData['emailSent'] = 1;
                    $purchaseRequest->fastUpdate('extra_data', $extraData);
                }

                $purchaseRequest->fastUpdate('af_pr_guest_pending', 1);
            });
        }
    }

    protected function getReturnUrl(PurchaseRequest $purchaseRequest, Purchase $purchase)
    {
        if ($this->isGuestPurchaseUserUpgrade($purchaseRequest))
        {
            return $this->generateReturnUrl($purchaseRequest->request_key);
        }
        else
        {
            return $purchase->returnUrl;
        }
    }

    protected function generateReturnUrl($requestKey)
    {
        $router = \XF::app()->router('public');
        $linkParams = ['prk' => $requestKey];

        return $router->buildLink('canonical:register', null, $linkParams);
    }
}