<?php

namespace SV\MultiPrefix\XFRM\Api\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;

/**
 * Extends \XFRM\Api\Controller\ResourceItem
 */
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

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
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
}