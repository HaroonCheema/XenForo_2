<?php

namespace BS\AIBots;

use XF\Entity\ConversationMessage;
use XF\Entity\ProfilePost;
use XF\Entity\ProfilePostComment;
use XF\Entity\User;
use XF\Entity\Post;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;

class Listener
{
    public static function userPostSave(User $user)
    {
        if (! $user->isChanged('username')) {
            return;
        }

        /** @var \BS\AIBots\Entity\Bot $bot */
        $bot = \XF::em()->findOne('BS\AIBots:Bot', ['user_id' => $user->user_id]);
        if (! $bot) {
            return;
        }

        $bot->fastUpdate('username', $user->username);
    }

    public static function userPostDelete(User $user)
    {
        \XF::repository('BS\AIBots:Bot')
            ->deleteBotsForUser($user->user_id);
    }

    public static function postPostSave(Post $post)
    {
        // Handle only if post is new or is leaving moderation
        $insertingOrLeaveFromModeration = $post->isInsert()
            || $post->isStateChanged('message_state', 'moderated') === 'leave';
        if (! $insertingOrLeaveFromModeration) {
            return;
        }

        if (! $post->Thread->bs_aib_enable_bots) {
            return;
        }

        /** @var \BS\AIBots\Service\Bot\ContextHandleJobRunner $jobRunner */
        $jobRunner = \XF::service('BS\AIBots:Bot\ContextHandleJobRunner');
        $jobRunner->runJob($post, $post->message, 'User', ['User', 'Thread', 'Thread.Forum'], false);
    }

    public static function conversationMessagePostSave(ConversationMessage $message)
    {
        // Handle only if message is new
        if (! $message->isInsert()) {
            return;
        }

        /** @var \BS\AIBots\Service\Bot\ContextHandleJobRunner $jobRunner */
        $jobRunner = \XF::service('BS\AIBots:Bot\ContextHandleJobRunner');
        $jobRunner->runJob($message, $message->message, 'User', ['User', 'Conversation'], false);
    }

    public static function profilePostPostSave(ProfilePost $profilePost)
    {
        // Handle only if post is new
        if (! $profilePost->isInsert()) {
            return;
        }

        /** @var \BS\AIBots\Service\Bot\ContextHandleJobRunner $jobRunner */
        $jobRunner = \XF::service('BS\AIBots:Bot\ContextHandleJobRunner');
        $jobRunner->runJob(
            $profilePost,
            $profilePost->message,
            'User',
            ['User'],
            false
        );
    }

    public static function profilePostCommentPostSave(ProfilePostComment $comment)
    {
        // Handle only if comment is new
        if (! $comment->isInsert()) {
            return;
        }

        /** @var \BS\AIBots\Service\Bot\ContextHandleJobRunner $jobRunner */
        $jobRunner = \XF::service('BS\AIBots:Bot\ContextHandleJobRunner');
        $jobRunner->runJob(
            $comment,
            $comment->message,
            'User',
            ['ProfilePost', 'User'],
            false
        );
    }

    public static function entityStructureThread(Manager $em, Structure $structure)
    {
        $structure->columns['bs_aib_enable_bots'] = ['type' => Entity::BOOL, 'default' => true];
    }
}