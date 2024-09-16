<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Service\Product;

use SV\MultiPrefix\DBTech\eCommerce\Entity\Product;

class Edit extends XFCP_Edit
{
    /**
     * @param int[] $prefixIds
     */
    public function setPrefixIds(array $prefixIds)
    {
        /** @var Product $product */
        $product = $this->product;
        $product->sv_prefix_ids = $prefixIds;
        $prefixId = \count($prefixIds) !== 0 ? \reset($prefixIds) : 0;
		parent::setPrefix($prefixId);
    }
}