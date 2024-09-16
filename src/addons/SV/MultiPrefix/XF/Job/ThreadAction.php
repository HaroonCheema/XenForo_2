<?php

namespace SV\MultiPrefix\XF\Job;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Entity\Thread;

class ThreadAction extends XFCP_ThreadAction
{
    protected function applyInternalThreadChange(Thread $thread)
    {
        parent::applyInternalThreadChange($thread);

        if ($thread->discussion_type == 'redirect')
        {
            return;
        }

        if ($prefixIds = $this->getThreadPrefixAction('prefix_ids'))
        {
            $this->applyMultiPrefixChange($thread, $prefixIds);
        }
        else
        {
            /** @var \SV\MultiPrefix\XF\Entity\Thread $thread */
            if ($prefixIds = $this->getThreadPrefixAction('add_prefixes'))
            {
                $newPrefixIds = \array_unique(\array_merge($thread->sv_prefix_ids, $prefixIds));
                $this->applyMultiPrefixChange($thread, $newPrefixIds);
            }

            if ($prefixIds = $this->getThreadPrefixAction('remove_prefixes'))
            {
                $newPrefixIds = \array_diff($thread->sv_prefix_ids, $prefixIds);
                $this->applyMultiPrefixChange($thread, $newPrefixIds);
            }
        }
    }

    protected function applyMultiPrefixChange(Thread $thread, array $prefixIds)
    {
        /** @var \SV\MultiPrefix\XF\Entity\Thread $thread */
        MultiPrefixable::sortPrefixes($prefixIds, 'thread');
        $thread->sv_prefix_ids = $prefixIds;
    }

    protected function getThreadPrefixAction(string $action): array
    {
        $prefixIds = $this->data['actions'][$action] ?? [];
        if (!\is_array($prefixIds))
        {
            $prefixIds = [$prefixIds];
        }

        return \array_map('\intval', $prefixIds);
    }

    protected function getActionValue($action)
    {
        if ($action === 'prefix_id')
        {
            return null;
        }

        return parent::getActionValue($action);
    }
}