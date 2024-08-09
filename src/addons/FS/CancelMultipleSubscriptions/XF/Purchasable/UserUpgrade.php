<?php

namespace FS\CancelMultipleSubscriptions\XF\Purchasable;

use XF\Payment\CallbackState;

class UserUpgrade extends XFCP_UserUpgrade
{
    public function getPurchaseObject(\XF\Entity\PaymentProfile $paymentProfile, $purchasable, \XF\Entity\User $purchaser)
    {
        return parent::getPurchaseObject($paymentProfile, $purchasable, $purchaser);
    }
}
