<?php

namespace SV\MultiPrefix\XFRM\ControllerPlugin;

use XFRM\Finder\ResourceItem;

class Overview extends XFCP_Overview
{
    /**
     * @param ResourceItem $resourceFinder
     *
     * @param array $filters
     */
    public function applyResourceFilters(ResourceItem $resourceFinder, array $filters)
    {
        // this class requires a high execution order to ensure the node list is correctly extracted when other add-ons are around
        $prefixFilter = $filters['prefix_id'] ?? null;
        unset($filters['prefix_id']);

        parent::applyResourceFilters($resourceFinder, $filters);

        if ($prefixFilter !== null)
        {
            /** @var \SV\MultiPrefix\XFRM\Finder\ResourceItem $resourceFinder */
            $resourceFinder->hasPrefixes($prefixFilter);
        }
    }

    /**
     * @return array
     */
    public function getResourceFilterInput()
    {
        $filters = parent::getResourceFilterInput();

        if ($this->request->exists('prefix_id'))
        {
            if ($prefixId = $this->filter('prefix_id', 'uint'))
            {
                $filters['prefix_id'] = [$prefixId];
            }
            else if ($prefixId = $this->filter('prefix_id', 'array-uint'))
            {
                $filters['prefix_id'] = $prefixId;
            }
        }

        return $filters;
    }
}
