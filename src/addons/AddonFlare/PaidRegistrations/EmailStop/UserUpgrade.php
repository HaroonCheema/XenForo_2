<?php

namespace AddonFlare\PaidRegistrations\EmailStop;

class UserUpgrade extends \XF\EmailStop\AbstractHandler
{
    public function getStopOneText(\XF\Entity\User $user, $contentId)
    {
        return null;
    }

    public function getStopAllText(\XF\Entity\User $user)
    {
        return \XF::phrase('stop_notification_emails_from_all_threads');
    }

    public function stopOne(\XF\Entity\User $user, $contentId)
    {

    }

    public function stopAll(\XF\Entity\User $user)
    {

    }
}