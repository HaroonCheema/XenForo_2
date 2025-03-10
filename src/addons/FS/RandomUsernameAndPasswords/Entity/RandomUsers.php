<?php

namespace FS\RandomUsernameAndPasswords\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;

class RandomUsers extends Entity
{

    public static function getStructure(Structure $structure)
    {

        $structure->table = 'fs_random_username_and_passwords';
        $structure->shortName = 'FS\RandomUsernameAndPasswords:RandomUsers';
        $structure->primaryKey = 'random_id';
        $structure->contentType = 'fs_random_username_and_passwords';
        $structure->columns = [

            'random_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'customer_id' => ['type' => self::STR, 'default' => ''],
            'first_name' => ['type' => self::STR, 'default' => ''],
            'last_name' => ['type' => self::STR, 'default' => ''],
            'company' => ['type' => self::STR, 'default' => ''],
            'city' => ['type' => self::STR, 'default' => ''],
            'country' => ['type' => self::STR, 'default' => ''],
            'phone_one' => ['type' => self::STR, 'default' => ''],
            'phone_two' => ['type' => self::STR, 'default' => ''],
            'email' => ['type' => self::STR, 'default' => ''],
            'subscription_date' => ['type' => self::STR, 'default' => ''],
            'website' => ['type' => self::STR, 'default' => ''],
            'is_name_used' => ['type' => self::UINT, 'default' => 0],
        ];

        $structure->relations = [];


        return $structure;
    }
}
