<?php

namespace nick97\WatchList\XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * @property string th_view_username_changes
 * @property string th_view_profile_stats
 */
class UserPrivacy extends XFCP_UserPrivacy
{
    protected function _setupDefaults()
    {
        parent::_setupDefaults();

        $this->allow_view_watchlist = 'everyone';
        $this->allow_view_stats = 'everyone';
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns = array_merge($structure->columns, [
            'allow_view_watchlist' => [
                'type' => self::STR, 'default' => 'everyone',
                'allowedValues' => ['everyone', 'members', 'followed', 'none'],
                'verify' => 'verifyPrivacyChoice'
            ],
            'allow_view_stats' => [
                'type' => self::STR, 'default' => 'everyone',
                'allowedValues' => ['everyone', 'members', 'followed', 'none'],
                'verify' => 'verifyPrivacyChoice'
            ]
        ]);

        return $structure;
    }
}
