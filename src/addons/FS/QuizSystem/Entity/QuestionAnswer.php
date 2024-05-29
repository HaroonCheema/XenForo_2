<?php

namespace FS\QuizSystem\Entity;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

class QuestionAnswer extends \XF\Mvc\Entity\Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_quiz_question_answers';
        $structure->shortName = 'FS\QuizSystem:QuestionAnswer';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],

            'question_id' => ['type' => self::UINT, 'default' => 0],
            'quiz_id' => ['type' => self::UINT, 'default' => 0],
            'user_id' => ['type' => self::UINT, 'default' => 0],
            'at_index' => ['type' => self::UINT, 'default' => 0],
            'answer' => ['type' => self::STR, 'maxLength' => 1000, 'default' => ''],
            'correct' => ['type' => self::BOOL, 'default' => true],
            'created_at' => ['type' => self::UINT, 'default' => \XF::$time],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Quiz' => [
                'entity' => 'FS\QuizSystem:Quiz',
                'type' => self::TO_ONE,
                'conditions' => 'quiz_id',
                'primary' => true
            ],
            'Question' => [
                'entity' => 'FS\QuizSystem:Question',
                'type' => self::TO_ONE,
                'conditions' => 'question_id',
                'primary' => true
            ],
        ];
        $structure->getters = [];
        $structure->options = [];

        return $structure;
    }
}
