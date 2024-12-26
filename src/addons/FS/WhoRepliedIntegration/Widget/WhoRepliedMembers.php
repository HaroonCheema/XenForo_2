<?php

namespace FS\WhoRepliedIntegration\Widget;

use XF\Widget\AbstractWidget;


class WhoRepliedMembers extends AbstractWidget
{
    public function render()
    {
        $request = $this->app->request();
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

        $finder = \XF::finder('XF:User')->where('user_id', '!=', $thread->user_id)
            ->with('ThreadUserPost|' . $threadId, true)
            ->order("ThreadUserPost|$threadId.post_count", 'DESC')
            ->order('user_id');

        $total = $finder->total();

        $users = $finder->fetch();

        $viewParams = [
            'users'  => $users,
            'thread'  => $thread,

            'total'   => $total ? $total + 1 : 1,
        ];

        return $this->renderer('fs_who_replied_thread_members', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
