<?php

namespace NF\GiftUpgrades\XF\Entity;

use NF\GiftUpgrades\Entity\GiftTrait;
use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\XF\Entity\ProfilePost as ExtendedProfilePostEntity;

/**
 * Extends \XF\Entity\ProfilePostComment
 *
 * @property-read ?User $User
 */
class ProfilePostComment extends XFCP_ProfilePostComment implements IGiftable
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

        if ($this->message_state != 'visible')
        {
            return false;
        }

        if (!(\XF::options()->nfAllowGiftingOnWarnedContent ?? true) && $this->warning_id)
        {
            return false;
        }

        /** @var ExtendedProfilePostEntity $profilePost */
        $profilePost = $this->ProfilePost;
        if (!$profilePost || !$profilePost->canGiftTo($error))
        {
            return false;
        }

        return true;
    }
}