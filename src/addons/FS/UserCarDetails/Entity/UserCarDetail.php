<?php

namespace FS\UserCarDetails\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class UserCarDetail extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_user_car_details';
        $structure->shortName = 'FS\UserCarDetails:UserCarDetail';
        $structure->contentType = 'fs_user_car_details';
        $structure->primaryKey = 'car_id';
        $structure->columns = [
            'car_id' => ['type' => self::UINT, 'autoIncrement' => true],

            'username' => ['type' => self::STR, 'default' => null],
            'model_id' =>  ['type' => self::UINT, 'default' => 0],
            'car_colour' =>  ['type' => self::STR, 'default' => null],
            'car_trim' =>  ['type' => self::STR, 'default' => null],
            'location_id' =>  ['type' => self::UINT, 'default' => 0],
            'car_plaque_number' =>  ['type' => self::STR, 'default' => null],
            'car_reg_number' =>  ['type' => self::STR, 'default' => null],
            'car_reg_date' =>  ['type' => self::UINT, 'default' => 0],
            'car_forum_name' =>  ['type' => self::STR, 'default' => null],
            'car_unique_information' =>  ['type' => self::STR, 'default' => null],
            'updated_at' => ['type' => self::UINT, 'default' => \XF::$time],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'username',
            ],

            'Model' => [
                'entity' => 'FS\UserCarDetails:Model',
                'type' => self::TO_ONE,
                'conditions' => 'model_id',
            ],

            'Location' => [
                'entity' => 'FS\UserCarDetails:Location',
                'type' => self::TO_ONE,
                'conditions' => 'location_id',
            ],
        ];

        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
