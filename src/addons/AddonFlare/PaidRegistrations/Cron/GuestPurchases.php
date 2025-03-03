<?php

namespace AddonFlare\PaidRegistrations\Cron;

class GuestPurchases
{
    public static function process($entry)
    {
        \XF::app()->jobManager()->enqueueUnique('PaidRegistrationsGuestPurchases', 'AddonFlare\PaidRegistrations:GuestPurchases', [], false);
    }
}