<?php

namespace FS\UserCarDetails\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Model extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_car_models_list';
        $structure->shortName = 'FS\UserCarDetails:Model';
        $structure->contentType = 'fs_car_models_list';
        $structure->primaryKey = 'model_id';
        $structure->columns = [
            'model_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'model' => ['type' => self::STR, 'default' => null],
        ];

        return $structure;
    }
}
