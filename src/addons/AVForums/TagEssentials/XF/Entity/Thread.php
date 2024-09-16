<?php

namespace AVForums\TagEssentials\XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * Class Thread
 *
 * Extends \XF\Entity\Thread
 *
 * @package AVForums\TagEssentials\XF\Entity
 */
class Thread extends XFCP_Thread
{
    /**
     * @return array
     */
    public function getGroupedTags()
    {
        if (empty($this->tags))
        {
            return [];
        }

        $groupedTags = [];
        $noCategoryTitle = '';

        foreach ($this->tags AS $tagId => $tag)
        {
            $categoryId = '';
            $categoryTitle = $noCategoryTitle;

            if (isset($tag['category_id']))
            {
                $categoryId = $tag['category_id'];
                $categoryTitle = $tag['category_title'];

                unset($tag['category_id'], $tag['category_title']);
            }

            $groupedTags[$categoryId]['title'] = $categoryTitle;
            $groupedTags[$categoryId]['tags'][$tagId] = $tag;
        }

        return $groupedTags;
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->getters['GroupedTags'] = true;

        return $structure;
    }
}