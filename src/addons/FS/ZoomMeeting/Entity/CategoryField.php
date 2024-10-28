<?php

namespace FS\ZoomMeeting\Entity;

use XF\Mvc\Entity\Structure;
use XF\Entity\AbstractFieldMap;


class CategoryField extends AbstractFieldMap
{
    
    public static function getContainerKey()
    {
        return 'category_id';
    }

    public static function getStructure(Structure $structure)
    {
        self::setupDefaultStructure(
            $structure,
            'zom_category_field',
            'FS\ZoomMeeting:CategoryField',
            null
        );

        $structure->relations['Category'] = [
            'type' => self::TO_ONE,
            'entity' => 'FS\ZoomMeeting:Category',
            'conditions' => 'category_id',
            'primary' => true
        ];

        return $structure;
    }
}
