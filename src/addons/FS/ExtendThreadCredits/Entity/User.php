<?php

namespace FS\ExtendThreadCredits\Entity;

use XF\Entity\User as BaseUser;
use XF\Mvc\Entity\Structure;


class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        // Call the parent method to get the existing structure
        $structure = parent::getStructure($structure);

        $structure->columns += [
            'special_credit' => ['type' => self::UINT, 'default' => 0],
        ];

        return $structure;
    }

 
}
