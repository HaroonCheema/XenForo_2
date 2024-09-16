<?php

namespace SV\MultiPrefix\XF\Api\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;

/**
 * Extends \XF\Api\Controller\Thread
 */
class Thread extends XFCP_Thread
{
    /**
     * @param \SV\MultiPrefix\XF\Entity\Thread|\XF\Entity\Thread $thread
     * @return \SV\MultiPrefix\XF\Service\Thread\Editor|\XF\Service\Thread\Editor
     */
    protected function setupThreadEdit(\XF\Entity\Thread $thread)
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($thread), true);
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\XF\Service\Thread\Editor $editor */
        $editor = parent::setupThreadEdit($thread);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$thread->Forum->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }
}