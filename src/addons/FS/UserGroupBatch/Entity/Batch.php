<?php

namespace FS\UserGroupBatch\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Batch extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_usergroup_batch';
        $structure->shortName = 'FS\UserGroupBatch:Batch';
        $structure->contentType = 'fs_usergroup_batch';
        $structure->primaryKey = 'batch_id';
        $structure->columns = [
            'batch_id' => ['type' => self::UINT, 'autoIncrement' => true],

            'title' => [
                'type' => self::STR, 'maxLength' => 100,
                'required' => 'please_enter_valid_title'
            ],
            'desc' => ['type' => self::STR, 'default' => ''],
            'img_path' => ['type' => self::STR, 'required' => true],
            'type_repeat' => ['type' => self::UINT],
            'mini_post' => ['type' => self::UINT],
            'usergroup_ids' => [
                'type' => self::LIST_COMMA, 'required' => true,
                'list' => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]
            ],

        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
