<?php

namespace SV\MultiPrefix\XFRM\InlineMod\ResourceItem;

use SV\MultiPrefix\XFRM\Entity\ResourceItem as MultiPrefixedEntity;
use XF\Http\Request;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Reply\View;

class ApplyPrefix extends XFCP_ApplyPrefix
{
    /**
     * @param AbstractCollection $entities
     * @param Request $request
     *
     * @return array
     */
    public function getFormOptions(AbstractCollection $entities, Request $request)
    {
        return [
            'prefix_id' => $request->filter('prefix_id', 'array-uint')
        ];
    }

    /**
     * @param AbstractCollection $entities
     * @param array $options
     * @param null $error
     *
     * @return bool
     */
    public function canApply(AbstractCollection $entities, array $options = [], &$error = null)
    {
        $return = parent::canApply($entities, $options, $error);

        if ($return)
        {
            if (isset($options['prefix_id']) && !empty($options['prefix_id']))
            {
                $svPrefixIds = $options['prefix_id'];
                $entitiesFailedMinRequirement = 0;
                $entitiesFailedMaxRequirement = 0;

                /** @var MultiPrefixedEntity $entity */
                foreach ($entities AS $entity)
                {
                    /** @var \SV\MultiPrefix\XFRM\Entity\Category $category */
                    $category = $entity->Category;

                    if ($category->sv_min_prefixes)
                    {
                        if (\count($svPrefixIds) < $category->sv_min_prefixes)
                        {
                            $entitiesFailedMinRequirement++;
                        }
                    }

                    if ($category->sv_max_prefixes)
                    {
                        if (\count($svPrefixIds) > $category->sv_max_prefixes)
                        {
                            $entitiesFailedMaxRequirement++;
                        }
                    }
                }

                if ($entitiesFailedMinRequirement === 0 && $entitiesFailedMaxRequirement !== 0)
                {
                    $error = \XF::phrase('sv_multiprefix_maximum_prefixes_requirement_for_one_more_resources_has_been_exceeded');
                }
                else if ($entitiesFailedMinRequirement !== 0 && $entitiesFailedMaxRequirement === 0)
                {
                    $error = \XF::phrase('sv_multiprefix_minimum_prefixes_requirement_for_one_more_resources_has_not_been_met');
                }
                else if ($entitiesFailedMinRequirement !== 0 && $entitiesFailedMaxRequirement !== 0)
                {
                    $error = \XF::phrase('sv_multiprefix_minimum_or_maximum_prefixes_requirement_for_one_more_resources_has_not_been_met_excee');
                }

                if (!empty($error))
                {
                    $return = false;
                }
            }
        }

        return $return;
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
            ($entities = $view->getParam('resources')))
        {
            /** @var MultiPrefixedEntity[] $entities */
            $prefixCounts = [];
            foreach ($entities AS $entity)
            {
                foreach($entity->sv_prefix_ids as $prefixId)
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
            }
            unset($prefixCounts[0]);

            $view->setParam('selectedPrefix', \array_keys($prefixCounts));
        }

        return $view;
    }
}