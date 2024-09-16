<?php

namespace SV\MultiPrefix\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int item_id
 * @property int prefix_id
 *
 * RELATIONS
 * @property \DBTech\Shop\Entity\ItemPrefix Prefix
 * @property \DBTech\Shop\Entity\Item Item
 */
class DBTechShopItemPrefixLink extends Entity
{
    public static function getCategoryColumn(): string
    {
        return 'category_id';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_sv_dbtech_shop_item_prefix_link';
        $structure->primaryKey = ['item_id', 'prefix_id'];

        $structure->columns = [
            'item_id' => [
                'type'     => self::UINT,
                'required' => true
            ],
            'prefix_id'   => [
                'type'     => self::UINT,
                'required' => true
            ]
        ];

        $structure->relations = [
            'Prefix'   => [
                'entity'     => 'DBTech\Shop:ItemPrefix',
                'type'       => self::TO_ONE,
                'conditions' => 'prefix_id',
                'primary'    => true
            ],
            'Item' => [
                'entity'     => 'DBTech\Shop:Item',
                'type'       => self::TO_ONE,
                'conditions' => 'item_id',
                'primary'    => true]
        ];

        return $structure;
    }
}