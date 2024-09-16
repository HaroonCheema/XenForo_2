<?php

namespace SV\MultiPrefix\AVForums\PrefixEssentials\Pub\Controller;



/**
 * Extends \AVForums\PrefixEssentials\Pub\Controller\PrefixEss
 */
class PrefixEss extends XFCP_PrefixEss
{
    /**
     * @param \XF\Entity\ThreadPrefix $prefix
     * @param int                     $page
     * @param int                     $perPage
     * @param \XF\Entity\Forum[]      $viewableForums
     * @param bool                    $allowOwnPending
     * @return \XF\Finder\Thread
     */
    protected function getThreadFinder(\XF\Entity\ThreadPrefix $prefix, $page, $perPage, $viewableForums, $allowOwnPending  = false)
    {
        /** @var \XF\Finder\Thread $threadFinder */
        $threadFinder = $this->finder('XF:Thread');

        $threadFinder->with('full');

        $forumViews = [];
        foreach($viewableForums as $forum)
        {
            list($conditions, $with) = $this->getForumConditions($threadFinder, $prefix, $forum, $allowOwnPending);
            if ($conditions)
            {
                $forumViews[] = $conditions;
                if ($with)
                {
                    $threadFinder->with($with);
                }
            }
        }
        $threadFinder->whereOr($forumViews);

        $threadFinder->limitByPage($page, $perPage);
        $threadFinder->with($this->getThreadWith());
        $threadFinder->order('last_post_date','desc');

        /** @var \SV\MultiPrefix\XF\Finder\Thread $threadFinder */
        $threadFinder->hasPrefixes($prefix->prefix_id);

        return $threadFinder;
    }

    /**
     * @param \XF\Entity\ThreadPrefix|null $threadPrefix
     *
     * @return \XF\Mvc\Reply\View
     */
    protected function getRss(\XF\Entity\ThreadPrefix $threadPrefix = null)
    {
        $limit = $this->options()->discussionsPerPage;

        /** @var \AVForums\PrefixEssentials\XF\Repository\Thread $threadRepo */
        $threadRepo = $this->repository('XF:Thread');
        $threadList = $threadRepo->findThreadsForRssFeed()->limit($limit * 3);

        if ($threadPrefix)
        {
            /** @var \SV\MultiPrefix\XF\Finder\Thread $threadList */
            $threadList->hasPrefixes($threadPrefix->prefix_id);
        }

        $order = $this->filter('order', 'str');
        switch ($order)
        {
            case 'post_date':
                break;

            default:
                $order = 'last_post_date';
                break;
        }
        $threadList->order($order, 'DESC');

        $threads = $threadList->fetch()->filterViewable()->slice(0, $limit);

        return $this->view('AVForums\PrefixEssentials:PrefixEss\Rss', '', ['prefix' => $threadPrefix, 'threads' => $threads]);
    }
}