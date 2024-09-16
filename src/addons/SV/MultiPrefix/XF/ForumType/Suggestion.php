<?php

namespace SV\MultiPrefix\XF\ForumType;

use SV\MultiPrefix\XF\Finder\Thread as ExtendedThreadFinder;
use XF\Entity\Forum;

/**
 * Extends \XF\ForumType\Suggestion
 */
class Suggestion extends XFCP_Suggestion
{
    public function applyForumFilters(Forum $forum, \XF\Finder\Thread $threadFinder, array $filters): \XF\Finder\Thread
    {
        $suggestionState = $filters['suggestion_state'] ?? '';
        $filters['suggestion_state'] = '';

        /** @var ExtendedThreadFinder $threadFinder */
        $threadFinder = parent::applyForumFilters($forum, $threadFinder, $filters);

        if ($suggestionState !== '')
        {
            $typeConfig = $forum->type_config;

            if ($suggestionState === 'implemented')
            {
                $threadFinder->hasPrefixes(\array_values($typeConfig['implemented_prefix_ids']), false);
            }
            else if ($suggestionState === 'closed')
            {
                $threadFinder->hasPrefixes(\array_values($typeConfig['closed_prefix_ids']), false);
            }
            else if ($suggestionState === 'open')
            {
                $specialPrefixIds = $typeConfig['implemented_prefix_ids'] + $typeConfig['closed_prefix_ids'];
                $threadFinder->notHasPrefixes(\array_values($specialPrefixIds), false);
            }
        }

        return $threadFinder;
    }
}