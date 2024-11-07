<?php

namespace FS\ThreadScoringSystem\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ScoringSystem extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_thread_scoring_system';
        $structure->shortName = 'FS\ThreadScoringSystem:ScoringSystem';
        $structure->contentType = 'fs_thread_scoring_system';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'thread_id' => ['type' => self::UINT, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'thread_points' => ['type' => self::FLOAT, 'default' => 0],
            'reply_points' => ['type' => self::FLOAT, 'default' => 0],
            'reply_percentage' => ['type' => self::FLOAT, 'default' => 0],
            'word_points' => ['type' => self::FLOAT, 'default' => 0],
            'word_percentage' => ['type' => self::FLOAT, 'default' => 0],
            'reaction_points' => ['type' => self::FLOAT, 'default' => 0],
            'reaction_percentage' => ['type' => self::FLOAT, 'default' => 0],
            'solution_points' => ['type' => self::FLOAT, 'default' => 0],
            'total_points' => ['type' => self::FLOAT, 'default' => 0],
            'total_percentage' => ['type' => self::FLOAT, 'default' => 0],
        ];

        // 'coupon_value' => ['type' => self::FLOAT, 'min' => 0, 'default' => 15],

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
            ],

            'Thread' => [
                'entity' => 'XF:Thread',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
            ],
        ];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
