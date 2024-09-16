<?php

namespace SV\MultiPrefix\XF\Api\Controller;

use SV\MultiPrefix\XF\Service\Thread\Creator;

/**
 * Extends \XF\Api\Controller\Threads
 */
class Threads extends XFCP_Threads
{
    /**
     * @param \SV\MultiPrefix\XF\Entity\Forum|\XF\Entity\Forum  $forum
     *
     * @return Creator|\XF\Service\Thread\Creator
     */
    protected function setupThreadCreate(\XF\Entity\Forum $forum)
    {
        /** @var Creator $creator */
        $creator = parent::setupThreadCreate($forum);
        $thread = $creator->getThread();
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || !$forum->isPrefixUsable($prefixId))
                {
                    unset($prefixIds[$key]);
                }
            }

            $creator->setPrefixIds($prefixIds);
        }

        return $creator;
    }
}