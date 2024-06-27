<?php

namespace FS\ThreadDeleteEdit\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Post extends XFCP_Post
{
    public function actionEditPost(ParameterBag $params)
    {
        $post = $this->assertViewablePost($params->post_id, ['Thread.Prefix']);

        $thread = $post->Thread;

        if ($this->isPost()) {
            $editor = $this->setupPostEdit($post);
            // $editor->checkForSpam();

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

            $viewParams = [
                'post' => $post,
                'thread' => $thread,
                'forum' => $forum,
                'prefixes' => $prefixes,
                'attachmentData' => $attachmentData,
                'quickEdit' => $this->filter('_xfWithData', 'bool')
            ];
            return $this->view('XF:Post\Edit', 'fs_thread_post_edit', $viewParams);
        }
    }

    public function actionDeletePost(ParameterBag $params)
    {
        $post = $this->assertViewablePost($params->post_id);

        if (!$post->canDeletePost()) {
            return $this->noPermission();
        }

        if ($this->isPost()) {
            $type = $this->filter('hard_delete', 'bool') ? 'hard' : 'soft';

            $reason = $this->filter('reason', 'str');

            /** @var \XF\Entity\Thread $thread */
            $thread = $post->Thread;

            /** @var \XF\Service\Post\Deleter $deleter */
            $deleter = $this->service('XF:Post\Deleter', $post);

            if ($this->filter('author_alert', 'bool') && $post->canSendModeratorActionAlert()) {
                $deleter->setSendAlert(true, $this->filter('author_alert_reason', 'str'));
            }

            $deleter->delete($type, $reason);

            $this->plugin('XF:InlineMod')->clearIdFromCookie('post', $post->post_id);

            if ($deleter->wasThreadDeleted()) {
                $this->plugin('XF:InlineMod')->clearIdFromCookie('thread', $post->thread_id);

                return $this->redirect(
                    $thread && $thread->Forum
                        ? $this->buildLink('forums', $thread->Forum)
                        : $this->buildLink('index')
                );
            } else {
                return $this->redirect(
                    $this->getDynamicRedirect($this->buildLink('threads', $thread), false)
                );
            }
        } else {
            $viewParams = [
                'post' => $post,
                'thread' => $post->Thread,
                'forum' => $post->Thread->Forum
            ];
            return $this->view('XF:Post\DeletePost', 'fs_thread_post_delete', $viewParams);
        }
    }
}
