<?php

namespace FS\QuizSystem\Entity;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

class Question extends \XF\Mvc\Entity\Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_quiz_question';
        $structure->shortName = 'FS\QuizSystem:Question';
        $structure->primaryKey = 'question_id';
        $structure->columns = [
            'question_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'question_title' => [
                'type' => self::STR, 'maxLength' => 1000,
                'required' => 'please_enter_valid_title'
            ],
            'question_type' => ['type' => self::STR, 'maxLength' => 100, 'required' => 'please_click_valid_type'],

            'question_correct_answer' => ['type' => self::STR, 'maxLength' => 1000, 'default' => ''],
            'options' => ['type' => self::JSON_ARRAY, 'default' => []],
            'correct' => ['type' => self::JSON_ARRAY, 'default' => []],
            'created_at' => ['type' => self::UINT, 'default' => \XF::$time],
            'updated_at' => ['type' => self::UINT, 'default' => \XF::$time],
        ];
        $structure->relations = [];
        $structure->getters = [];
        $structure->options = [];

        return $structure;
    }
}
