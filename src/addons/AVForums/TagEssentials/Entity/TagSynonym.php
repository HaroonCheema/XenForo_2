<?php

namespace AVForums\TagEssentials\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int tag_id
 * @property int parent_tag_id
 *
 * RELATIONS
 * @property \XF\Entity\Tag Tag
 * @property \XF\Entity\Tag ParentTag
 */
class TagSynonym extends Entity
{
    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_tagess_synonym';
        $structure->shortName = 'AVForums\TagEssentials:TagSynonym';
        $structure->primaryKey = ['tag_id', 'parent_tag_id'];
        $structure->columns = [
            'tag_id' => ['type' => self::UINT, 'required' => true],
            'parent_tag_id' => ['type' => self::UINT, 'required' => true]
        ];
        $structure->relations = [
            'Tag' => [
                'entity' => 'XF:Tag',
                'type' => self::TO_ONE,
                'conditions' => 'tag_id',
                'primary' => true
            ],
            'ParentTag' => [
                'entity' => 'XF:Tag',
                'type' => self::TO_ONE,
                'conditions' => [
                    ['tag_id', '=', '$parent_tag_id']
                ],
                'primary' => true
            ]
        ];

        return $structure;
    }
}