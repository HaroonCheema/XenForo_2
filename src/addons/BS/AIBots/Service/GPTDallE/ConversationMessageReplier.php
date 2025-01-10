<?php

namespace BS\AIBots\Service\GPTDallE;

use BS\AIBots\Entity\Bot;
use XF\Mvc\Entity\Entity;

/**
 * @property-read \XF\Entity\ConversationMessage $replyContextItem
 */
class ConversationMessageReplier extends AbstractReplier
{
    protected function postImages(Bot $bot, array $images, array $query): ?Entity
    {
        return $this->replyInConversation(
            $bot,
            (string)\XF::phrase('bs_aib_gpt_dalle_give_message'),
            $this->uploadBase64Images($images, $query)
        );
    }

    protected function postUnsuccessfulMessage(Bot $bot, string $message): ?Entity
    {
        return $this->replyInConversation($bot, $message);
    }

    protected function replyInConversation(
        Bot $bot,
        string $message,
        ?string $attachmentHash = null
    ): ?Entity {
        /** @var \XF\Service\Conversation\Replier $replier */
        $replier = \XF::service('XF:Conversation\Replier', $this->replyContextItem->Conversation, $bot->User);

        if (! $bot->restrictions['spam_check']) {
            $replier->setIsAutomated();
        }

        $replier->setMessageContent($message);

        if ($attachmentHash) {
            $replier->setAttachmentHash($attachmentHash);
        }

        return $replier->save();
    }

    protected function getAttachmentContextForItem(): array
    {
        return ['conversation_id' => $this->replyContextItem->conversation_id];
    }
}