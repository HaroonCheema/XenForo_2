<?php

namespace FS\UsergroupUsersCount\XF\Entity;

use XF\Mvc\Entity\Structure;

class UserGroup extends XFCP_UserGroup
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['primary_users_count'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['secondary_users_count'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}
