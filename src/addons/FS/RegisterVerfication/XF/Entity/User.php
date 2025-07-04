<?php

namespace FS\RegisterVerfication\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{

    public static function getStructure(Structure $structure)
    {

        $structure = parent::getStructure($structure);

        $structure->columns['comp_verify_key'] = ['type' => self::INT, 'default' => 0];

        $structure->columns['comp_verify_val'] = ['type' => self::STR, 'default' => null];

        $structure->columns['fs_regis_referral'] = ['type' => self::STR, 'maxLength' => 500, 'default' => ''];

        return $structure;
    }
}
