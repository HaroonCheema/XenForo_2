<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

use BS\ChatGPTBots\Repository\Message;

trait Triggers
{
    protected Message $messageRepo;

    protected function setupMessageRepo()
    {
        $this->messageRepo = \XF::repository('BS\ChatGPTBots:Message');
    }

    protected function hasQuotes(string $message, int $userId): bool
    {
        return ! empty($this->messageRepo->getQuotes($message, $userId));
    }

    protected function wasMentioned(string $message, int $userId): bool
    {
        return in_array($userId, $this->parseMentionedUsers($message));
    }

    protected function parseMentionedUsers(string $message): array
    {
        preg_match_all('/\[user=(\d+)\]/i', $message, $matches);
        return $matches[1] ?? [];
    }

    protected function removeMentions(string $message): string
    {
        return preg_replace('/\[user=\d+]|\[\/user]/i', '', $message);
    }

    protected function isMatchingRegexes(string $message, array $regexes)
    {
        foreach ($regexes as $regex) {
            if (preg_match($regex, $message)) {
                return true;
            }
        }

        return false;
    }
}