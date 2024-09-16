<?php

namespace SV\MultiPrefix\XF\ThreadType;

use SV\MultiPrefix\XF\Entity\Thread as ExtendedThreadEntity;
use XF\Entity\Thread;
use XF\Http\Request;

/**
 * Extends \XF\ThreadType\Suggestion
 */
class Suggestion extends XFCP_Suggestion
{
    public function adjustThreadViewParams(Thread $thread, array $viewParams, Request $request): array
    {
        $viewParams = parent::adjustThreadViewParams($thread, $viewParams, $request);

        /** @var ExtendedThreadEntity $thread */
        $prefixIds = $thread->sv_prefix_ids ?? [];
        if (\count($prefixIds) !== 0)
        {
            $forum = $this->getForumIfSuggestionType($thread);
            if ($forum)
            {
                $forumTypeConfig = $forum->type_config;
                $viewParams['suggestionInfo']['implemented'] = ($viewParams['suggestionInfo']['implemented'] ?? false) ||
                                                               \count(\array_intersect($prefixIds, $forumTypeConfig['implemented_prefix_ids'])) !== 0;
                $viewParams['suggestionInfo']['closed'] = ($viewParams['suggestionInfo']['closed'] ?? false) ||
                                                          \count(\array_intersect($prefixIds, $forumTypeConfig['closed_prefix_ids'])) !== 0;
            }
        }

        return $viewParams;
    }

    public function canVoteOnThread(Thread $thread, &$error = null): bool
    {
        $canVote = parent::canVoteOnThread($thread, $error);
        if (!$canVote)
        {
            return false;
        }

        /** @var ExtendedThreadEntity $thread */
        $prefixIds = $thread->sv_prefix_ids ?? [];
        if (\count($prefixIds) !== 0)
        {
            $forum = $this->getForumIfSuggestionType($thread);
            if ($forum)
            {
                $forumTypeConfig = $forum->type_config;
                if (\count(\array_intersect($prefixIds, $forumTypeConfig['implemented_prefix_ids'])) !== 0 ||
                    \count(\array_intersect($prefixIds, $forumTypeConfig['closed_prefix_ids'])) !== 0)
                {
                    // can't vote on implemented or closed suggestions
                    return false;
                }
            }
        }

        return true;
    }
}