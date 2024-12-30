<?php

namespace FS\WhoRepliedIntegration\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{

    public function getThisThreadUsers()
    {
        $request = \XF::app()->request();
        $threadId = 0;

        $currentUrl = $request->getRequestUri();

        $routeMatched = '/threads\/[\w-]+\.(\d+)\/?/';

        if (preg_match($routeMatched, $currentUrl, $matches)) {
            $threadId = $matches[1];
        } else {
            return false;
        }

        $thread = \XF::em()->find('XF:Thread', $threadId);

        if (!$thread || !in_array($thread['node_id'], \XF::options()->fs_who_replied_forums_allowed)) {
            return false;
        }

        $currentThreadId = $this->thread_id;

        $finder = \XF::finder('XF:User')->where('user_id', '!=', $thread->user_id)
            ->with('ThreadUserPost|' . $currentThreadId, true)
            ->order("ThreadUserPost|$currentThreadId.post_count", 'DESC')
            ->order('user_id');

        $userExist = \XF::finder('XF:Post')->where('thread_id', $currentThreadId)->where('user_id', $thread->user_id)->fetchOne();

        // $total = $finder->total();

        $users = $finder->fetch();

        $viewParams = [
            'users'  => $users,
            'currentThread'  => $userExist ? $thread : false,

            // 'total'   => $total ? $total + 1 : 1,
        ];

        return $viewParams;
    }
}
