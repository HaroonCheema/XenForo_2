<?php

namespace FS\UserCarDetails\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['model_id'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['car_colour'] =  ['type' => self::STR, 'default' => null];
        $structure->columns['car_trim'] =  ['type' => self::STR, 'default' => null];
        $structure->columns['location_id'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['car_plaque_number'] =  ['type' => self::STR, 'default' => null];
        $structure->columns['car_reg_number'] =  ['type' => self::STR, 'default' => null];
        $structure->columns['car_reg_date'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['car_forum_name'] =  ['type' => self::STR, 'default' => null];
        $structure->columns['car_unique_information'] =  ['type' => self::STR, 'default' => null];


        $structure->relations += [
            'CarModel' => [
                'entity' => 'FS\UserCarDetails:Model',
                'type' => self::TO_ONE,
                'conditions' => 'model_id',
                'primary' => true
            ],

            'CarLocation' => [
                'entity' => 'FS\UserCarDetails:Location',
                'type' => self::TO_ONE,
                'conditions' => 'location_id',
                'primary' => true
            ],
        ];

        return $structure;
    }
}
