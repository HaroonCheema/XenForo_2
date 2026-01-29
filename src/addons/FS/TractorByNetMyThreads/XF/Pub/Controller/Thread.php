<?php

namespace FS\TractorByNetMyThreads\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

    public function actionEditAd(ParameterBag $params)
    {
        $thread = $this->assertViewableThread($params->thread_id);
        if (!$thread->canEdit($error)) {
            return $this->noPermission($error);
        }
        $forum = $thread->Forum;

        $noInlineMod = $this->filter('_xfNoInlineMod', 'bool');
        $forumName = $this->filter('_xfForumName', 'bool');

        if ($this->isPost()) {
            $editor = $this->setupThreadEdit($thread);

            if (!$editor->validate($errors)) {
                return $this->error($errors);
            }

            $editor->save();

            if ($this->filter('_xfWithData', 'bool') && $this->filter('_xfInlineEdit', 'bool')) {
                $viewParams = [
                    'thread' => $thread,
                    'forum' => $forum,

                    'noInlineMod' => $noInlineMod,
                    'forumName' => $forumName,

                    'templateOverrides' => $forumName ? [] : $forum->TypeHandler->getForumViewTemplateOverrides($forum)
                ];
                $reply = $this->view('XF:Thread\EditInline', 'thread_edit_new_thread', $viewParams);
                $reply->setJsonParam('message', \XF::phrase('your_changes_have_been_saved'));
                return $this->redirect($this->buildLink('my-ads'));
                // return $reply;
            }
            return $this->redirect($this->buildLink('my-ads'));
            // return $this->redirect($this->buildLink('threads', $thread));
        } else {
            $prefix = $thread->Prefix;
            $prefixes = $forum->getUsablePrefixes($prefix);

            $viewParams = [
                'thread' => $thread,
                'forum' => $forum,
                'prefixes' => $prefixes,

                'noInlineMod' => $noInlineMod,
                'forumName' => $forumName
            ];
            return $this->view('XF:Thread\Edit', 'fs_tbn_thread_edit', $viewParams);
        }
    }


    public function actionDeleteAd(ParameterBag $params)
    {
        $thread = $this->assertViewableThread($params->thread_id);
        if (!$thread->canDelete('soft', $error)) {
            return $this->noPermission($error);
        }

        if ($this->isPost()) {
            $type = $this->filter('hard_delete', 'bool') ? 'hard' : 'soft';
            $reason = $this->filter('reason', 'str');

            if (!$thread->canDelete($type, $error)) {
                return $this->noPermission($error);
            }

            /** @var \XF\Service\Thread\Deleter $deleter */
            $deleter = $this->service('XF:Thread\Deleter', $thread);

            if ($this->filter('starter_alert', 'bool')) {
                $deleter->setSendAlert(true, $this->filter('starter_alert_reason', 'str'));
            }

            $deleter->delete($type, $reason);

            $this->plugin('XF:InlineMod')->clearIdFromCookie('thread', $thread->thread_id);

            return $this->redirect($this->buildLink('my-ads'));
        } else {
            $viewParams = [
                'thread' => $thread,
                'forum' => $thread->Forum
            ];
            return $this->view('XF:Thread\Delete', 'fs_tbn_thread_delete', $viewParams);
        }
    }
}
