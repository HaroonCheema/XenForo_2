<?php

namespace FS\OyunGamePoints\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public function getGamePoints($threadId)
    {
        $points = 5;

        if ($threadId) {
            $thread = \XF::em()->find('XF:Thread', $threadId);

            if ($thread) {
                $points = isset($thread['custom_fields']['fiyat']) ? intval($thread['custom_fields']['fiyat']) : 5;
            }
        }

        return $points;
    }
}
