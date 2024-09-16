<?php

namespace SV\MultiPrefix\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int thread_id
 * @property int prefix_id
 *
 * RELATIONS
 * @property \XF\Entity\ThreadPrefix Prefix
 * @property \XF\Entity\Thread Thread
 */
class ThreadPrefixLink extends Entity
{
    public static function getCategoryColumn(): string
    {
        return 'node_id';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_sv_thread_prefix_link';
        $structure->primaryKey = ['thread_id', 'prefix_id'];

        $structure->columns = [
            'thread_id' => [
                'type'     => self::UINT,
                'required' => true
            ],
            'prefix_id' => [
                'type'     => self::UINT,
                'required' => true
            ]
        ];

        $structure->relations = [
            'Prefix' => [
                'entity'     => 'XF:ThreadPrefix',
                'type'       => self::TO_ONE,
                'conditions' => 'prefix_id',
                'primary'    => true
            ],
            'Thread' => [
                'entity'     => 'XF:Thread',
                'type'       => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary'    => true
            ]
        ];

        return $structure;
    }
}