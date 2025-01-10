<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

use BS\AIBots\Job\ContextHandle;
use XF\Entity\ConversationMessage;
use XF\Entity\Post;
use XF\Entity\ProfilePost;
use XF\Entity\ProfilePostComment;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;

trait Restrictions
{
    protected function isRepliesLimited(Entity $context, User $author): bool
    {
        if ($context instanceof Post) {
            return $this->isRepliesLimitedForPost($context, $author);
        }
        if ($context instanceof ConversationMessage) {
            return $this->isRepliesLimitedForConversationMessage($context, $author);
        }
        if ($context instanceof ProfilePost) {
            return $this->isRepliesLimitedForProfilePost($context, $author);
        }
        if ($context instanceof ProfilePostComment) {
            return $this->isRepliesLimitedForProfilePostComment($context, $author);
        }

        return false;
    }

    protected function isRepliesLimitedForPost(Post $post, User $author)
    {
        $restrictions = $this->bot->restrictions;
        $permissionNames = $this->buildPermissionNames();

        if (! $author->hasNodePermission($post->Thread->node_id, $permissionNames['use'])) {
            return true;
        }

        if ($restrictions['max_replies_per_thread']) {
            /** @var \XF\Finder\Post $postFinder */
            $postFinder = \XF::finder('XF:Post')
                ->inThread($post->Thread, ['visibility' => 'visible'])
                ->where('user_id', $this->bot->user_id);
            $postsCount = $postFinder->total();
            if ($postsCount >= $restrictions['max_replies_per_thread']) {
                return true;
            }
        }

        $maxRepliesPerThread = $author->hasNodePermission(
            $post->Thread->node_id,
            $permissionNames['maxRepliesPerThread']
        );
        $maxRepliesPerDay = $author->hasNodePermission(
            $post->Thread->node_id,
            $permissionNames['maxRepsPerDayThread']
        );

        $repliesFinder = $this->findBotReplies();

        if ($maxRepliesPerThread > 0) {
            $repliesCount = $repliesFinder->toUser($author)->forEntity($post->Thread)->total();
            if ($repliesCount >= $maxRepliesPerThread) {
                return true;
            }
        }

        if ($maxRepliesPerDay > 0) {
            $repliesCount = $repliesFinder->toUser($author)
                ->forThisDay()
                ->forContentType('thread')
                ->total();
            if ($repliesCount >= $maxRepliesPerDay) {
                return true;
            }
        }

        return false;
    }

    protected function isRepliesLimitedForConversationMessage(
        ConversationMessage $message,
        User $author
    ): bool {
        $conversation = $message->Conversation;
        $restrictions = $this->bot->restrictions;
        $permissionNames = $this->buildPermissionNames();

        if (! $author->hasPermission('conversation', $permissionNames['use'])) {
            return true;
        }

        $repliesFinder = $this->findBotReplies();

        if ($restrictions['max_replies_per_conversation']) {
            $conversationRepliesCount = $repliesFinder->forEntity($conversation)->total();
            if ($conversationRepliesCount >= $restrictions['max_replies_per_conversation']) {
                return true;
            }
        }

        $maxRepliesPerConversation = $author->hasPermission(
            'conversation',
            $permissionNames['maxRepliesPerConv']
        );
        $maxRepliesPerDay = $author->hasPermission(
            'conversation',
            $permissionNames['maxRepsPerDayConv']
        );

        if ($maxRepliesPerConversation > 0) {
            $repliesCount = $repliesFinder->toUser($author)->forEntity($conversation)->total();
            if ($repliesCount >= $maxRepliesPerConversation) {
                return true;
            }
        }

        if ($maxRepliesPerDay > 0) {
            $repliesCount = $repliesFinder->toUser($author)
                ->forThisDay()
                ->forContentType('conversation')
                ->total();
            if ($repliesCount >= $maxRepliesPerDay) {
                return true;
            }
        }

        return false;
    }

    protected function isUserAllowedToReply(User $user, Entity $context)
    {
        if ($user->user_id === $this->bot->user_id) {
            return false;
        }

        if (in_array($user->user_id, ContextHandle::$activeBotUserIds, true)) {
            return false;
        }

        $restrictions = $this->bot->restrictions;
        if (empty($restrictions['active_for_user_group_ids'])) {
            return true;
        }
        if ((int)$restrictions['active_for_user_group_ids'][0] === -1) {
            return true;
        }

        return $user->isMemberOf($restrictions['active_for_user_group_ids']);
    }

    protected function isRepliesLimitedForProfilePost(ProfilePost $profilePost, User $author)
    {
        $permissions = $this->buildPermissionNames();

        if (! $author->hasPermission('bsAib', $permissions['useInBotProfile'])) {
            return true;
        }

        $maxRepliesPerDay = $author->hasPermission(
            'bsAib',
            $permissions['maxRepsBotPrfPerDay']
        );

        $repliesFinder = $this->findBotReplies();

        if ($maxRepliesPerDay > 0) {
            $repliesCount = $repliesFinder->toUser($author)
                ->forThisDay()
                ->forContentType('user_profile', $profilePost->profile_user_id)
                ->total();
            if ($repliesCount >= $maxRepliesPerDay) {
                return true;
            }
        }

        return false;
    }

    protected function isRepliesLimitedForProfilePostComment(
        ProfilePostComment $comment,
        User $author
    ): bool {
        return $this->isRepliesLimitedForProfilePost($comment->ProfilePost, $author);
    }

    /**
     * @return \BS\AIBots\Finder\ReplyLog
     */
    protected function findBotReplies()
    {
        return \XF::finder('BS\AIBots:ReplyLog')
            ->byBot($this->bot);
    }

    protected function buildPermissionNames()
    {
        $permissions = [
            'use',
            'useInBotProfile',
            'maxRepliesPerThread',
            'maxRepsPerDayThread',
            'maxRepliesPerConv',
            'maxRepsPerDayConv',
            'maxRepsBotPrfPerDay'
        ];
        return array_combine($permissions, array_map(function ($name) {
            return $this->getPermissionWithPrefix($name);
        }, $permissions));
    }

    protected function getPermissionWithPrefix(string $name): string
    {
        return 'aibGpt' . ucfirst($name);
    }
}