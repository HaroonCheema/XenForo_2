<?php

namespace FS\MapEmails\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class UsernameMap extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_username_map';
        $structure->shortName = 'FS\MapEmails:UsernameMap';
        $structure->contentType = 'fs_username_map';
        $structure->primaryKey = 'user_id';

        $structure->columns = [
            'user_id' => ['type' => self::UINT, 'required' => true],
            'username_old' => ['type' => self::STR, 'maxLength' => 50, 'default' => ''],
            'email_old' =>  ['type' => self::STR, 'maxLength' => 120, 'default' => ''],
            'username_new' =>  ['type' => self::STR, 'maxLength' => 300, 'default' => ''],
            'email_new' =>  ['type' => self::STR, 'maxLength' => 350, 'default' => ''],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
            ]
        ];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
