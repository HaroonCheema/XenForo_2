<?php

namespace AddonFlare\PaidRegistrations\Admin\Controller;

trait PaidRegistrationsMessagesTrait
{
    protected $afPRProOnlyMessage = 'This feature is only available for PRO/Paid licenses. <a href="https://www.addonflare.com/licenses/">Click here to upgrade your license</a>.';

    public function actionCoupon()
    {
        return $this->error($this->afPRProOnlyMessage);
    }
}