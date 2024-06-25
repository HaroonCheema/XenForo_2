<?php

namespace NF\GiftUpgrades\NF\Calendar\Entity;

use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Entity\GiftTrait;
use NF\GiftUpgrades\XF\Entity\User;

/**
 * Extends \NF\Calendar\Entity\Event
 *
 * @property-read ?User $User
 */
class Event extends XFCP_Event implements IGiftable
{
    use GiftTrait;

    /**
     * @param string|\XF\Phrase|null $error
     * @return bool
     */
    public function canGiftTo(&$error = null): bool
    {
        if ($this->event_state !== 'visible')
        {
            return false;
        }

        $user = $this->User;
        if (!$user || !$user->canGiftTo($error))
        {
            return false;
        }

        return $this->hasPermission('nf_gift');
    }
}