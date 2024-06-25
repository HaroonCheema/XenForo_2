<?php

namespace NF\GiftUpgrades\XenAddons\AMS\Entity;

use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Entity\GiftTrait;
use NF\GiftUpgrades\XF\Entity\User as User;


/**
 * Extends \XenAddons\AMS\Entity\ArticleItem
 *
 * @property-read ?User $User
 */
class ArticleItem extends XFCP_ArticleItem implements IGiftable
{
    use GiftTrait;

    /**
     * @param string|\XF\Phrase|null $error
     * @return bool
     */
    public function canGiftTo(&$error = null): bool
    {
        if ($this->article_state !== 'visible')
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