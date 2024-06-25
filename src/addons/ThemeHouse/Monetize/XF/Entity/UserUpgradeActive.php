<?php

namespace ThemeHouse\Monetize\XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * Class UserUpgradeActive
 * @package ThemeHouse\Monetize\XF\Entity
 *
 * @property integer thmonetize_updated
 */
class UserUpgradeActive extends XFCP_UserUpgradeActive
{
    protected function _preSave()
    {
        parent::_preSave();

        if ($this->isChanged('start_date') || $this->isChanged('end_date')) {
            $this->thmonetize_updated = \XF::$time;
        }
    }

    protected function _postSave()
    {
        parent::_postSave();

        /** @var \ThemeHouse\Monetize\XF\Repository\UserUpgrade $userUpgradeRepo */
        $userUpgradeRepo = \XF::repository('XF:UserUpgrade');
        $userUpgradeRepo->rebuildThMonetizeActiveUserUpgradeCache($this->user_id);
    }

    protected function _postDelete()
    {
        parent::_postDelete();

        /** @var \ThemeHouse\Monetize\XF\Repository\UserUpgrade $userUpgradeRepo */
        $userUpgradeRepo = \XF::repository('XF:UserUpgrade');
        $userUpgradeRepo->rebuildThMonetizeActiveUserUpgradeCache($this->user_id);
    }

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['thmonetize_updated'] = ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}