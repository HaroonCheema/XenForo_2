<?php

namespace FS\HideUsernames\Cron;

class HideUsernamesCron
{
    public static function randomNamese()
    {      
        $app = \XF::app();
        $jobID = "random_usernames";

        $app->jobManager()->enqueueUnique($jobID, 'FS\HideUsernames:RandomUsername', [], false);
    }
}
