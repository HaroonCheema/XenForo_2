<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

use XF\Entity\ProfilePostComment;
use XF\Entity\User;

trait ReplyOnProfilePostComment
{
    protected function shouldHandleProfilePostComment(ProfilePostComment $comment)
    {
        return $this->shouldHandleProfilePost($comment->ProfilePost);
    }

    public function replyOnProfilePostComment(ProfilePostComment $comment, User $author)
    {
        /** @var \BS\AIBots\Service\ChatGPT\ProfilePostCommentReplier $replier */
        $replier = $this->service('BS\AIBots:ChatGPT\ProfilePostCommentReplier', $comment);
        $newPost = $replier->reply($this->bot);
        if ($newPost) {
            // Log thread reply to limit number of replies per thread
            $this->getBotRepo()->logReply(
                $author->user_id,
                'user_profile',
                $comment->ProfilePost->profile_user_id,
                $this->bot->bot_id
            );
        }
        return $newPost;
    }

    protected function hasProfilePostCommentTriggers(ProfilePostComment $comment)
    {
        return $this->hasProfilePostTriggers($comment->ProfilePost);
    }
}