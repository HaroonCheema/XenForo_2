<?php

namespace FS\GuestReceiveEmail\XF\Entity;

use XF\Entity\Post;

/**
 * RELATIONS
 * @property \FS\GuestReceiveEmail\Entity\Schedule|null Schedule
 */

class Thread extends XFCP_Thread
{
    public function getGuestEmailExist()
    {
        $guestId =  \XF::app()->request->getCookie('fs_guest_unique_id');

        if ($guestId) {
            $existGuest = $this->finder('FS\GuestReceiveEmail:GuestEmail')->where('thread_id', $this->thread_id)->where('guest_id', $guestId)->fetchOne();
        }

        if ($existGuest) {
            return true;
        }

        return false;
    }
}
