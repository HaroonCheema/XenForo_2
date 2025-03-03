<?php

namespace AddonFlare\PaidRegistrations\XF\Payment;

use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;

use XF\Payment\CallbackState;

class Stripe extends XFCP_Stripe
{
}