<?php

namespace FS\UpgradePauseUnpause\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class AlertPauseUnpause extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_alert_pause_unpause';
        $structure->shortName = 'FS\UpgradePauseUnpause:AlertPauseUnpause';
        $structure->contentType = 'dummy_entity';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
