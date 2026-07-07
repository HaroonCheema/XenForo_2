<?php

namespace xenMade\LAU\XF\Repository;

class UserAlert extends XFCP_UserAlert
{
    public function markUserAlertsRead(\XF\Entity\User $user, $readDate = null)
    {
        $session = \XF::app()->session();

        if(!$session->exists())
        {
            parent::markUserAlertsRead($user, $readDate);
        }

        if(
            $session->offsetExists('lau_id') &&
            $session->offsetExists('lau_stealth')
        )
        {
            return;
        }

        parent::markUserAlertsRead($user, $readDate);
    }
}