<?php

namespace FS\RegistrationAccountType\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['reg_account_type'] =  [
            'type' => self::STR,
            'default' => 'doner',
            'allowedValues' => [
                'doner',
                'donee'
            ]
        ];


        return $structure;
    }
}
