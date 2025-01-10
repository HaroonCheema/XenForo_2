<?php

namespace BS\AIBots\Service\GPTDallE;

use BS\AIBots\Entity\Bot;
use XF\Mvc\Entity\Entity;

/**
 * @property-read \XF\Entity\Post $replyContextItem
 */
class PostReplier extends AbstractReplier
{
    protected function postImages(Bot $bot, array $images, array $query): ?Entity
    {
        return $this->replyInThread(
            $bot,
            (string)\XF::phrase('bs_aib_gpt_dalle_give_message'),
            $this->uploadBase64Images($images, $query)
        );
    }

    protected function postUnsuccessfulMessage(Bot $bot, string $message): ?Entity
    {
        return $this->replyInThread($bot, $message);
    }

    protected function replyInThread(
        Bot $bot,
        string $message,
        ?string $attachmentHash = null
    ): ?Entity {
        /** @var \XF\Service\Thread\Replier $replier */
        $replier = $this->service('XF:Thread\Replier', $this->replyContextItem->Thread);
        $replier->setMessage($message);

        if ($attachmentHash) {
            $replier->setAttachmentHash($attachmentHash);
        }

        // If spam check enabled for bot, then just disable log ip
        // Otherwise, set automated flag
        if ($bot->restrictions['spam_check']) {
            $replier->logIp(false);
        } else {
            $replier->setIsAutomated();
        }

        /** @var \XF\Entity\Post $post */
        $post = $replier->save();

        $replier->sendNotifications();

        return $post;
    }

    protected function getAttachmentContextForItem(): array
    {
        return ['thread_id' => $this->replyContextItem->thread_id];
    }
}