<?php

namespace FS\SearchOwnThread\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class SearchOwnThread extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_search_own_thread_list';
        $structure->shortName = 'FS\SearchOwnThread:SearchOwnThread';
        $structure->contentType = 'fs_search_own_thread_list';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],

            'title' => [
                'type' => self::STR, 'maxLength' => 50,
                'required' => 'please_enter_valid_title'
            ],
            'description' => ['type' => self::STR, 'default' => ''],
            'url_portion' => ['type' => self::STR, 'default' => ''],
            'newer_than' => ['type' => self::STR, 'default' => ''],
            'older_than' => ['type' => self::STR, 'default' => ''],
            'min_reply_count' => ['type' => self::UINT, 'default' => 0],
            'prefixes' => ['type' => self::JSON_ARRAY, 'default' => []],
            'nodes' => ['type' => self::JSON_ARRAY, 'default' => []],
            'order' => ['type' => self::STR, 'default' => ''],
            'display_order' => ['type' => self::UINT, 'default' => 1],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
