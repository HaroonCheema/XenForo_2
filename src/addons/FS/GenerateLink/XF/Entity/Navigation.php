<?php

namespace FS\GenerateLink\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;


class Navigation extends XFCP_Navigation
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['forum_ids']   = ['type' => self::LIST_COMMA, 'default' => [], 'list' => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]];
        $structure->columns['route']   = ['type' => self::STR, 'default' => '', 'maxLength' => 100];

        return $structure;
    }
}
