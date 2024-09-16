<?php

namespace SV\MultiPrefix\XF\InlineMod\Thread;

use SV\MultiPrefix\XF\Entity\Thread as MultiPrefixedEntity;
use XF\Http\Request;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Reply\View;

class Move extends XFCP_Move
{
    /**
     * @param AbstractCollection $entities
     * @param Request $request
     *
     * @return array
     */
    public function getFormOptions(AbstractCollection $entities, Request $request)
    {
        $options = parent::getFormOptions($entities, $request);

        if ($options['apply_thread_prefix'])
        {
            $options ['prefix_id'] = $request->filter('prefix_id', 'array-uint');
        }

        return $options;
    }

    /**
     * @param AbstractCollection $entities
     * @param \XF\Mvc\Controller $controller
     *
     * @return null|View
     */
    public function renderForm(AbstractCollection $entities, \XF\Mvc\Controller $controller)
    {
        $response = parent::renderForm($entities, $controller);

        if ($response instanceof View &&
            ($entities = $response->getParam('threads')))
        {
            /** @var AbstractCollection|MultiPrefixedEntity[] $entities */
            if (\is_array($entities))
            {
                $entities = new ArrayCollection($entities);
            }
            /** @var MultiPrefixedEntity $first */
            $first = $entities->first();
            $prefixCounts = [];

            if ($entities->count() === 1)
            {
                foreach($first->sv_prefix_ids as $prefixId)
                {
                    if (!isset($prefixCounts[$prefixId]))
                    {
                        $prefixCounts[$prefixId] = 1;
                    }
                    else
                    {
                        $prefixCounts[$prefixId]++;
                    }
                }
                unset($prefixCounts[0]);
            }

            $formOptions = $this->getFormOptions($entities, $controller->request());
            $targetNodeId = $formOptions['target_node_id'] ?: $first->node_id;

            if ($targetNodeId)
            {
                /** @var \SV\MultiPrefix\XF\Entity\Forum $forum */
                if ($forum = $this->app()->em()->find('XF:Forum', $targetNodeId))
                {
                    $response->setParam('allowedMaxPrefixes', $forum->sv_max_prefixes);
                }
            }

            $response->setParam('selectedPrefix',\array_keys($prefixCounts));
        }

        return $response;
    }
}