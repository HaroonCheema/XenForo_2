<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

use XF\Entity\ProfilePost;
use XF\Entity\User;

trait ReplyOnProfilePost
{
    protected function shouldHandleProfilePost(ProfilePost $profilePost)
    {
        if (! in_array('bot_profile', $this->bot->triggers['active_in_context'], true)) {
            return false;
        }

        if (! $profilePost->isVisible()) {
            return false;
        }

        return true;
    }

    public function replyOnProfilePost(ProfilePost $profilePost, User $author)
    {
        /** @var \BS\AIBots\Service\ChatGPT\ProfilePostReplier $replier */
        $replier = $this->service('BS\AIBots:ChatGPT\ProfilePostReplier', $profilePost);
        $newPost = $replier->reply($this->bot);
        if ($newPost) {
            // Log thread reply to limit number of replies per thread
            $this->getBotRepo()->logReply(
                $author->user_id,
                'user_profile',
                $profilePost->profile_user_id,
                $this->bot->bot_id
            );
        }
        return $newPost;
    }

    protected function hasProfilePostTriggers(ProfilePost $profilePost)
    {
        return $profilePost->profile_user_id === $this->bot->user_id;
    }
}