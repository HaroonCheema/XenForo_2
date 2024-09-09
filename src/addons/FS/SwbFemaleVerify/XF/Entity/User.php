<?php

namespace FS\SwbFemaleVerify\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['identity_status'] =  [
            'type' => self::STR,
            'allowedValues' => [
                'pending',
                'rejected',
                'sent',
                'queue'
            ],
            'default' => 'pending',
            'api' => true
        ];

        return $structure;
    }
}
