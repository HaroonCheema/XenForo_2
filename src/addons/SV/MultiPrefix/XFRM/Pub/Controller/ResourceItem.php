<?php

namespace SV\MultiPrefix\XFRM\Pub\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class ResourceItem extends XFCP_ResourceItem
{
    /**
     * @param \XFRM\Entity\ResourceItem|\SV\MultiPrefix\XFRM\Entity\ResourceItem $resource
     * @return \SV\MultiPrefix\XFRM\Service\ResourceItem\Edit|\XFRM\Service\ResourceItem\Edit
     */
    protected function setupResourceEdit(\XFRM\Entity\ResourceItem $resource)
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($resource), true);
        $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\XFRM\Service\ResourceItem\Edit $editor */
        $editor = parent::setupResourceEdit($resource);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$resource->Category->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }

    /**
     * @param \XFRM\Entity\ResourceItem|\SV\MultiPrefix\XFRM\Entity\ResourceItem $resource
     * @param \XFRM\Entity\Category|\SV\MultiPrefix\XFRM\Entity\Category         $category
     * @return \SV\MultiPrefix\XFRM\Service\ResourceItem\Move|\XFRM\Service\ResourceItem\Move
     */
    protected function setupResourceMove(\XFRM\Entity\ResourceItem $resource, \XFRM\Entity\Category $category)
    {
        if (empty(\XF::options()->svStripPrefixOnContainerChange))
        {
            $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
            $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);
        }

        /** @var \SV\MultiPrefix\XFRM\Service\ResourceItem\Move $mover */
        $mover = parent::setupResourceMove($resource, $category);

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
            /** @var \SV\MultiPrefix\XFRM\Entity\ResourceItem $resource */
            $resource = $response->getParam('resource');

            /** @var \SV\MultiPrefix\XFRM\Entity\Category $category */
            $category = $response->getParam('category');
            if ($resource && !$category)
            {
                $category = $resource->Category;
            }

            if ($resource && $category)
            {
                $prefixes = $resource->sv_prefix_ids;
                $prefixes = $category->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
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
            /** @var \SV\MultiPrefix\XFRM\Entity\ResourceItem $resource */
            $resource = $response->getParam('resource');

            /** @var \SV\MultiPrefix\XFRM\Entity\Category $category */
            $category = $response->getParam('category');
            if ($resource && !$category)
            {
                $category = $resource->Category;
            }

            if ($resource && $category)
            {
                $prefixes = $resource->sv_prefix_ids;
                $prefixes = $category->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
            }
        }

        return $response;
    }
}