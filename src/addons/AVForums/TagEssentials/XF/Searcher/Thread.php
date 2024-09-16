<?php

namespace AVForums\TagEssentials\XF\Searcher;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Manager;

/**
 * Class Thread
 *
 * @package AVForums\TagEssentials\XF\Searcher
 */
class Thread extends XFCP_Thread
{
    /**
     * Thread constructor.
     *
     * @param Manager    $em
     * @param array|null $criteria
     */
    public function __construct(Manager $em, array $criteria = null)
    {
        parent::__construct($em, $criteria);
    }

    /**
     * @return array
     */
    public function getFormDefaults()
    {
        $defaults = parent::getFormDefaults();

        $defaults['tags'] = '';

        return $defaults;
    }

    /**
     * @param Finder $finder
     * @param        $key
     * @param        $value
     * @param        $column
     * @param        $format
     * @param        $relation
     *
     * @return bool
     */
    protected function applySpecialCriteriaValue(Finder $finder, $key, $value, $column, $format, $relation)
    {
        if ($key === 'tags' && ($finder instanceof \AVForums\TagEssentials\XF\Finder\Thread))
        {
            if (!$value)
            {
                return true;
            }

            /** @var \XF\Repository\Tag $tagRepo */
            $tagRepo = \XF::repository('XF:Tag');
            /** @var \XF\Entity\Tag[] $tags */
            $tagNames = $tagRepo->splitTagList($value);
            $tags = $tagRepo->getTags($tagNames);

            if ($tags)
            {
                $tagIds = [];
                foreach($tags as $tag)
                {
                    /** @var \XF\Entity\Tag $tag */
                    $tagIds[] = $tag->tag_id;
                }
                $db = \XF::db();
                $finder->sqlJoin('(
                    select content_id as thread_id
                    from xf_tag_content
                    where content_type = \'thread\' and tag_id in (' . $db->quote($tagIds) . ')
                    group by content_id
                    having count(*) >= '. $db->quote(count($tagIds)) .'
                )', 'taggedThread', ['thread_id'], true, true);
                $finder->sqlJoinConditions('taggedThread', ['thread_id']);
            }
            else
            {
                $finder->whereImpossible();
            }

            return true;
        }

        return parent::applySpecialCriteriaValue($finder, $key, $value, $column, $format, $relation);
    }
}