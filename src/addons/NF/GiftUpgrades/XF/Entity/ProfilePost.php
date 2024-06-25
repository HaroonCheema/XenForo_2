<?php

namespace NF\GiftUpgrades\XF\Entity;

use NF\GiftUpgrades\Entity\GiftTrait;
use NF\GiftUpgrades\Entity\IGiftable;

/**
 * Extends \XF\Entity\ProfilePost
 *
 * @property-read ?User $User
 */
class ProfilePost extends XFCP_ProfilePost implements IGiftable
{
    use GiftTrait;

    /**
     * @param string|\XF\Phrase|null $error
     * @return bool
     */
    public function canGiftTo(&$error = null): bool
    {
        // XF2.1+ has this field
        if (empty($this->_structure->columns['embed_metadata']))
        {
            return false;
        }

        $visitor = \XF::visitor();

        if ($this->message_state !== 'visible')
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

        return $visitor->hasPermission('profilePost', 'nf_gift');
    }
}