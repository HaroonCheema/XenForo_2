<?php

namespace BS\AIBots\Bot;

use XF\Entity\ConversationMessage;
use XF\Entity\Post;
use XF\Entity\ProfilePost;
use XF\Entity\ProfilePostComment;
use XF\Entity\User;

class GPTDallE extends ChatGPT
{
    public function replyOnPost(Post $post, User $author)
    {
        /** @var \BS\AIBots\Service\GPTDallE\PostReplier $replier */
        $replier = $this->service('BS\AIBots:GPTDallE\PostReplier', $post);
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

    public function replyOnConversationMessage(ConversationMessage $message, User $author)
    {
        /** @var \BS\AIBots\Service\GPTDallE\ConversationMessageReplier $replier */
        $replier = $this->service('BS\AIBots:GPTDallE\ConversationMessageReplier', $message);
        $newMessage = $replier->reply($this->bot);
        if ($newMessage) {
            // Log thread reply to limit number of replies per thread
            $this->getBotRepo()->logReply(
                $author->user_id,
                'conversation',
                $message->conversation_id,
                $this->bot->bot_id
            );
        }
        return $newMessage;
    }

    public function replyOnProfilePost(ProfilePost $profilePost, User $author)
    {
        /** @var \BS\AIBots\Service\GPTDallE\ProfilePostReplier $replier */
        $replier = $this->service('BS\AIBots:GPTDallE\ProfilePostReplier', $profilePost);
        $comment = $replier->reply($this->bot);
        if ($comment) {
            // Log thread reply to limit number of replies per thread
            $this->getBotRepo()->logReply(
                $author->user_id,
                'user_profile',
                $profilePost->profile_user_id,
                $this->bot->bot_id
            );
        }
        return $comment;
    }

    public function replyOnProfilePostComment(ProfilePostComment $comment, User $author)
    {
        /** @var \BS\AIBots\Service\GPTDallE\ProfilePostCommentReplier $replier */
        $replier = $this->service('BS\AIBots:GPTDallE\ProfilePostCommentReplier', $comment);
        $newComment = $replier->reply($this->bot);
        if ($newComment) {
            // Log thread reply to limit number of replies per thread
            $this->getBotRepo()->logReply(
                $author->user_id,
                'user_profile',
                $comment->ProfilePost->profile_user_id,
                $this->bot->bot_id
            );
        }
        return $newComment;
    }

    public function setupDefaults(): void
    {
        parent::setupDefaults();

        // Reset the general settings
        $this->bot->general = array_merge([
            'chat_model' => 'gpt-3.5-turbo',
        ], $this->bot->general);

        // Merge the default restrictions with the existing ones
        $this->bot->restrictions = array_merge([
            'max_images_per_message' => 4,
            'max_image_size' => 1024
        ], $this->bot->restrictions);
    }

    public function verifyGeneral(array &$general): void
    {
        $general = [
            'chat_model' => $general['chat_model'] ?? 'gpt-3.5-turbo',
        ];

        if (! $this->isValidChatModel($general['chat_model'])) {
            $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_invalid_chat_model'));
        }
    }

    public function verifyRestrictions(array &$restrictions): void
    {
        parent::verifyRestrictions($restrictions);
        $restrictions['max_images_per_message'] = (int)($restrictions['max_images_per_message'] ?? 4);
        $restrictions['max_image_size'] = (int)($restrictions['max_image_size'] ?? 512);
    }

    public function getTabs(): array
    {
        return [
            [
                'id' => 'tuning',
                'title' => (string)\XF::phrase('bs_aib_tuning')
            ],
            [
                'id' => 'image_restrictions',
                'title' => (string)\XF::phrase('bs_aib_image_restrictions')
            ],
            [
                'id' => 'restrictions',
                'title' => (string)\XF::phrase('bs_aib_restrictions')
            ],
            [
                'id' => 'triggers',
                'title' => (string)\XF::phrase('bs_aib_triggers')
            ],
        ];
    }

    public function getTabPanesTemplateData(): array
    {
        $template = 'bs_ai_bot.chat_gpt_dalle_tab_panes';
        $params = [
            'nodeTree' => $this->getNodeTree(),
            'userGroups' => $this->getUserGroups(),
        ];

        return compact('template', 'params');
    }

    protected function getPermissionWithPrefix(string $name): string
    {
        return 'aibGdE' . ucfirst($name);
    }
}