<?php

namespace FS\DisableBbCodes\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class DisableBbCodes extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_built_in_bb_codes';
        $structure->shortName = 'FS\DisableBbCodes:DisableBbCodes';
        $structure->contentType = 'fs_built_in_bb_codes';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],

            'bb_code_id' => ['type' => self::STR, 'maxLength' => 100],
            'usergroup_ids' => [
                'type' => self::LIST_COMMA,
                'list' => ['type' => 'posint', 'sort' => SORT_NUMERIC], 'default' => []
            ],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
