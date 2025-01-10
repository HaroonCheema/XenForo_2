<?php

namespace BS\AIBots\XF\Pub\Controller;

class Forum extends XFCP_Forum
{
    protected function setupThreadCreate(\XF\Entity\Forum $forum)
    {
        $creator = parent::setupThreadCreate($forum);

        if (! $creator->getThread()->canToggleAiBots()) {
            return $creator;
        }

        $thread = $creator->getThread();
        $thread->bs_aib_enable_bots = $this->filter('bs_aib_enable_bots', 'bool');

        return $creator;
    }
}