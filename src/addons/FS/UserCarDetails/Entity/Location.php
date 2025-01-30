<?php

namespace FS\UserCarDetails\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Location extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_car_locations_list';
        $structure->shortName = 'FS\UserCarDetails:Location';
        $structure->contentType = 'fs_car_locations_list';
        $structure->primaryKey = 'location_id';
        $structure->columns = [
            'location_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'location' => ['type' => self::STR, 'default' => null],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
