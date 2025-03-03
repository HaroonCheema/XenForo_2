<?php

namespace AddonFlare\PaidRegistrations\XF\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;

use XF\Payment\CallbackState;

class PayPal extends XFCP_PayPal
{
    use \AddonFlare\PaidRegistrations\Payment\PaidRegistrationsTrait;

    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
    {
        $isGuest = ($this->isGuestPurchaseUserUpgrade($purchaseRequest) && $this->isFromRegistration());

        if ($isGuest)
        {
            $purchase->returnUrl = $this->getReturnUrl($purchaseRequest, $purchase);
        }

        $params = parent::getPaymentParams($purchaseRequest, $purchase);

        if ($isGuest)
        {
            $params['rm'] = 2;
        }

        return $params;
    }

    public function validatePurchaser(CallbackState $state)
    {
        if ($this->isGuestPurchaseUserUpgrade($state->getPurchaseRequest()))
        {
            $state->isGuestPurchaseUserUpgrade = true;

            return true;
        }

        return parent::validatePurchaser($state);
    }

    public function completeTransaction(CallbackState $state)
    {
        if ($state->isGuestPurchaseUserUpgrade)
        {
            $this->logAsGuestPaidUserUpgrade($state);
        }
        else
        {
            parent::completeTransaction($state);
        }
    }
}