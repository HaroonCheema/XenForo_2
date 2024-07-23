<?php

namespace FS\CancelMultipleSubscriptions\Cron;

class CancelSubscription
{
    public static function cancelSupscriptionUnPaid()
    {
        $app = \XF::app();
        $jobID = 'cancel_stripe_subscriptions_' . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\CancelMultipleSubscriptions:CancelSubscription', [], false);
        // $app->jobManager()->runUnique($jobID, 120);
    }
}
