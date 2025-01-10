<?php

namespace BS\AIBots\Service\GPTDallE;

use BS\AIBots\Entity\Bot;
use XF\Entity\ProfilePost;
use XF\Mvc\Entity\Entity;

/**
 * @property-read \XF\Entity\ProfilePost $replyContextItem
 */
class ProfilePostReplier extends AbstractReplier
{
    use \BS\AIBots\Service\Concerns\ProfilePostComment;

    protected function postUnsuccessfulMessage(Bot $bot, string $message): ?Entity
    {
        return $this->postComment($bot, $message);
    }

    protected function postImages(Bot $bot, array $images, array $query): ?Entity
    {
        return $this->postComment(
            $bot,
            (string)\XF::phrase('bs_aib_gpt_dalle_give_message'),
            $this->uploadBase64Images($images, $query)
        );
    }

    protected function postComment(
        Bot $bot,
        string $message,
        ?string $attachmentHash = null,
        ?ProfilePost $profilePost = null
    ): ?Entity {
        $profilePost ??= $this->replyContextItem;

        $creator = $this->setupProfilePostComment(
            $profilePost,
            $message,
            $attachmentHash
        );

        if (! $creator->validate()) {
            return null;
        }

        $comment = $creator->save();
        $this->finalizeProfilePostComment($creator);

        return $comment;
    }

    protected function getAttachmentContextForItem(): array
    {
        return ['profile_post_id' => $this->replyContextItem->profile_post_id];
    }
}