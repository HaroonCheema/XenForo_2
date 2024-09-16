<?php

namespace SV\MultiPrefix\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int resource_id
 * @property int prefix_id
 *
 * RELATIONS
 * @property \XFRM\Entity\ResourcePrefix Prefix
 * @property \XFRM\Entity\ResourceItem Resource
 */
class ResourcePrefixLink extends Entity
{
    public static function getCategoryColumn(): string
    {
        return 'resource_category_id';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_sv_resource_prefix_link';
        $structure->primaryKey = ['resource_id', 'prefix_id'];

        $structure->columns = [
            'resource_id' => [
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
                'entity'     => 'XFRM:ResourcePrefix',
                'type'       => self::TO_ONE,
                'conditions' => 'prefix_id',
                'primary'    => true
            ],
            'Resource' => [
                'entity'     => 'XFRM:Resource',
                'type'       => self::TO_ONE,
                'conditions' => 'resource_id',
                'primary'    => true]
        ];

        return $structure;
    }
}