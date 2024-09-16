<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Entity;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use SV\MultiPrefix\ILinkablePrefix;
use XF\Mvc\Entity\Structure;

/**
 * @property int[] $sv_prefix_ids
 * @property \SV\MultiPrefix\Entity\DBTecheCommerceProductPrefixLink PrefixesLink
 */
class Product extends XFCP_Product implements ILinkablePrefix
{
    /**
     * @return array
     */
    public function getSvPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this, 'sv_prefix_ids_', false, 'dbtechEcommerceProduct');
    }

    public function getSvPrefixFilterLink(int $prefixId, string $linkType = ''): string
    {
        $category = $this->Category;
        return $category ? \XF::app()->router()->buildLink($linkType . 'dbtech-ecommerce/categories', $category, ['prefix_id' => $prefixId]) : '';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure): Structure
    {
        $structure = parent::getStructure($structure);

        $structure->relations['PrefixesLink'] = [
            'entity'        => 'SV\MultiPrefix:DBTecheCommerceProductPrefixLink',
            'type'          => self::TO_MANY,
            'conditions'    => 'product_id',
            'key'           => 'prefix_id',
            'cascadeDelete' => true
        ];

        $structure->behaviors['SV\MultiPrefix:MultiPrefixable'] = [
            'containerIdField' => 'product_category_id',
            'containerRelation' => 'Category',
            'containerPhrase' => 'category',
			'linkTable' => 'xf_sv_dbtech_ecommerce_product_prefix_link',
			'prefixContentType' => 'dbtechEcommerceProduct',
        ];
        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}
