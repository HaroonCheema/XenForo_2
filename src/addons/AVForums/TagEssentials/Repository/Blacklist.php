<?php

namespace AVForums\TagEssentials\Repository;

use XF\Mvc\Entity\Repository;

/**
 * Class Blacklist
 *
 * @package AVForums\TagEssentials\Repository
 */
class Blacklist extends Repository
{
    /**
     * @param \XF\Mvc\Entity\Entity|String $tag
     * @return bool
     */
    public function canBlackListTag($tag)
    {
        if ($tag instanceof \XF\Entity\Tag)
        {
            $tag = $tag->tag;
        }

        if (!$tag)
        {
            return false;
        }

        $match = $this->finder('AVForums\TagEssentials:Blacklist')
                      ->where('tag', '=', $tag)
                      ->fetchColumns('blacklist_id');

        return $match ? false : true;
    }

    /**
     * @param \XF\Mvc\Entity\Entity $tag
     * @param \XF\Entity\Thread $thread
     * @return bool
     */
    protected function checkAllowedNodeList($tag, $thread)
    {
        $nodeId = $thread->node_id;
        /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
        return !$tag->allowed_node_ids || in_array($nodeId, $tag->allowed_node_ids, true);
    }

    /**
     * @param \XF\Mvc\Entity\Entity|String $tag
     * @param \XF\Mvc\Entity\Entity $context Only applies if $tag is an entity
     * @return bool
     */
    public function isTagBlacklisted($tag, $context)
    {
        if ($tag instanceof \XF\Entity\Tag)
        {
            if ($context instanceof \XF\Entity\Thread &&
                !$this->checkAllowedNodeList($tag, $context))
            {
                return true;
            }

            $tag = $tag->tag;
        }

        if (!$tag)
        {
            return false;
        }

        $match = $this->finder('AVForums\TagEssentials:Blacklist')
                      ->where('regex', '=', 0)
                      ->where('tag', '=', $tag)
                      ->fetchColumns('blacklist_id');
        if ($match)
        {
            return true;
        }

        $blackLists = $this->finder('AVForums\TagEssentials:Blacklist')
                           ->where('regex', '=', 1)
                           ->fetchColumns('tag');
        foreach ($blackLists as $blackList)
        {
            if (@\preg_match($blackList['tag'], $tag, $matches))
            {
                return true;
            }
        }

        return false;
    }
}