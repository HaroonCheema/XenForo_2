<?php

namespace FS\RandomUsernameAndPasswords\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['is_renamed'] = ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}
