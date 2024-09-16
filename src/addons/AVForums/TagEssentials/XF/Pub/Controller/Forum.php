<?php

namespace AVForums\TagEssentials\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

/**
 * Class Forum
 *
 * Extends \XF\Pub\Controller\Forum
 *
 * @package AVForums\TagEssentials\XF\Pub\Controller
 */
class Forum extends XFCP_Forum
{
    /**
     * @param ParameterBag $params
     *
     * @return View
     */
    public function actionPostThread(ParameterBag $params)
    {
        $response = parent::actionPostThread($params);

        if (!$this->isPost() && $response instanceof View)
        {
            /** @var \XF\Entity\Thread $thread */
            if (($thread = $response->getParam('thread')) && !$thread->tags)
            {
                /** @var \AVForums\TagEssentials\XF\Entity\Forum $forum */
                $forum = $thread->Forum;
                $tags = $forum->getRecursiveDefaultTags(\XF::options()->tagess_includeNodeParentTags);
                $thread->tags = array_merge($thread->tags, $tags);
            }
        }

        return $response;
    }

    /**
     * @param \XF\Entity\Forum $forum
     *
     * @return array
     */
    protected function getForumFilterInput(\XF\Entity\Forum $forum)
    {
        $filters = parent::getForumFilterInput($forum);

        if ($tags = $this->filter('tags', 'str'))
        {
            $filters['tags'] = explode(',', $tags);
        }

        return $filters;
    }

    /**
     * @param \XF\Entity\Forum  $forum
     * @param \XF\Finder\Thread|\AVForums\TagEssentials\XF\Finder\Thread $threadFinder
     * @param array             $filters
     */
    protected function applyForumFilters(\XF\Entity\Forum $forum, \XF\Finder\Thread $threadFinder, array $filters)
    {
        parent::applyForumFilters($forum, $threadFinder, $filters);

        if (!empty($filters['tags']))
        {
            $threadFinder->hasTag($filters['tags']);
        }
    }
}