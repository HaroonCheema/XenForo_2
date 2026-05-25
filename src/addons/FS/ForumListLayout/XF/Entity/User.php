<?php

namespace FS\ForumListLayout\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['node_ids'] =  [
                                                'type'     => self::LIST_COMMA,
                                                'default'  => '',
                                                'nullable' => true,
                                                'list' => ['type' => 'posint', 'unique' => true], // note; do not use sorting!

                                            ];

        return $structure;
    }
}