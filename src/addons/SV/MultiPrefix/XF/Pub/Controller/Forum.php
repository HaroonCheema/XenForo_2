<?php

namespace SV\MultiPrefix\XF\Pub\Controller;

use SV\MultiPrefix\Listener;
use SV\MultiPrefix\XF\Service\Thread\Creator;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Forum extends XFCP_Forum
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
        Listener::$draftEntity = $thread = $creator->getThread();
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
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

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Message
     */
    public function actionDraft(ParameterBag $params)
    {
        try
        {
            return parent::actionDraft($params);
        }
        finally
        {
            Listener::$draftEntity = null;
        }
    }

    /**
     * @param \XF\Entity\Forum  $forum
     * @param \XF\Finder\Thread $threadFinder
     * @param array             $filters
     */
    protected function applyForumFilters(\XF\Entity\Forum $forum, \XF\Finder\Thread $threadFinder, array $filters)
    {
        // this class requires a high execution order to ensure the node list is correctly extracted when other add-ons are around
        $prefixFilter = $filters['prefix_id'] ?? null;
        unset($filters['prefix_id']);

        parent::applyForumFilters($forum, $threadFinder, $filters);

        if ($prefixFilter !== null)
        {
            /** @var \SV\MultiPrefix\XF\Finder\Thread $threadFinder */
            $threadFinder->hasPrefixes($prefixFilter);
        }
    }

    /**
     * @param \SV\MultiPrefix\XF\Entity\Forum|\XF\Entity\Forum  $forum
     * @return array
     */
    protected function getForumFilterInput(\XF\Entity\Forum $forum)
    {
        $filters = parent::getForumFilterInput($forum);

        if ($this->request->exists('prefix_id'))
        {
            if ($prefixId = $this->filter('prefix_id', 'uint'))
            {
                $filters['prefix_id'] = [$prefixId];
            }
            else
            {
                $filters['prefix_id'] = $this->filter('prefix_id', 'array-uint');
            }
        }

        return $filters;
    }
}