<?php

namespace FS\UpgradePauseUnpause\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class UpgradePaused extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_user_upgrade_pause_unpause';
        $structure->shortName = 'FS\UpgradePauseUnpause:UpgradePaused';
        $structure->contentType = 'fs_user_upgrade';
        $structure->primaryKey = 'user_upgrade_record_id';
        $structure->columns = [
            'user_upgrade_record_id' => ['type' => self::UINT],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'created_at' => ['type' => self::UINT, 'default' => \XF::$time],
        ];

        $structure->relations = [
            'UserUpgradeExpired' => [
                'entity' => 'XF:UserUpgradeExpired',
                'type' => self::TO_ONE,
                'conditions' => 'user_upgrade_record_id',
            ],
        ];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
