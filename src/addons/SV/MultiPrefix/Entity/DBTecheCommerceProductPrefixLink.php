<?php

namespace SV\MultiPrefix\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int product_id
 * @property int prefix_id
 *
 * RELATIONS
 * @property \DBTech\eCommerce\Entity\ProductPrefix Prefix
 * @property \DBTech\eCommerce\Entity\Product Product
 */
class DBTecheCommerceProductPrefixLink extends Entity
{
    public static function getCategoryColumn(): string
    {
        return 'product_category_id';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_sv_dbtech_ecommerce_product_prefix_link';
        $structure->primaryKey = ['product_id', 'prefix_id'];

        $structure->columns = [
            'product_id' => [
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
                'entity'     => 'DBTech\eCommerce:ProductPrefix',
                'type'       => self::TO_ONE,
                'conditions' => 'prefix_id',
                'primary'    => true
            ],
            'Product' => [
                'entity'     => 'DBTech\eCommerce:Product',
                'type'       => self::TO_ONE,
                'conditions' => 'product_id',
                'primary'    => true]
        ];

        return $structure;
    }
}