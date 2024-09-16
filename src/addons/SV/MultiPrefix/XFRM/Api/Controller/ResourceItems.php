<?php

namespace SV\MultiPrefix\XFRM\Api\Controller;

/**
 * Extends \XFRM\Api\Controller\ResourceItems
 */
class ResourceItems extends XFCP_ResourceItems
{
    /**
     * @param \SV\MultiPrefix\XFRM\Entity\Category $category
     * @return \SV\MultiPrefix\XFRM\Service\ResourceItem\Create|\XFRM\Service\ResourceItem\Create
     */
    protected function setupResourceCreate(\XFRM\Entity\Category $category)
    {
        /** @var \SV\MultiPrefix\XFRM\Service\ResourceItem\Create $creator */
        $creator = parent::setupResourceCreate($category);
        $resource = $creator->getResource();
        $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || !$category->isPrefixUsable($prefixId))
                {
                    unset($prefixIds[$key]);
                }
            }

            $creator->setPrefixIds($prefixIds);
        }

        return $creator;
    }
}