<?php

namespace FS\FemaleAgeVerification\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['gender'] =  ['type' => self::STR, 'maxLength' => 7, 'default' => ''];

        return $structure;
    }
}
