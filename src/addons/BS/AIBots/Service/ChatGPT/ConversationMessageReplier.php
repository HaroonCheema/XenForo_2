<?php

namespace BS\AIBots\Service\ChatGPT;

use BS\AIBots\Entity\Bot;
use XF\Entity\ConversationMessage;
use XF\Mvc\Entity\Entity;

/**
 * @property ConversationMessage $replyContextItem
 */
class ConversationMessageReplier extends AbstractReplier
{
    protected function _postReplies(Bot $bot)
    {
        /** @var \XF\Service\Conversation\Replier $replier */
        $replier = \XF::service('XF:Conversation\Replier', $this->replyContextItem->Conversation, $bot->User);

        if (! $bot->restrictions['spam_check']) {
            $replier->setIsAutomated();
        }

        $replier->setMessageContent($this->getFinalMessage());

        return $replier->save();
    }

    protected function buildMessages(Bot $bot, string $context)
    {
        $prompt = $this->getPromptForConversation($bot);
        $contextLimit = $bot->general['conversation_context_limit'];
        if (! $contextLimit) {
            $messages = [
                $this->messageRepo->wrapMessage($prompt, 'system'),
                $this->messageRepo->wrapMessage($this->replyContextItem->message)
            ];
            return $this->messageRepo->transformBotQuotesToMessages($messages, $bot->user_id);
        }

        return $this->messageRepo->removeMessageDuplicates([
            $this->messageRepo->wrapMessage($prompt, 'system'),
            ...$this->messageRepo->fetchMessagesFromConversation(
                $this->replyContextItem->Conversation,
                $this->replyContextItem,
                $bot->User,
                $contextLimit,
                true
            )
        ]);
    }

    protected function getPromptForConversation(Bot $bot)
    {
        $tokens = $this->getConversationTokens();
        $prompt = $bot->general['conversation_prompt'];
        $prompt = str_replace(array_keys($tokens), array_values($tokens), $prompt);

        if ($bot->general['conversation_smart_ignore']) {
            $prompt .= PHP_EOL . $this->getSmartIgnorePrompt();
        }

        return $prompt;
    }

    protected function getConversationTokens(): array
    {
        $recipientUsernames = array_column(
            $this->replyContextItem->Conversation->recipients,
            'username'
        );
        return [
            '{conversation_title}' => $this->replyContextItem->Conversation->title,
            '{conversation_id}' => $this->replyContextItem->Conversation->conversation_id,
            '{author}' => $this->replyContextItem->username,
            '{recipients}' => implode(', ', $recipientUsernames),
            '{date}' => date('Y-m-d'),
            '{time}' => date('H:i'),
        ];
    }

    /**
     * @param  \XF\Mvc\Entity\Entity|ConversationMessage  $context
     * @param  string  $content
     * @return string
     */
    protected function makePartialQuote(
        Entity $context,
        string $content
    ): string {
        return "[QUOTE=\"{$context->username}, convMessage: {$context->message_id}, member: {$context->user_id}\"]{$content}[/QUOTE]";
    }
}