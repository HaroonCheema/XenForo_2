<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

use XF\Entity\ConversationMaster;
use XF\Entity\ConversationMessage;
use XF\Entity\Post;
use XF\Entity\ProfilePost;
use XF\Entity\ProfilePostComment;
use XF\Entity\Thread;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Pub\Controller\Thread as ThreadController;
use XF\Pub\Controller\Conversation as ConversationController;
use XF\Pub\Controller\Member as MemberController;

trait SessionActivity
{
    protected function updateSessionActivity(Entity $context): void
    {
        if ($context instanceof Post) {
            $this->updateSessionActivityToViewingThread($context->Thread);
        }
        if ($context instanceof ConversationMessage) {
            $this->updateSessionActivityToViewingConversation($context->Conversation);
        }
        if ($context instanceof ProfilePost) {
            $this->updateSessionActivityToViewingProfile($context->ProfileUser);
        }
        if ($context instanceof ProfilePostComment) {
            $this->updateSessionActivityToViewingProfile($context->ProfilePost->ProfileUser);
        }
    }

    protected function updateSessionActivityToViewingThread(Thread $thread): void
    {
        $this->updateBotSessionActivity(
            ThreadController::class,
            'Index',
            ['thread_id' => $thread->thread_id],
        );
    }

    protected function updateSessionActivityToViewingConversation(
        ConversationMaster $conversation
    ): void {
        $this->updateBotSessionActivity(
            ConversationController::class,
            'View',
            ['conversation_id' => $conversation->conversation_id],
        );
    }

    /**
     * @param  string  $controller
     * @param  string  $action
     * @param  array  $params
     * @return void
     */
    protected function updateBotSessionActivity(
        string $controller,
        string $action,
        array $params = []
    ): void {
        $this->getSessionActivityRepo()->updateSessionActivity(
            $this->bot->user_id,
            '127.0.0.1',
            $controller,
            $action,
            $params,
            'valid',
            ''
        );
    }

    /**
     * @param  \XF\Entity\User  $user
     * @return void
     */
    protected function updateSessionActivityToViewingProfile(User $user): void
    {
        $this->updateBotSessionActivity(
            MemberController::class,
            'View',
            ['user_id' => $user->user_id],
        );
    }

    /**
     * @return \XF\Mvc\Entity\Repository|\XF\Repository\SessionActivity
     */
    protected function getSessionActivityRepo()
    {
        return $this->repository('XF:SessionActivity');
    }
}