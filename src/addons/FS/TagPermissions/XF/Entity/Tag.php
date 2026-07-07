<?php

namespace FS\TagPermissions\XF\Entity;

use XF\Mvc\Entity\Structure;

class Tag extends XFCP_Tag
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['fs_usergroup_ids'] =        [
            'type' => self::LIST_COMMA,
            'list' => ['type' => 'posint', 'sort' => SORT_NUMERIC],
            'default' => []
        ];

        return $structure;
    }
}
