<?php

namespace FS\QuizSystem\Entity;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

class Quiz extends \XF\Mvc\Entity\Entity
{

    public static function getStructure(Structure $structure)
    {
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
            'quiz_state' => ['type' => self::STR, 'maxLength' => 100, 'required' => 'Select Atleast One Option'],
            'quiz_end_date' => ['type' => self::UINT, 'default' => 0],
            'quiz_start_date' => ['type' => self::UINT, 'default' => 0],
            'time_per_question' => ['type' => self::UINT, 'default' => 0],
            'user_group' => ['type' => self::JSON_ARRAY, 'default' => []],
            'quiz_questions' => ['type' => self::JSON_ARRAY, 'default' => []],
            'created_at' => ['type' => self::UINT, 'default' => \XF::$time],
            'updated_at' => ['type' => self::UINT, 'default' => \XF::$time],
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

    public function getQuizDuration()
    {
        $time_per_question_in_seconds = $this->time_per_question;
        $total_questions = count($this->quiz_questions);

        $total_duration_in_seconds = $total_questions * $time_per_question_in_seconds;

        $total_duration_in_minutes = round($total_duration_in_seconds / 60, 2);

        $total_duration_in_hours = round($total_duration_in_minutes / 60, 2);

        $formatted_minutes = str_pad(floor($total_duration_in_minutes), 2, '0', STR_PAD_LEFT);
        $formatted_hours = str_pad(floor($total_duration_in_hours), 2, '0', STR_PAD_LEFT);

        $formatted_duration = "{$formatted_hours} hours {$formatted_minutes} minutes";

        return $formatted_duration;
    }
}
