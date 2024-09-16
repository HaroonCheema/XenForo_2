<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\InlineMod\ProjectItem;

use SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem as MultiPrefixedEntity;
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

        if ($request->filter('apply_prefix', 'bool'))
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
        $view = parent::renderForm($entities, $controller);

        if ($view instanceof View &&
            ($entities = $view->getParam('projects')))
        {
            /** @var AbstractCollection|MultiPrefixedEntity[] $entities */
            if (\is_array($entities))
            {
                $entities = new ArrayCollection($entities);
            }
            $prefixCounts = [];

            if ($entities->count() === 1)
            {
                /** @var MultiPrefixedEntity $first */
                $first = $entities->first();
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

            $view->setParam('selectedPrefix', \array_keys($prefixCounts));
        }

        return $view;
    }
}