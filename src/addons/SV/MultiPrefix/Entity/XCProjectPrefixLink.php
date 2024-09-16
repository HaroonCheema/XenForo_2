<?php

namespace SV\MultiPrefix\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int project_id
 * @property int prefix_id
 *
 * RELATIONS
 * @property \XenConcept\ProjectManager\Entity\ProjectPrefix Prefix
 * @property \XenConcept\ProjectManager\Entity\Project Project
 */
class XCProjectPrefixLink extends Entity
{
    public static function getCategoryColumn(): string
    {
        return 'project_category_id';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_sv_xc_project_manager_project_prefix_link';
        $structure->primaryKey = ['project_id', 'prefix_id'];

        $structure->columns = [
            'project_id' => [
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
                'entity'     => 'XenConcept\ProjectManager:ProjectPrefix',
                'type'       => self::TO_ONE,
                'conditions' => 'prefix_id',
                'primary'    => true
            ],
            'Item' => [
                'entity'     => 'XenConcept\ProjectManager:Project',
                'type'       => self::TO_ONE,
                'conditions' => 'project_id',
                'primary'    => true]
        ];

        return $structure;
    }
}