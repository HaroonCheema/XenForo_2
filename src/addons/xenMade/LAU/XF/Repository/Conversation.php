<?php

namespace xenMade\LAU\XF\Repository;

class Conversation extends XFCP_Conversation
{
    public function markUserConversationRead(\XF\Entity\ConversationUser $userConv, $newRead = null)
    {
        $session = \XF::app()->session();

        if(!$session->exists())
        {
            parent::markUserConversationRead($userConv, $newRead);
        }

        if(
            $session->offsetExists('lau_id') &&
            $session->offsetExists('lau_stealth')
        )
        {
            return;
        }

        parent::markUserConversationRead($userConv, $newRead);
    }
}