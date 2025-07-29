<?php

namespace FS\SendMailFromTable\Cron;

class MidNightEmails
{

    public static function monthlyTotalUsersPoints()
    {
        $app = \XF::app();
        $jobID = "fs_mid_night_email_" . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\SendMailFromTable:SendEmails', [], false);
        // $app->jobManager()->enqueueUnique($jobID, 'FS\SendMailFromTable:SendEmails', [], true);
        // $app->jobManager()->runUnique($jobID, 120);
    }
}
