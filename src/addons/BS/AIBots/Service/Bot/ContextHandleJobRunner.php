<?php

namespace BS\AIBots\Service\Bot;

use XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Service\AbstractService;

class ContextHandleJobRunner extends AbstractService
{
    public function runJob(
        Entity $context,
        string $message,
        $authorOrKey = 'User',
        array $with = [],
        bool $logReplies = true
    ) {
        $params = [
            'content_type' => $context->getEntityContentType(),
            'content_id' => $context->getEntityId(),
            'message' => $message,
            'with' => $with,
            'log_replies' => $logReplies,
        ];

        if ($authorOrKey instanceof User) {
            $params['author_id'] = $authorOrKey->user_id;
        } else {
            $params['user_relation_key'] = $authorOrKey;
        }

        $key = substr(
            md5("bsAiBotsHandle_${params['content_type']}_${params['content_id']}"),
            0,
            25
        );
        $this->app->jobManager()->enqueueUnique(
            $key,
            'BS\AIBots:ContextHandle',
            $params
        );
    }
}