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

    public function actionAddReply(ParameterBag $params)
    {
        $this->assertPostOnly();

        $message = $this->plugin('XF:Editor')->fromInput('message');

        $postLinkText =  \XF::phrase('fs_discussion_related_post');

        $pattern = '/^\[QUOTE\](.*?)\[URL=\'[^\']*?posts\/(\d+)\/\'\]' . $postLinkText . '\[\/URL\](.*?)\[\/QUOTE\]/is';

        if (!preg_match($pattern, $message, $matches)) {

            return parent::actionAddReply($params);
        }

        $visitor = \XF::visitor();
        $thread = $this->assertViewableThread($params->thread_id, ['Watch|' . $visitor->user_id]);

        $isPreRegReply = $thread->canReplyPreReg();

        if (!$thread->canReply($error) && !$isPreRegReply) {
            return $this->noPermission($error);
        }

        if (!$isPreRegReply) {
            if ($this->filter('no_captcha', 'bool')) // JS is disabled so user hasn't seen Captcha.
            {
                $this->request->set('requires_captcha', true);
                return $this->rerouteController(__CLASS__, 'reply', $params);
            } else if (!$this->captchaIsValid()) {
                return $this->error(\XF::phrase('did_not_complete_the_captcha_verification_properly'));
            }
        }

        $replier = $this->setupThreadReply($thread);
        $replier->checkForSpam();

        if (!$replier->validate($errors)) {
            return $this->error($errors);
        }
        $this->assertNotFlooding('post');

        if ($isPreRegReply) {
            /** @var \XF\ControllerPlugin\PreRegAction $preRegPlugin */
            $preRegPlugin = $this->plugin('XF:PreRegAction');
            return $preRegPlugin->actionPreRegAction(
                'XF:Thread\Reply',
                $thread,
                $this->getPreRegReplyActionData($replier)
            );
        }

        $post = $replier->save();

        $this->finalizeThreadReply($replier);

        return $this->redirect(
            $this->getDynamicRedirect($this->buildLink('posts', $post), false)
        );

        if ($this->filter('_xfWithData', 'bool') && $this->request->exists('last_date') && $post->canView()) {
            $lastDate = $this->filter('last_date', 'uint');
            if ($this->filter('load_extra', 'bool') && $lastDate) {
                return $this->getNewPostsSinceDateReply($thread, $lastDate);
            } else {
                return $this->getSingleNewPostReply($thread, $post);
            }
        } else {
            $this->getThreadRepo()->markThreadReadByVisitor($thread);
            $confirmation = \XF::phrase('your_message_has_been_posted');

            if ($post->canView()) {
                return $this->redirect($this->buildLink('posts', $post), $confirmation);
            } else {
                return $this->redirect($this->buildLink('threads', $thread, ['pending_approval' => 1]), $confirmation);
            }
        }
    }

    protected function finalizeThreadReply(\XF\Service\Thread\Replier $replier)
    {
        $parent = parent::finalizeThreadReply($replier);

        $post = $replier->getPost();

        $message = $post->message;

        $postLinkText =  \XF::phrase('fs_discussion_related_post');

        $pattern = '/^\[QUOTE\](.*?)\[URL=\'[^\']*?posts\/(\d+)\/\'\]' . $postLinkText . '\[\/URL\](.*?)\[\/QUOTE\]/is';

        if (preg_match($pattern, $message, $matches)) {
            $postId = $matches[2];

            /** @var \XF\Entity\Post $post */
            $quotePost = $this->em()->find('XF:Post', $postId);

            if ($quotePost) {

                $postLink = $baseUrl . "/index.php?posts/" . $quotePost->post_id . "/";

                // $postLink = $this->buildLink('canonical:posts', $quotePost);

                $quoteMessage = $quotePost->message;

                $replaceQuote = "[QUOTE]
		[B][URL='$postLink']" . \XF::phrase('fs_discussion_related_post') . "[/URL][/B]
		" . $quoteMessage . "[/QUOTE]";

                $message = preg_replace($pattern, $replaceQuote, $message);

                $post->bulkSet([
                    'message' => $message
                ]);
                $post->save();
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
