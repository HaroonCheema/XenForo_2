<?php

namespace NF\GiftUpgrades\XF\Entity;

use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Entity\GiftTrait;

/**
 * Extends \XF\Entity\Post
 *
 * @property-read ?User $User
 */
class Post extends XFCP_Post implements IGiftable
{
    use GiftTrait;

    /**
     * @param string|\XF\Phrase|null $error
     * @return bool
     */
    public function canGiftTo(&$error = null): bool
    {
        $visitor = \XF::visitor();

        if ($this->message_state !== 'visible' || !$this->Thread)
        {
            return false;
        }

        if (!(\XF::options()->nfAllowGiftingOnWarnedContent ?? true) && $this->warning_id)
        {
            return false;
        }

        $user = $this->User;
        if (!$user || !$user->canGiftTo($error))
        {
            return false;
        }

        return $visitor->hasNodePermission($this->Thread->node_id, 'nf_gift');
    }
}