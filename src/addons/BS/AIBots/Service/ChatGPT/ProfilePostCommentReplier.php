<?php

namespace BS\AIBots\Service\ChatGPT;

use BS\AIBots\Entity\Bot;
use XF\Entity\ProfilePost;
use XF\Mvc\Entity\Entity;

/**
 * @property-read \XF\Entity\ProfilePostComment $replyContextItem
 */
class ProfilePostCommentReplier extends ProfilePostReplier
{
    protected ProfilePost $profilePost;

    public function __construct(\XF\App $app, Entity $replyContextItem)
    {
        parent::__construct($app, $replyContextItem);
        $this->profilePost = $replyContextItem->ProfilePost;
    }

    protected function _postReplies(Bot $bot)
    {
        return $this->postFinalMessage($bot, $this->profilePost);
    }

    protected function buildMessages(Bot $bot, string $context)
    {
        $prompt = $this->getPromptForProfile($bot);
        $contextLimit = $bot->general['bot_profile_context_limit'];
        if (! $contextLimit) {
            return [
                $this->messageRepo->wrapMessage($prompt, 'system'),
                $this->messageRepo->wrapMessage($this->replyContextItem->message)
            ];
        }

        $commentMessages = $this->messageRepo->fetchCommentsFromProfilePost(
            $this->profilePost,
            $this->replyContextItem,
            $bot->User,
            $contextLimit,
            true
        );

        if (count($commentMessages) < $contextLimit) {
            $commentMessages = [
                $this->messageRepo->wrapMessage($this->profilePost->message),
                ...$commentMessages
            ];
        }

        return [
            $this->messageRepo->wrapMessage($prompt, 'system'),
            ...$commentMessages
        ];
    }
}