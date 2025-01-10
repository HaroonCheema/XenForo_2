<?php

namespace BS\AIBots\Service\ChatGPT;

use BS\AIBots\Entity\Bot;
use XF\Entity\Post;
use XF\Mvc\Entity\Entity;

/**
 * @property Post $replyContextItem
 */
class PostReplier extends AbstractReplier
{
    protected array $nodePromptsCache = [];

    protected function setup()
    {
        $this->nodePromptsCache = $this->getNodePromptsRepo()
            ->getPromptsCache();
    }

    protected function _postReplies(Bot $bot)
    {
        /** @var \XF\Service\Thread\Replier $replier */
        $replier = $this->service('XF:Thread\Replier', $this->replyContextItem->Thread);
        $replier->setMessage($this->getFinalMessage());

        // If spam check enabled for bot, then just disable log ip
        // Otherwise, set automated flag
        if ($bot->restrictions['spam_check']) {
            $replier->logIp(false);
        } else {
            $replier->setIsAutomated();
        }

        $post = $replier->save();

        $replier->sendNotifications();

        return $post;
    }

    protected function buildMessages(Bot $bot, string $context)
    {
        $post = $this->replyContextItem;

        $prompt = $this->getPromptForThread($bot);
        $contextLimit = $bot->general['thread_context_limit'];
        if (! $contextLimit) {
            $messages = [
                $this->messageRepo->wrapMessage($prompt, 'system'),
                $this->messageRepo->wrapMessage($post->message)
            ];
            return $this->messageRepo->transformBotQuotesToMessages($messages, $bot->user_id);
        }

        $withLatestMessage = $context !== 'quotes';
        $stopPosition = $withLatestMessage
            ? $post->position
            : max(0, $post->position - 1);
        $startPosition = max(0, $post->position - $contextLimit);
        return $this->messageRepo->removeMessageDuplicates([
            $this->messageRepo->wrapMessage($prompt, 'system'),
            ...$this->messageRepo->fetchMessagesFromThread(
                $post->Thread,
                $stopPosition,
                $bot->User,
                true,
                $startPosition
            )
        ]);
    }

    protected function getPromptForThread(Bot $bot): string
    {
        $nodeId = $this->replyContextItem->Thread->node_id;
        if (isset($this->nodePromptsCache[$bot->bot_id][$nodeId])) {
            $prompt = $this->_getNodeThreadPrompt($bot, $nodeId);
        } else {
            $prompt = $this->_getGlobalThreadPrompt($bot);
        }

        if ($bot->general['thread_smart_ignore']) {
            $prompt .= PHP_EOL . $this->getSmartIgnorePrompt();
        }

        return $prompt;
    }

    protected function _getGlobalThreadPrompt(Bot $bot)
    {
        $prompt = $bot->general['thread_prompt'];
        $tokens = $this->getThreadTokens();
        return str_replace(array_keys($tokens), array_values($tokens), $prompt);
    }

    protected function _getNodeThreadPrompt(Bot $bot, int $nodeId)
    {
        $prompt = $this->nodePromptsCache[$bot->bot_id][$nodeId];
        $tokens = array_merge($this->getThreadTokens(), $this->getNodeTokens());
        return str_replace(array_keys($tokens), array_values($tokens), $prompt);
    }

    protected function getThreadTokens(): array
    {
        return [
            '{thread_title}' => $this->replyContextItem->Thread->title,
            '{thread_id}' => $this->replyContextItem->thread_id,
            '{author}' => $this->replyContextItem->username,
            '{forum_title}' => $this->replyContextItem->Thread->Forum->title,
            '{date}' => date('Y-m-d'),
            '{time}' => date('H:i'),
        ];
    }

    protected function getNodeTokens(): array
    {
        return [
            '{node_id}' => $this->replyContextItem->Thread->node_id,
            '{node_title}' => $this->replyContextItem->Thread->Forum->title,
            '{node_description}' => $this->replyContextItem->Thread->Forum->description,
        ];
    }

    /**
     * @param  \XF\Mvc\Entity\Entity|Post  $context
     * @param  string  $content
     * @return string
     */
    protected function makePartialQuote(
        Entity $context,
        string $content
    ): string {
        return "[QUOTE=\"{$context->username}, post: {$context->post_id}, member: {$context->user_id}\"]{$content}[/QUOTE]";
    }

    /**
     * @return \XF\Mvc\Entity\Repository|\BS\AIBots\Repository\ChatGPTNodePrompt
     */
    protected function getNodePromptsRepo()
    {
        return $this->repository('BS\AIBots:ChatGPTNodePrompt');
    }
}