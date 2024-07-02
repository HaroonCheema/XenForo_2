<?php

namespace BS\XFMessenger\XF\Service\Conversation;

use BS\XFMessenger\Broadcasting\Broadcast;
use BS\XFWebSockets\Request;

class MessageManager extends XFCP_MessageManager
{
    public function afterInsert()
    {
        parent::afterInsert();
        Broadcast::newMessage($this->conversationMessage, Request::getPageUid());
    }
}
