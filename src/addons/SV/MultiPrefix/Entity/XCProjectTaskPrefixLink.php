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
 * @property \XenConcept\ProjectManager\Entity\ProjectTaskPrefix TaskPrefix
 * @property \XenConcept\ProjectManager\Entity\ProjectTask Task
 */
class XCProjectTaskPrefixLink extends Entity
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
        $structure->table = 'xf_sv_xc_project_manager_project_task_prefix_link';
        $structure->primaryKey = ['project_task_id', 'prefix_id'];

        $structure->columns = [
            'project_task_id' => [
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
                'entity'     => 'XenConcept\ProjectManager:ProjectTaskPrefix',
                'type'       => self::TO_ONE,
                'conditions' => 'prefix_id',
                'primary'    => true
            ],
            'Item' => [
                'entity'     => 'XenConcept\ProjectManager:ProjectTask',
                'type'       => self::TO_ONE,
                'conditions' => 'project_task_id',
                'primary'    => true]
        ];

        return $structure;
    }
}