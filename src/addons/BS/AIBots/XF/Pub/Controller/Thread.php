<?php

namespace BS\AIBots\XF\Pub\Controller;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

class Thread extends XFCP_Thread
{
    public function actionToggleAiBots(ParameterBag $params)
    {
        $this->assertPostOnly();

        $thread = $this->assertViewableThread($params->thread_id);

        if (! $thread->canToggleAiBots()) {
            return $this->noPermission();
        }

        $thread->bs_aib_enable_bots = !$thread->bs_aib_enable_bots;
        $thread->save();

        $reply = $this->redirect($this->getDynamicRedirect());
        $reply->setJsonParams([
            'text' => \XF::phrase(
                $thread->bs_aib_enable_bots
                    ? 'bs_aib_disable_ai_bots'
                    : 'bs_aib_enable_ai_bots'
            ),
            'enabled' => $thread->bs_aib_enable_bots
        ]);
        return $reply;
    }
}