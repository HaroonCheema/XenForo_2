<?php

namespace FS\QuizSystem\Entity;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

class Quiz extends \XF\Mvc\Entity\Entity {

    public static function getStructure(Structure $structure) {
        $structure->table = 'fs_quiz';
        $structure->shortName = 'FS\QuizSystem:Quiz';
        $structure->primaryKey = 'quiz_id';
        $structure->contentType = 'quiz';
        $structure->columns = [
            'quiz_id' => ['type' => self::UINT, 'autoIncrement' => true],   
            'category_id' => ['type' => self::UINT, 'nullable' => false],
            'quiz_name' => [
                'type' => self::STR, 'maxLength' => 100,
                'required' => 'please_enter_valid_name'
            ],
            'quiz_des' => [
                'type' => self::STR, 'maxLength' => 1000,
                'required' => 'please_enter_valid_description'
            ],
            'quiz_state' => ['type' => self::STR,'maxLength' => 100, 'required' => 'Select Atleast One Option'],
            'quiz_end_date' => ['type' => self::UINT, 'default' => 0],
            'quiz_start_date' => ['type' => self::UINT, 'default' => 0],
            'time_per_question' => ['type' => self::UINT, 'default' => 0],
            'user_group' => ['type' => self::JSON_ARRAY, 'default' => []],
            'quiz_questions' => ['type' => self::JSON_ARRAY, 'default' => []],
            'created_at' => ['type' => self::UINT, 'default' => 0],
            'updated_at' => ['type' => self::UINT, 'default' => 0],
        ];
        $structure->relations = [
            'Category' => [
                'entity' => 'FS\QuizSystem:Category',
                'type' => self::TO_ONE,
                'conditions' => 'category_id',
                'primary' => true
            ]
        ];
        $structure->getters = [];
        $structure->options = [];

        return $structure;
    }
}
