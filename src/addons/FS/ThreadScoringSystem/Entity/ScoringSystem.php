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
            'points_type' => ['type' => self::STR, 'maxLength' => 20, 'required' => true],
            'points' => ['type' => self::UINT, 'required' => true],
            'percentage' => ['type' => self::UINT, 'required' => true],
        ];

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
