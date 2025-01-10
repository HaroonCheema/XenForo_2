<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

use XF\Entity\Post;
use XF\Entity\User;

trait ReplyOnPost
{
    protected function shouldHandlePost(Post $post)
    {
        if (! in_array('thread', $this->bot->triggers['active_in_context'], true)) {
            return false;
        }

        if (! $post->isVisible()) {
            return false;
        }

        $restrictions = $this->bot->restrictions;

        $thread = $post->Thread;
        // Reply only if thread is visible
        if (! $thread->isVisible()) {
            return false;
        }

        if (! in_array($thread->node_id, $restrictions['active_node_ids'])) {
            return false;
        }

        return true;
    }

    public function replyOnPost(Post $post, User $author)
    {
        /** @var \BS\AIBots\Service\ChatGPT\PostReplier $replier */
        $replier = $this->service('BS\AIBots:ChatGPT\PostReplier', $post);
        $newPost = $replier->reply($this->bot);
        if ($newPost) {
            // Log thread reply to limit number of replies per thread
            $this->getBotRepo()->logReply(
                $author->user_id,
                'thread',
                $post->thread_id,
                $this->bot->bot_id
            );
        }
        return $newPost;
    }

    protected function hasPostTriggers(Post $post)
    {
        $message = $post->message;

        $shouldTriggerOnQuote = in_array('quote', $this->bot->triggers['post'], true);
        $shouldTriggerOnMention = in_array('mention', $this->bot->triggers['post'], true);
        $postedInNodeIds = $this->bot->triggers['posted_in_node_ids'];

        $hasQuoteTrigger = $shouldTriggerOnQuote && $this->hasQuotes($message, $this->bot->user_id, 'post');
        $hasMentionTrigger = $shouldTriggerOnMention && $this->wasMentioned($message, $this->bot->user_id);
        $hasNodeTrigger = in_array($post->Thread->node_id, $postedInNodeIds);

        return $hasQuoteTrigger || $hasMentionTrigger || $hasNodeTrigger;
    }
}