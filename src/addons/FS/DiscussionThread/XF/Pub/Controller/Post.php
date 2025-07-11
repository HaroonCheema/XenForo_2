<?php

namespace FS\DiscussionThread\XF\Pub\Controller;

use XF\Pub\Controller\AbstractController;

use XF\Mvc\ParameterBag;

class Post extends XFCP_Post
{
    public function actionComment(ParameterBag $params)
    {
        $post = $this->assertViewablePost($params->post_id);

        if (!$post->Thread->DiscThread || !$post->Thread->canCommentDiscussion()) {
            return $this->noPermission();
        }

        $discThread = $post->Thread->DiscThread;

        $postLink = $this->buildLink('canonical:posts', $post);

        $quoteMessage = $post->message;

        $visitor = \XF::visitor();

        $mediaTags = $this->Finder('FS\MediaTagSetting:MediaTag')->order('id', 'Desc')->fetch();

        $userGroupFinder =  \XF::finder('XF:UserGroup')->order('user_group_id', 'Asc');

        $userGroupIds = $userGroupFinder->fetchColumns('user_group_id');

        $userIds = array();
        foreach ($userGroupIds as $value) {
            array_push($userIds, strval($value['user_group_id']));
        }

        foreach ($mediaTags as $mediaTag) {

            $unselected = array_diff($userIds, $mediaTag->user_group_ids);

            if ($visitor->isMemberOf($unselected)) {
            } else
            if ($visitor->isMemberOf($mediaTag->user_group_ids)) {
                $quoteMessage = $this->removeMediaTags($quoteMessage, $mediaTag);
            }
        }

        $message = "[QUOTE]
        [B][URL='$postLink']" . \XF::phrase('fs_discussion_related_post') . "[/URL][/B]
        " . $quoteMessage . "[/QUOTE]";

        $draft = $discThread->draft_reply;

        $draft->message = $message;
        $draft->extra_data = [];
        $draft->save();

        $dtUnreadPostLink = \XF::options()->dtUnreadPostLink;

        if ($dtUnreadPostLink)
            return $this->redirect($this->buildLink('threads/unread', $discThread));
        else
            return $this->redirect($this->buildLink('threads', $discThread));
    }

    public function actionEdit(ParameterBag $params)
    {
        $post = $this->assertViewablePost($params->post_id, ['Thread.Prefix']);

        $message = $post->message;

        $postLinkText =  \XF::phrase('fs_discussion_related_post');

        $pattern = '/^\[QUOTE\](.*?)\[URL=\'[^\']*?posts\/(\d+)\/\'\]' . $postLinkText . '\[\/URL\](.*?)\[\/QUOTE\]/is';

        if (!preg_match($pattern, $message, $matches)) {

            return parent::actionEdit($params);
        }

        if (!$post->canEdit($error)) {
            return $this->noPermission($error);
        }

        $thread = $post->Thread;

        if ($this->isPost()) {
            $editor = $this->setupPostEdit($post);
            $editor->checkForSpam();

            if ($post->isFirstPost() && $thread->canEdit()) {
                $threadEditor = $this->setupFirstPostThreadEdit($thread, $threadChanges);
                $editor->setThreadEditor($threadEditor);
            } else {
                $threadEditor = null;
                $threadChanges = [];
            }

            if (!$editor->validate($errors)) {
                return $this->error($errors);
            }

            $editor->save();

            $this->finalizePostEdit($editor, $threadEditor);

            $message = $post->message;

            $postLinkText =  \XF::phrase('fs_discussion_related_post');

            $pattern = '/^\[QUOTE\](.*?)\[URL=\'[^\']*?posts\/(\d+)\/\'\]' . $postLinkText . '\[\/URL\](.*?)\[\/QUOTE\]/is';

            if (preg_match($pattern, $message, $matches)) {
                $postId = $matches[2];

                /** @var \XF\Entity\Post $post */
                $quotePost = $this->em()->find('XF:Post', $postId);

                if ($quotePost) {

                    $postLink = $this->buildLink('canonical:posts', $quotePost);

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

            return $this->redirect($this->buildLink('posts', $post));

            if ($this->filter('_xfWithData', 'bool') && $this->filter('_xfInlineEdit', 'bool')) {
                $threadPlugin = $this->plugin('XF:Thread');
                $threadPlugin->fetchExtraContentForPostsFullView([$post->post_id => $post], $thread);

                $typeHandler = $thread->TypeHandler;

                $viewParams = [
                    'post' => $post,
                    'thread' => $thread,
                    'isPinnedFirstPost' => $post->isFirstPost() && $typeHandler->isFirstPostPinned($thread),
                    'templateOverrides' => $typeHandler->getThreadViewTemplateOverrides($thread)
                ];

                $reply = $this->view('XF:Post\EditNewPost', 'post_edit_new_post', $viewParams);
                $reply->setJsonParams([
                    'message' => \XF::phrase('your_changes_have_been_saved'),
                    'threadChanges' => $threadChanges
                ]);
                return $reply;
            } else {
                return $this->redirect($this->buildLink('posts', $post));
            }
        } else {
            /** @var \XF\Entity\Forum $forum */
            $forum = $post->Thread->Forum;
            if ($forum->canUploadAndManageAttachments()) {
                /** @var \XF\Repository\Attachment $attachmentRepo */
                $attachmentRepo = $this->repository('XF:Attachment');
                $attachmentData = $attachmentRepo->getEditorData('post', $post);
            } else {
                $attachmentData = null;
            }

            $prefix = $thread->Prefix;
            $prefixes = $forum->getUsablePrefixes($prefix);

            $quotePost = $post;

            $visitor = \XF::visitor();

            $mediaTags = $this->Finder('FS\MediaTagSetting:MediaTag')->order('id', 'Desc')->fetch();

            $userGroupFinder =  \XF::finder('XF:UserGroup')->order('user_group_id', 'Asc');

            $userGroupIds = $userGroupFinder->fetchColumns('user_group_id');

            $userIds = array();
            foreach ($userGroupIds as $value) {
                array_push($userIds, strval($value['user_group_id']));
            }

            foreach ($mediaTags as $mediaTag) {

                $unselected = array_diff($userIds, $mediaTag->user_group_ids);

                if ($visitor->isMemberOf($unselected)) {
                } else
                if ($visitor->isMemberOf($mediaTag->user_group_ids)) {
                    $quotePost->message = $this->removeMediaTags($quotePost->message, $mediaTag);
                }
            }

            $viewParams = [
                'post' => $quotePost,
                'thread' => $thread,
                'forum' => $forum,
                'prefixes' => $prefixes,
                'attachmentData' => $attachmentData,
                'quickEdit' => $this->filter('_xfWithData', 'bool'),
                'removeAjax' => true
            ];
            return $this->view('XF:Post\Edit', 'post_edit', $viewParams);
        }
    }

    public function removeMediaTags($message, \FS\MediaTagSetting\Entity\MediaTag $mediaTag)
    {
        $patterns = [];

        foreach ($mediaTag->media_site_ids as $mediaId) {
            $patterns[] = '#\[media=' . $mediaId . '([^\[]*?)\[/media\]#i';
        }

        return preg_replace($patterns, '[fs_custom_msg]' . $mediaTag->custom_message . '[/fs_custom_msg]', $message);
    }
}
