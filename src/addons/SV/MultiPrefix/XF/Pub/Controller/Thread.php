<?php

namespace SV\MultiPrefix\XF\Pub\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

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

        $prefixIds = $this->filter('prefix_id', '?array-uint');
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

    /**
     * @param \XF\Entity\Thread $thread
     * @param \XF\Entity\Forum $forum
     * @return \SV\MultiPrefix\XF\Service\Thread\Mover|\XF\Service\Thread\Mover
     */
    protected function setupThreadMove(\XF\Entity\Thread $thread, \XF\Entity\Forum $forum)
    {
        if (empty(\XF::options()->svStripPrefixOnContainerChange))
        {
            $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
            $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);
        }

        /** @var \SV\MultiPrefix\XF\Service\Thread\Mover $mover */
        $mover = parent::setupThreadMove($thread, $forum);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            $mover->setPrefixIds($prefixIds);
        }

        return $mover;
    }

    /**
     * @param ParameterBag $params
     *
     * @return \XF\Mvc\Reply\Redirect|View
     */
    public function actionEdit(ParameterBag $params)
    {
        $response = parent::actionEdit($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\XF\Entity\Thread $thread */
            $thread = $response->getParam('thread');
            if ($thread)
            {
                /** @var \SV\MultiPrefix\XF\Entity\Forum $forum */
                $forum = $response->getParam('forum') ?: $thread->Forum;
                if ($forum)
                {
                    $prefixes = $thread->sv_prefix_ids;
                    $prefixes = $forum->getMultipleUsablePrefixes($prefixes);
                    $response->setParam('prefixes', $prefixes);
                }
            }
        }

        return $response;
    }

    /**
     * @param ParameterBag $params
     *
     * @return \XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|View
     */
    public function actionMove(ParameterBag $params)
    {
        $response = parent::actionMove($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\XF\Entity\Thread $thread */
            $thread = $response->getParam('thread');

            /** @var \SV\MultiPrefix\XF\Entity\Forum $forum */
            $forum = $response->getParam('forum');
            if ($thread && !$forum)
            {
                $forum = $thread->Forum;
            }

            if ($thread && $forum)
            {
                $prefixes = $thread->sv_prefix_ids;
                $prefixes = $forum->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
            }
        }

        return $response;
    }
}