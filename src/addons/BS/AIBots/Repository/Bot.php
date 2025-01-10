<?php

namespace BS\AIBots\Repository;

use BS\AIBots\Bot\IBot;
use XF\Mvc\Entity\Repository;

class Bot extends Repository
{
    public function findBots()
    {
        return $this->finder('BS\AIBots:Bot');
    }

    public function findActiveBots()
    {
        return $this->findBots()->where('is_active', 1);
    }

    public function deleteBotsForUser(int $userId)
    {
        $this->db()->delete('xf_bs_ai_bot', 'user_id = ?', $userId);
    }

    public function getBotHandlers(): array
    {
        $handlers = [
            \BS\AIBots\Bot\ChatGPT::class => (string)\XF::phrase('bs_aib_bot_handler.chatgpt'),
            \BS\AIBots\Bot\GPTDallE::class => (string)\XF::phrase('bs_aib_bot_handler.gptdalle'),
        ];

        $this->app()->fire('ai_bot_handlers', [&$handlers]);

        return $handlers;
    }

    public function isValidBotClass(string $class): bool
    {
        return class_exists($class) && is_subclass_of($class, IBot::class);
    }

    public function logReply(
        int $toUserId,
        string $contentType,
        int $contentId,
        int $botId
    ) {
        /** @var \BS\AIBots\Entity\ReplyLog $log */
        $log = $this->app()->em()->create('BS\AIBots:ReplyLog');
        $log->bulkSet([
            'to_user_id' => $toUserId,
            'content_type' => $contentType,
            'content_id' => $contentId,
            'bot_id' => $botId,
        ]);
        $log->save();
    }
}