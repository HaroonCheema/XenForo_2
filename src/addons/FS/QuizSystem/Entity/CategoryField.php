<?php

namespace FS\QuizSystem\Entity;

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
            'fs_quiz_category_field',
            'FS\QuizSystem:CategoryField',
            null
        );

        $structure->relations['Category'] = [
            'type' => self::TO_ONE,
            'entity' => 'FS\QuizSystem:Category',
            'conditions' => 'category_id',
            'primary' => true
        ];

        return $structure;
    }
}
