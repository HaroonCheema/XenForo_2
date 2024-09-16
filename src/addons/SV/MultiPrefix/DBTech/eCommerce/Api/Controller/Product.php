<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Api\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;

/**
 * Extends \DBTech\eCommerce\Api\Controller\Product
 */
class Product extends XFCP_Product
{
    protected function setupProductEdit(\DBTech\eCommerce\Entity\Product $product): \DBTech\eCommerce\Service\Product\Edit
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($product), true);
        $product->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $product->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\DBTech\eCommerce\Service\Product\Edit $editor */
        $editor = parent::setupProductEdit($product);

        $prefixIds = $this->filter('sv_prefix_ids', '?array-uint') ?? $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$product->Category->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }
}