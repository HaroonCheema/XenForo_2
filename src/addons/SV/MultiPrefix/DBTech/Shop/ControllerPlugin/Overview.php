<?php

namespace SV\MultiPrefix\DBTech\Shop\ControllerPlugin;

use DBTech\Shop\Finder\Item;

class Overview extends XFCP_Overview
{
    /**
     * @param Item $itemFinder
     *
     * @param array $filters
     */
    public function applyItemFilters(Item $itemFinder, array $filters)
    {
        // this class requires a high execution order to ensure the node list is correctly extracted when other add-ons are around
        $prefixFilter = $filters['prefix_id'] ?? null;
        unset($filters['prefix_id']);

        parent::applyItemFilters($itemFinder, $filters);

        if ($prefixFilter !== null)
        {
            /** @var \SV\MultiPrefix\DBTech\Shop\Finder\Item $itemFinder */
            $itemFinder->hasPrefixes($prefixFilter);
        }
    }

    /**
     * @return array
     */
    public function getItemFilterInput(): array
    {
        $filters = parent::getItemFilterInput();

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
