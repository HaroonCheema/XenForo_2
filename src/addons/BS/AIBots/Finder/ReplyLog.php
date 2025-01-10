<?php

namespace BS\AIBots\Finder;

use BS\AIBots\Entity\Bot;
use XF\Entity\User;
use XF\Mvc\Entity\Finder;

class ReplyLog extends Finder
{
    public function toUser(User $user): self
    {
        $this->where('to_user_id', $user->user_id);

        return $this;
    }

    public function byBot(Bot $bot): self
    {
        $this->where('bot_id', $bot->bot_id);

        return $this;
    }

    public function forThisDay()
    {
        $this->where('reply_date', '>=', strtotime('today midnight'));

        return $this;
    }

    public function forEntity($entity)
    {
        $this->where('content_type', $entity->getEntityContentType());
        $this->where('content_id', $entity->getEntityId());

        return $this;
    }

    public function forContentType(string $contentType, int $contentId = null)
    {
        $this->where('content_type', $contentType);
        if ($contentId) {
            $this->where('content_id', $contentId);
        }

        return $this;
    }
}