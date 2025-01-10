<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

use XF\Entity\ConversationMessage;
use XF\Entity\User;

trait ReplyOnConversationMessage
{
    public function shouldHandleConversationMessage(ConversationMessage $message): bool
    {
        if (! in_array('conversation', $this->bot->triggers['active_in_context'], true)) {
            return false;
        }

        $conversation = $message->Conversation;
        return \XF::asVisitor($this->bot->User, fn () => $conversation->canView());
    }

    public function replyOnConversationMessage(ConversationMessage $message, User $author)
    {
        /** @var \BS\AIBots\Service\ChatGPT\ConversationMessageReplier $replier */
        $replier = $this->service('BS\AIBots:ChatGPT\ConversationMessageReplier', $message);
        $newMessage = $replier->reply($this->bot);
        if ($newMessage) {
            // Log thread reply to limit number of replies per thread
            $this->getBotRepo()->logReply(
                $author->user_id,
                'conversation',
                $message->conversation_id,
                $this->bot->bot_id
            );
        }
        return $newMessage;
    }

    protected function hasConversationMessageTriggers(ConversationMessage $convMessage)
    {
        $convMaster = $convMessage->Conversation;
        $message = $convMessage->message;

        $shouldTriggerOnQuote = in_array('quote', $this->bot->triggers['conversation'], true);
        $shouldTriggerOnMention = in_array('mention', $this->bot->triggers['conversation'], true);
        $shouldTriggerOnPrivateAppeal = in_array('private_appeal', $this->bot->triggers['conversation'], true);

        $hasQuoteTrigger = $shouldTriggerOnQuote && $this->hasQuotes($message, $this->bot->user_id);
        $hasMentionTrigger = $shouldTriggerOnMention && $this->wasMentioned($message, $this->bot->user_id);
        $hasPrivateAppealTrigger = $shouldTriggerOnPrivateAppeal
            // we can skip checks for bot participant because it's already checked in shouldHandleConversationMessage
            && $convMaster->recipient_count === 2;

        return $hasQuoteTrigger || $hasMentionTrigger || $hasPrivateAppealTrigger;
    }
}