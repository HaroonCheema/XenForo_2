<?php

namespace FS\TractorByNetMyThreads\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
    public function actionForum(ParameterBag $params)
    {

        $parent = parent::actionForum($params);

        $options = \XF::options();
        $visitor = \XF::visitor();

        if ($options->fs_tbn_my_thread_forum_id != $params->node_id) {
            return $parent;
        }

        if (!$visitor->canUseMyThreads()) {
            return $this->noPermission();
        }

        $specificForumId = $options->fs_tbn_my_threads_specific_forum_id;
        $newForum = $this->em()->find("XF:Forum", $specificForumId);

        if (!$newForum) {
            return $parent;
        }

        $forum = $this->assertViewableForum($params->node_id ?: $params->node_name, $this->getForumViewExtraWith());
        $forumTypeHandler = $forum->TypeHandler;

        $overrideReply = $forumTypeHandler->overrideDisplay($forum, $this);
        if ($overrideReply) {
            return $overrideReply;
        }

        $filters = $this->getForumFilterInput($forum);

        $page = $this->filterPage($params->page);
        $perPage = $forumTypeHandler->getThreadsPerPage($forum);

        $this->assertCanonicalUrl($this->buildLink('forums', $forum, ['page' => $page]));

        $threadRepo = $this->getThreadRepo();

        $threadList = $threadRepo->findThreadsForForumView(
            $newForum,
            [
                'allowOwnPending' => $this->hasContentPendingApproval()
            ]
        );
        $this->applyForumFilters($newForum, $threadList, $filters);
        $newForum->TypeHandler->adjustForumThreadListFinder($newForum, $threadList, $page, $this->request);

        $this->applyDateLimitFilters($newForum, $threadList, $filters);

        $threadList->where('sticky', 0)->where('user_id', \XF::visitor()->user_id)
            // $threadList->where('sticky', 0)
            ->limitByPage($page, $perPage);

        /** @var \XF\Entity\Thread[]|\XF\Mvc\Entity\AbstractCollection $threads */
        $threads = $threadList->fetch();
        $totalThreads = $threadList->total();

        $parent->setParams([
            'threads' => $threads,
            'specificForum' => $newForum,
            'total' => $totalThreads
        ]);

        return $parent;
    }

    public function actionPostThread(ParameterBag $params)
    {
        $options = \XF::options();

        if ($params->node_id == $options->fs_tbn_my_thread_forum_id) {
            return $this->noPermission();
        }

        return parent::actionPostThread($params);
    }
}
