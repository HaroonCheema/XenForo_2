<?php

namespace AVForums\TagEssentials\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property string category_id
 * @property string title
 *
 * RELATIONS
 * @property \XF\Entity\Tag[] Tags
 */
class TagCategory extends Entity
{
    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_tagess_category';
        $structure->shortName = 'AVForums\TagEssentials:TagCategory';
        $structure->primaryKey = 'category_id';
        $structure->columns = [
            'category_id' => ['type' => self::STR, 'required' => true],
            'title' => ['type' => self::STR, 'required' => true]
        ];
        $structure->relations = [
            'Tags' => [
                'entity' => 'XF:Tag',
                'type' => self::TO_MANY,
                'conditions' => [
                    ['tagess_category_id', '=', '$category_id']
                ]
            ]
        ];

        return $structure;
    }

    protected function _preSave()
    {
    }

    protected function _postDelete()
    {
        $db = $this->db();

        $db->update('xf_tag', ['tagess_category_id' => ''], 'tagess_category_id = ' . $db->quote($this->category_id));

        $this->app()->jobManager()->enqueueUnique(
            'deleteTagCategory' . $this->category_id,
            'AVForums\TagEssentials:TagCategoryDelete',
            ['tag_category_id' => $this->category_id]
        );
    }
}