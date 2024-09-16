<?php

namespace SV\MultiPrefix\DBTech\eCommerce\ControllerPlugin;

use DBTech\eCommerce\Finder\Product;

class Overview extends XFCP_Overview
{
    /**
     * @param Product $productFinder
     *
     * @param array $filters
     */
    public function applyProductFilters(Product $productFinder, array $filters)
    {
        // this class requires a high execution order to ensure the node list is correctly extracted when other add-ons are around
        $prefixFilter = $filters['prefix_id'] ?? null;
        unset($filters['prefix_id']);

        parent::applyProductFilters($productFinder, $filters);

        if ($prefixFilter !== null)
        {
            /** @var \SV\MultiPrefix\DBTech\eCommerce\Finder\Product $productFinder */
            $productFinder->hasPrefixes($prefixFilter);
        }
    }

    /**
     * @return array
     */
    public function getProductFilterInput(): array
    {
        $filters = parent::getProductFilterInput();

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
