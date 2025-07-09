<?php

namespace FS\DiscussionThread\XF\Pub\Controller;

use XF\Pub\Controller\AbstractController;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
    public function actionIndex(ParameterBag $params)
    {
        $parent = parent::actionIndex($params);

        if ($parent instanceof \XF\Mvc\Reply\View) {
            $thread = $parent->getParam('thread');
            $applicableForumIds = \XF::options()->dt_applicable_forums_discussion;

            if (in_array($thread->node_id, $applicableForumIds)) {
                //Fetching latest 5 posts in main thread from its discussion thread
                $postsFinder = null;
                if ($thread->disc_thread_id) {
                    $postsFinder = $this->finder('XF:Post')
                        ->where('thread_id', $thread->disc_thread_id)
                        ->where('position', '>', 0)
                        ->where('message_state', 'visible')
                        ->order('post_date', 'desc')
                        ->limit(5)
                        ->fetch();
                }
                $parent->setParam('discPosts', $postsFinder);
            }
        }

        return $parent;
    }

    public function actionDiscussionThread(ParameterBag $params)
    {
        $mainThread = $this->assertThreadExists($params->thread_id);

        $dtUnreadPostLink = \XF::options()->dtUnreadPostLink;

        //Discussion thread found
        if ($mainThread->DiscThread) {
            if ($dtUnreadPostLink)
                return $this->redirect($this->buildLink('threads/unread', $mainThread->DiscThread));
            else
                return $this->redirect($this->buildLink('threads', $mainThread->DiscThread));
        } else {
            //Discussion thread not found

            if (!$mainThread->Forum->Node->disc_node_id)
                return $this->error(\XF::phrase('discussion_forum_was_not_created'));

            /*

            // *** Old query ***
            $title = \XF::phrase('discussion_x', ['x' => $mainThread->title])->render();
            //$title = mb_strtolower(str_replace(' ', '', $title));
            $title = str_replace(' ', '', $title);
            
            $discThreadId = \XF::db()->fetchOne("
                SELECT thread_id
                FROM xf_thread
                WHERE node_id = ?
                  AND discussion_state = 'visible'
                  AND REPLACE(title, ' ', '') = ?
                ORDER BY post_date DESC LIMIT 1
            ",[$mainThread->Forum->Node->disc_node_id, $title]);

            $discThread = $this->em()->find('XF:Thread', $discThreadId);

            //old query
            $title1 = \XF::phrase('fs_dt_discussion1', ['x' => $mainThread->title])->render();
            $title2 = \XF::phrase('fs_dt_discussion2', ['x' => $mainThread->title])->render();
            $title3 = \XF::phrase('fs_dt_discussion3', ['x' => $mainThread->title])->render();
            $title4 = \XF::phrase('fs_dt_discussion4', ['x' => $mainThread->title])->render();

            $discThreadFinder = $this->finder('XF:Thread')
                ->where('node_id', $mainThread->Forum->Node->disc_node_id)
                ->where('discussion_state', 'visible');

            $whereOr = [
                ['title', 'like',$discThreadFinder->escapeLike($title1, '%?%')],
                ['title', 'like',$discThreadFinder->escapeLike($title2, '%?%')],
                ['title', 'like',$discThreadFinder->escapeLike($title3, '%?%')],
                ['title', 'like',$discThreadFinder->escapeLike($title4, '%?%')]];

            $discThread = $discThreadFinder
                ->whereOr($whereOr)
                ->order('post_date', 'DESC')
                ->fetchOne();
            */

            // *** New query ****
            $dtThreadTitlePrefix = \XF::options()->dtThreadTitlePrefix;
            $prefixes = array_map('trim', explode(',', $dtThreadTitlePrefix));

            $discThreadFinder = $this->finder('XF:Thread')
                ->where('node_id', $mainThread->Forum->Node->disc_node_id)
                ->where('discussion_state', 'visible');

            $whereOr = [];

            foreach ($prefixes as $prefix) {
                $variations = [
                    $prefix . ':'  . $mainThread->title,
                    $prefix . ' :' . $mainThread->title,
                    $prefix . ': ' . $mainThread->title,
                    $prefix . ' : ' . $mainThread->title,
                ];

                foreach ($variations as $variation) {
                    $whereOr[] = ['title', 'like', $discThreadFinder->escapeLike($variation, '%?%')];
                }
            }

            $discThread = $discThreadFinder
                ->whereOr($whereOr)
                ->order('post_date', 'DESC')
                ->fetchOne();

            //Discussion thread found
            if ($discThread) {
                $mainThread->fastUpdate('disc_thread_id', $discThread->thread_id);
                $this->discThreadPost($mainThread);

                if ($dtUnreadPostLink)
                    return $this->redirect($this->buildLink('threads/unread', $discThread));
                else
                    return $this->redirect($this->buildLink('threads', $discThread));
            }
            //Discussion thread not found
            else {
                //Create New disc thread
                $discThread = $this->createThread($mainThread);
                return $this->redirect($this->buildLink('threads', $discThread));
            }
        }
    }

    private function createThread($mainThread)
    {
        $forum = $this->assertForumExists($mainThread->Forum->Node->disc_node_id);

        $discThreadUser = \XF::app()->em()->find('XF:User', \XF::options()->dtDiscThreadUserId);

        //$staffUser = $this->finder('XF:User')->where('is_moderator', 1)->where('is_admin', 1)->where('is_staff', 1)->order('username')->fetchone();

        $dtThreadTitlePrefixCreate = \XF::options()->dtThreadTitlePrefixCreate;

        $creator = $this->service('XF:Thread\Creator', $forum);

        if ($discThreadUser)
            $creator->setDiscThreadUser($discThreadUser);

        //$creator->setContent(\XF::phrase('discussion_x', ['x' => $mainThread->title]),'disc_first_post');
        $creator->setContent($dtThreadTitlePrefixCreate . ': ' . $mainThread->title, 'disc_first_post');

        $creator->setIsAutomated();
        $creator->setDiscussionState('visible');
        $creator->setDiscussionOpen(true);
        $creator->setCustomFields([]);

        // Save the thread
        if (!$creator->validate($errors)) {
            throw new \XF\PrintableException(implode(', ', $errors));
        }

        $discThread = $creator->save();
        $discThread->fastUpdate('sticky_post', 1);
        $mainThread->fastUpdate('disc_thread_id', $discThread->thread_id);

        $this->discThreadPost($mainThread);

        return $discThread;
    }

    private function discThreadPost($mainThread)
    {
        //All main threads with same title in node
        $mainThreadsSameTitle = $this->finder('XF:Thread')
            ->where('node_id', $mainThread->node_id)
            ->where('main_thread_ids', null)     //Find in all Main Threads
            ->where('title', $mainThread->title)
            ->fetch();

        $discFirstPost = $mainThread->DiscThread->FirstPost;

        $router = \XF::app()->router('public');
        $related = '';

        foreach ($mainThreadsSameTitle as $i => $thread) {
            $num = $i + 1;
            $threadUrl = $router->buildLink('full:threads', $thread);
            $forumUrl = $router->buildLink('full:forums', $thread->Forum);
            $threadTitle = $thread->title;
            $forumTitle = $thread->Forum->title;

            $related .= "[URL={$threadUrl}]{$threadTitle}[/URL] in forum [URL={$forumUrl}]{$forumTitle}[/URL]\n";
        }
        $mainThread->DiscThread->FirstPost->fastUpdate('message', \XF::phrase('fs_dt_post_message', ['title' => $mainThread->DiscThread->title, 'text' => \XF::options()->dtFirstPostMessage, 'related' => $related]));
        $mainThread->DiscThread->fastUpdate('main_thread_ids', $mainThreadsSameTitle->pluckNamed('thread_id'));
    }

    protected function assertThreadExists($id, $with = null, $phraseKey = null): \XF\Entity\Thread
    {
        return $this->assertRecordExists('XF:Thread', $id, $with, $phraseKey);
    }

    protected function assertForumExists($id, $with = null, $phraseKey = null): \XF\Entity\Forum
    {
        return $this->assertRecordExists('XF:Forum', $id, $with, $phraseKey);
    }
}
