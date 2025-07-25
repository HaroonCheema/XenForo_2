<?php

namespace FS\MapEmails\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->relations += [
            'MapUser' => [
                'entity' => 'FS\MapEmails:UsernameMap',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                // 'primary' => true
            ],
        ];

        return $structure;
    }
}
