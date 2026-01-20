<?php

namespace FS\PostPrefix\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;


class PostPrefixes extends Entity
{
    
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_post_prefixes';
        $structure->shortName = 'FS\PostPrefix:PostPrefixes';
        $structure->primaryKey = ['post_id', 'prefix_id'];

        $structure->columns = [
            'post_id' => ['type' => self::UINT,'required' => true],
            'prefix_id' => ['type' => self::UINT,'required' => true]
        ];

        $structure->relations = [
            'Prefix' => [
                'entity'     => 'XF:ThreadPrefix',
                'type'       => self::TO_ONE,
                'conditions' => 'prefix_id',
                'primary'    => true
            ],
            
            'Post' => [
                'entity'     => 'XF:Post',
                'type'       => self::TO_ONE,
                'conditions' => 'post_id',
                'primary'    => true,
                'with' => 'Thread',
            ]
        
        ];

        return $structure;
    }
}