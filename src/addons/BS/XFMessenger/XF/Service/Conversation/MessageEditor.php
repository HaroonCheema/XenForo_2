<?php

namespace BS\XFMessenger\XF\Service\Conversation;

use XF\Entity\ConversationMessage;
use \XF\Service\ValidateAndSavableTrait;

class MessageEditor extends XFCP_MessageEditor
{
    protected function finalSetup()
    {
        parent::finalSetup();

        $this->message->xfm_last_edit_date = \XF::$time;
    }
}
