<?php

namespace FS\ThreadScoringSystem\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class TotalScoringCustom extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_thread_total_scoring_custom';
        $structure->shortName = 'FS\ThreadScoringSystem:TotalScoringCustom';
        $structure->contentType = 'fs_thread_total_scoring_custom';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'threads_score' => ['type' => self::FLOAT, 'default' => 0],
            'reply_score' => ['type' => self::FLOAT, 'default' => 0],
            'worlds_score' => ['type' => self::FLOAT, 'default' => 0],
            'reactions_score' => ['type' => self::FLOAT, 'default' => 0],
            'solutions_score' => ['type' => self::FLOAT, 'default' => 0],
            'total_score' => ['type' => self::FLOAT, 'default' => 0],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
            ],
        ];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
