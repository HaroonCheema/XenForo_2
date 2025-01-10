<?php

namespace BS\AIBots\Service\GPTDallE;

use BS\AIBots\Entity\Bot;
use XF\App;
use XF\Entity\ProfilePost;
use XF\Mvc\Entity\Entity;

/**
 * @property-read \XF\Entity\ProfilePostComment $replyContextItem
 */
class ProfilePostCommentReplier extends ProfilePostReplier
{
    protected ProfilePost $profilePost;

    public function __construct(App $app, Entity $replyContextItem)
    {
        parent::__construct($app, $replyContextItem);
        $this->profilePost = $replyContextItem->ProfilePost;
    }

    protected function postUnsuccessfulMessage(Bot $bot, string $message): ?Entity
    {
        return $this->postComment($bot, $message, $this->profilePost);
    }

    protected function postImages(Bot $bot, array $images, array $query): ?Entity
    {
        return $this->postComment(
            $bot,
            (string)\XF::phrase('bs_aib_gpt_dalle_give_message'),
            $this->uploadBase64Images($images, $query),
            $this->profilePost
        );
    }

    protected function getAttachmentContextForItem(): array
    {
        return ['profile_post_id' => $this->profilePost->profile_post_id];
    }
}