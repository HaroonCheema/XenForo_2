<?php

namespace FS\ThreadPostLinkNotification\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Thread extends XFCP_Thread
{

    protected function finalizeThreadReply(\XF\Service\Thread\Replier $replier)
    {
        $parent = parent::finalizeThreadReply($replier);

        $post = $replier->getPost();
        $visitor = \XF::visitor();

        $message = $post->message;

        if (
            preg_match('#\[URL(?:=[^\]]+)?(?:\s+[^\]]+)?\].*?\[/URL\]#i', $message) ||
            preg_match('#https?://[^\s]+#i', $message)
        ) {

            $adminIds = \XF::options()->fs_thread_post_link_user_ids;

            if ($adminIds) {
                $adminIds = array_map('trim', explode(',', $adminIds));

                $users = \XF::finder('XF:User')->where('user_id', $adminIds)->fetch();

                foreach ($users as $user) {

                    /** @var \XF\Repository\UserAlert $alertRepo */
                    $alertRepo = $this->repository('XF:UserAlert');

                    $alertRepo->alertFromUser(
                        $user,
                        $visitor,
                        'post',
                        $post->post_id,
                        'thread_link'
                    );
                }
            }
        }

        return $parent;
    }
}
