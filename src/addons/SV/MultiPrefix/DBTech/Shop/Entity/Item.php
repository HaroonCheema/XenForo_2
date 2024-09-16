<?php

namespace SV\MultiPrefix\DBTech\Shop\Entity;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use SV\MultiPrefix\ILinkablePrefix;
use XF\Mvc\Entity\Structure;

/**
 * @property int[] $sv_prefix_ids
 * @property \SV\MultiPrefix\Entity\DBTechShopItemPrefixLink PrefixesLink
 */
class Item extends XFCP_Item implements ILinkablePrefix
{
    /**
     * @return array
     */
    public function getSvPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this, 'sv_prefix_ids_', false, 'dbtechShopItem');
    }

    public function getSvPrefixFilterLink(int $prefixId, string $linkType = ''): string
    {
        $category = $this->Category;
        return $category ? \XF::app()->router()->buildLink($linkType . 'dbtech-shop/categories', $category, ['prefix_id' => $prefixId]) : '';
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
            'entity'        => 'SV\MultiPrefix:DBTechShopItemPrefixLink',
            'type'          => self::TO_MANY,
            'conditions'    => 'item_id',
            'key'           => 'prefix_id',
            'cascadeDelete' => true
        ];

        $structure->behaviors['SV\MultiPrefix:MultiPrefixable'] = [
            'containerIdField' => 'category_id',
            'containerRelation' => 'Category',
            'containerPhrase' => 'category',
			'linkTable' => 'xf_sv_dbtech_shop_item_prefix_link',
			'prefixContentType' => 'dbtechShopItem',
        ];
        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}
