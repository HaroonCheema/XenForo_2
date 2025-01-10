<?php

namespace BS\AIBots\XF\Entity;

class Thread extends XFCP_Thread
{
    public function canToggleAiBots(): bool
    {
        $visitor = \XF::visitor();

        $canToggleInOwnThreads = $visitor->hasNodePermission($this->node_id, 'bsAibToggleBots');
        $ownThreadOrInserting = $this->user_id === $visitor->user_id || $this->isInsert();
        if ($ownThreadOrInserting && $canToggleInOwnThreads) {
            return true;
        }

        return $visitor->hasNodePermission($this->node_id, 'bsAibToggleBotsAny');
    }
}