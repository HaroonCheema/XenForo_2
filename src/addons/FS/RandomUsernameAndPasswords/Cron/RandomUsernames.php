<?php

namespace FS\RandomUsernameAndPasswords\Cron;

class RandomUsernames
{
    public static function assignRandomUsernameAndPasswords()
    {
        $app = \XF::app();
        $jobID = "fs_assign_random_usernames_" . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\RandomUsernameAndPasswords:AssignRandomUsername', [], false);
        // $app->jobManager()->enqueueUnique($jobID, 'FS\RandomUsernameAndPasswords:AssignRandomUsername', [], true);
        // $app->jobManager()->runUnique($jobID, 120);
    }
}
