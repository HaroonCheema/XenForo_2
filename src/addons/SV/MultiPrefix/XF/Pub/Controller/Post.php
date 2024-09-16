<?php

namespace SV\MultiPrefix\XF\Pub\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Post extends XFCP_Post
{
    /**
     * @param \SV\MultiPrefix\XF\Entity\Thread|\XF\Entity\Thread $thread
     * @param array $threadChanges Returns a list of whether certain important thread fields are changed
     *
     * @return \SV\MultiPrefix\XF\Service\Thread\Editor
     */
    protected function setupFirstPostThreadEdit(\XF\Entity\Thread $thread, &$threadChanges)
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($thread), true);
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $thread->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);
        /** @var \SV\MultiPrefix\XF\Service\Thread\Editor $creator */
        $creator = parent::setupFirstPostThreadEdit($thread, $threadChanges);

        $prefixIds = $this->filter('prefix_id', '?array-uint');

        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$thread->Forum->isPrefixUsable($prefixId)))
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
     *
     * @return \XF\Mvc\Reply\Redirect|View
     */
    public function actionEdit(ParameterBag $params)
    {
        $response = parent::actionEdit($params);

        if ($response instanceof View)
        {
            /** @var \XF\Entity\Post $post */
            $post = $response->getParam('post');
            /** @var \SV\MultiPrefix\XF\Entity\Thread $thread */
            $thread = $response->getParam('thread');
            if ($thread && $post && $post->isFirstPost())
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
}