<?php

namespace BS\AIBots\Bot;

use XF\Entity\ConversationMessage;
use XF\Entity\Post;
use XF\Entity\ProfilePost;
use XF\Entity\ProfilePostComment;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;

class ChatGPT extends AbstractBot
{
    use Concerns\ChatGPT\Triggers;
    use Concerns\ChatGPT\Restrictions;
    use Concerns\ChatGPT\ReplyOnPost;
    use Concerns\ChatGPT\ReplyOnConversationMessage;
    use Concerns\ChatGPT\ReplyOnProfilePost;
    use Concerns\ChatGPT\ReplyOnProfilePostComment;
    use Concerns\ChatGPT\Verifiers;
    use Concerns\ChatGPT\SessionActivity;

    protected array $cache = [];

    protected function setup(): void
    {
        $this->setupMessageRepo();
    }

    public function shouldHandle(
        User $author,
        string $message,
        Entity $context,
        bool $isFirstHandle = true
    ): bool {
        if (! $this->app->container('chatGPT')) {
            return false;
        }

        if (! $isFirstHandle) {
            return false;
        }

        if (! $this->shouldHandleContext($context)) {
            return false;
        }

        if (! $this->isUserAllowedToReply($author, $context)) {
            return false;
        }

        $hasTrigger = $this->hasContextTriggers($context)
            || $this->isMatchingRegexes($message, $this->bot->triggers['regexes']);

        $hasLimitations = $this->isRepliesLimited($context, $author)
            || $this->isMatchingRegexes($message, $this->bot->triggers['ignore_regexes']);

        return $hasTrigger && ! $hasLimitations;
    }

    protected function shouldHandleContext(Entity $context): bool
    {
        if ($context instanceof Post) {
            return $this->shouldHandlePost($context);
        }
        if ($context instanceof ConversationMessage) {
            return $this->shouldHandleConversationMessage($context);
        }
        if ($context instanceof ProfilePost) {
            return $this->shouldHandleProfilePost($context);
        }
        if ($context instanceof ProfilePostComment) {
            return $this->shouldHandleProfilePostComment($context);
        }

        return false;
    }

    protected function hasContextTriggers(Entity $context): bool
    {
        if ($context instanceof Post) {
            return $this->hasPostTriggers($context);
        }
        if ($context instanceof ConversationMessage) {
            return $this->hasConversationMessageTriggers($context);
        }
        if ($context instanceof ProfilePost) {
            return $this->hasProfilePostTriggers($context);
        }
        if ($context instanceof ProfilePostComment) {
            return $this->hasProfilePostCommentTriggers($context);
        }

        return false;
    }

    protected function isValidContext(Entity $context): bool
    {
        return $context instanceof Post
            || $context instanceof ConversationMessage
            || $context instanceof ProfilePost
            || $context instanceof ProfilePostComment;
    }

    public function handle(
        User $author,
        string $message,
        Entity $context,
        bool $isFirstHandle = true
    ): ?Entity {
        $newEntity = $this->handleContext(
            $author,
            $message,
            $context,
            $isFirstHandle
        );

        if ($newEntity) {
            $this->updateSessionActivity($context);
        }

        return $newEntity;
    }

    protected function handleContext(
        User $author,
        string $message,
        Entity $context,
        bool $isFirstHandle = true
    ) {
        if ($context instanceof Post) {
            return $this->replyOnPost($context, $author);
        }
        if ($context instanceof ConversationMessage) {
            return $this->replyOnConversationMessage($context, $author);
        }
        if ($context instanceof ProfilePost) {
            return $this->replyOnProfilePost($context, $author);
        }
        if ($context instanceof ProfilePostComment) {
            return $this->replyOnProfilePostComment($context, $author);
        }

        return null;
    }

    public function setupDefaults(): void
    {
        // Merge the default general settings with the existing ones
        $this->bot->general = array_merge([
            'chat_model'                 => 'gpt-3.5-turbo',
            'thread_prompt'              => '',
            'thread_context_limit'       => 10,
            'thread_smart_ignore'        => false,
            'conversation_prompt'        => '',
            'conversation_context_limit' => 10,
            'conversation_smart_ignore'  => false,
            'bot_profile_prompt'         => '',
            'bot_profile_context_limit'  => 10,
            'temperature'                => 1,
        ], $this->bot->general);

        // Merge the default restrictions with the existing ones
        $this->bot->restrictions = array_merge([
            'ignore_regexes' => [],
            'max_replies_per_thread' => 0,
            'max_replies_per_conversation' => 0,
            'spam_check' => false,
        ], $this->bot->restrictions);

        // Merge the default triggers with the existing ones
        $this->bot->triggers = array_merge([
            'active_node_ids' => [],
            'active_for_user_group_ids' => [],
            'posted_in_node_ids' => [],
            'regexes' => [],
            'active_in_context' => ['thread', 'conversation', 'bot_profile'],
            'post' => ['mention', 'quote'],
            'conversation' => ['private_appeal', 'mention', 'quote'],
        ], $this->bot->triggers);
    }

    public function getTabs(): array
    {
        return [
            ['id' => 'tuning',       'title' => (string)\XF::phrase('bs_aib_tuning')],
            ['id' => 'restrictions', 'title' => (string)\XF::phrase('bs_aib_restrictions')],
            ['id' => 'triggers',     'title' => (string)\XF::phrase('bs_aib_triggers')],
        ];
    }

    public function getTabPanesTemplateData(): array
    {
        $template = 'bs_ai_bot.chat_gpt_tab_panes';
        $params = [
            'nodeTree' => $this->getNodeTree(),
            'userGroups' => $this->getUserGroups(),
        ];

        return compact('template', 'params');
    }

    protected function getNodeTree()
    {
        if (! isset($this->cache['nodeTree'])) {
            /** @var \XF\Repository\Node $nodeRepo */
            $nodeRepo = $this->repository('XF:Node');
            $nodeTree = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());

            // only list nodes that are forums or contain forums
            $nodeTree = $nodeTree->filter(null, function ($id, $node, $depth, $children, $tree) {
                return ($children || $node->node_type_id == 'Forum');
            });
            $this->cache['nodeTree'] = $nodeTree;
        }

        return $this->cache['nodeTree'];
    }

    protected function getUserGroups()
    {
        if (! isset($this->cache['userGroups'])) {
            $this->cache['userGroups'] = $this->repository('XF:UserGroup')
                ->getUserGroupTitlePairs();
        }

        return $this->cache['userGroups'];
    }

    /**
     * @return \BS\AIBots\Repository\Bot
     */
    protected function getBotRepo()
    {
        return $this->repository('BS\AIBots:Bot');
    }
}