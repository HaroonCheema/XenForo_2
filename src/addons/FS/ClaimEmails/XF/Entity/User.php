<?php

namespace FS\ClaimEmails\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['is_claimed'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['is_new'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}
