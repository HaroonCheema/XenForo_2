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

    public static function cancelSupscriptionMultiples()
    {
        $app = \XF::app();
        $jobID = 'cancel_stripe_multiple_subscriptions_' . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\CancelMultipleSubscriptions:CancelMultipleSubscription', [], false);
    }

    public static function removeTempUsergroups()
    {
        $app = \XF::app();
        $jobID = 'subscriptions_remove_usergroups_' . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\CancelMultipleSubscriptions:RemoveUsergroups', [], false);
    }
}
