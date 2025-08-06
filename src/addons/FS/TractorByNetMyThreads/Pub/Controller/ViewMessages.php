<?php

namespace FS\TractorByNetMyThreads\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class ViewMessages extends AbstractController
{
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertRegistrationRequired();
    }

    public function actionMessages(ParameterBag $params)
    {
        $options = \XF::options();

        if (!$options->fs_tbn_my_thread_forum_id || !$options->fs_tbn_my_threads_specific_forum_id) {
            return $this->noPermission();
        }

        $applicableForumId = $options->fs_tbn_my_threads_specific_forum_id;

        $forum = \XF::app()->em()->find('XF:Node', $applicableForumId);

        if (!$forum) {
            return $this->notFound();
        }

        // $threadRepo = $this->repository('XF:Thread');

        // $threads = $threadRepo->findThreadsForForumView(
        //     $forum,
        //     [
        //         'allowOwnPending' => $this->hasContentPendingApproval()
        //     ]
        // );

        $page = $params->page ?? 1;
        $perPage = 15;
        $paginatedThreads = '';
        $unreadThreads = array();

        // $threads = $this->finder("XF:Thread")->where("node_id", $forum->node_id)->where('sticky', 0)->fetch();
        $threads = $this->finder("XF:Thread")->where("node_id", $forum->node_id)->where('sticky', 0)->where('user_id', \XF::visitor()->user_id)->fetch();

        if ($threads) {

            foreach ($threads as $key => $thread) {
                $readDate = $thread->getVisitorReadDate();

                $unReadPosts = $this->finder("XF:Post")->where('thread_id', $thread->thread_id)->where('post_date', '>', $readDate)->total();

                if ($unReadPosts) {
                    $finder = $this->finder('XF:Post')->where('thread_id', $thread->thread_id);

                    $participantsIds = $finder->pluckfrom('user_id')->fetch()->toArray();

                    $participantsIds = array_unique($participantsIds);

                    $unreadThreads[$key]["thread"] = $thread;
                    $unreadThreads[$key]["unReadPostsCount"] = $unReadPosts;
                    $unreadThreads[$key]["participants"] = count($participantsIds);
                }
            }

            $offset = ($page - 1) * $perPage;

            $paginatedThreads = array_slice($unreadThreads, $offset, $perPage);
        }

        $viewParams = [
            'unreadThreads' => $paginatedThreads ?? '',

            'page' => $page,
            'perPage' => $perPage,
            'total' => count($unreadThreads),
        ];
        return $this->view('FS\TractorByNetMyThreads:ViewMessages\Messages', 'fs_my_ads_view_messages', $viewParams);
    }
}
