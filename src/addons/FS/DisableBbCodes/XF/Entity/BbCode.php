<?php

namespace FS\DisableBbCodes\XF\Entity;

use XF\Mvc\Entity\Structure;

class BbCode extends XFCP_BbCode
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['usergroup_ids'] =  [
            'type' => self::LIST_COMMA,
            'list' => ['type' => 'posint', 'sort' => SORT_NUMERIC]
        ];

        return $structure;
    }
}
