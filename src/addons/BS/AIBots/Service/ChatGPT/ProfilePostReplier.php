<?php

namespace BS\AIBots\Service\ChatGPT;

use BS\AIBots\Entity\Bot;
use XF\Entity\ProfilePost;
use XF\Mvc\Entity\Entity;

/**
 * @property-read \XF\Entity\ProfilePost $replyContextItem
 */
class ProfilePostReplier extends AbstractReplier
{

    use \BS\AIBots\Service\Concerns\ProfilePostComment;

    protected function _postReplies(Bot $bot)
    {
        return $this->postFinalMessage($bot);
    }

    protected function postFinalMessage(Bot $bot, ?ProfilePost $profilePost = null)
    {
        $profilePost ??= $this->replyContextItem;

        $creator = $this->setupProfilePostComment(
            $profilePost,
            $this->getFinalMessage(),
        );

        if ($bot->restrictions['spam_check']) {
            $creator->checkForSpam();
        }

        if (! $creator->validate()) {
            return null;
        }

        $comment = $creator->save();
        $this->finalizeProfilePostComment($creator);

        return $comment;
    }

    protected function buildMessages(Bot $bot, string $context)
    {
        return [
            $this->messageRepo->wrapMessage($this->getPromptForProfile($bot), 'system'),
            $this->messageRepo->wrapMessage($this->replyContextItem->message)
        ];
    }

    protected function makePartialQuote(Entity $context, string $content): string
    {
        return '';
    }

    protected function getPromptForProfile(Bot $bot)
    {
        $tokens = $this->getProfileTokens();
        return str_replace(array_keys($tokens), array_values($tokens), $bot->general['bot_profile_prompt']);
    }

    protected function getProfileTokens(): array
    {
        return [
            '{author}' => $this->replyContextItem->username,
            '{date}' => date('Y-m-d'),
            '{time}' => date('H:i'),
        ];
    }
}