<?php

namespace FS\LatestThread\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
    public function actionFeatured(ParameterBag $params)
    {
        $visitor = \XF::visitor();
        if (!($visitor->user_id && $visitor->hasPermission('fs_latest_thread', 'can_featured_unfea'))) {
            return $this->noPermission();
        }

        $thread = $this->assertViewableThread($params->thread_id);
        if (!$thread->canWatch($error)) {
            return $this->noPermission($error);
        }

        if ($this->isPost()) {
            if ($this->filter('stop', 'bool')) {
                $thread->fastUpdate('is_featured', false);
            } else {
                $thread->fastUpdate('is_featured', true);
            }

            $redirect = $this->redirect($this->buildLink('threads', $thread));
            $redirect->setJsonParam('switchKey', $this->filter('stop', 'bool') ? 'fs_latest_featured' : 'fs_latest_unfeatured');
            return $redirect;
        } else {
            $viewParams = [
                'thread' => $thread,
                'isFeatured' => !empty($thread->is_featured),
                'forum' => $thread->Forum
            ];
            return $this->view('XF:Thread\Featured', 'fs_latest_thread_featured', $viewParams);
        }
    }
}
