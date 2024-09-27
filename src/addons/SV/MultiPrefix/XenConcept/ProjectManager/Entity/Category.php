<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Entity;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * @property int sv_min_project_prefixes
 * @property int sv_max_project_prefixes
 * @property int sv_min_task_prefixes
 * @property int sv_max_task_prefixes
 * @property int require_project_prefix
 * @property int require_task_prefix
 * @property int[] sv_thread_prefix_ids
 * :
 */
class Category extends XFCP_Category
{
    /**
     * @return int[]
     */
    protected function getSvThreadPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this, 'sv_thread_prefix_ids_', true, 'thread');
    }

    protected function _preSave()
    {
        if ($this->isChanged('sv_thread_prefix_ids') || $this->isInsert())
        {
            if ($this->sv_thread_prefix_ids)
            {
                $arr = $this->sv_thread_prefix_ids;
                $this->thread_prefix_id = \reset($arr);
            }
            else
            {
                $this->thread_prefix_id = 0;
            }
        }

        if ($this->sv_min_project_prefixes !== 0 && $this->sv_max_project_prefixes !== 0)
        {
            if ($this->sv_max_project_prefixes < $this->sv_min_project_prefixes)
            {
                $this->sv_min_project_prefixes = 0;
            }
        }

        if ($this->sv_min_project_prefixes !== 0)
        {
            $this->require_project_prefix = true;
        }
        else
        {
            $this->require_project_prefix = false;
        }

        if ($this->sv_min_task_prefixes !== 0 && $this->sv_max_task_prefixes !== 0)
        {
            if ($this->sv_max_task_prefixes < $this->sv_min_task_prefixes)
            {
                $this->sv_min_task_prefixes = 0;
            }
        }

        if ($this->sv_min_task_prefixes !== 0)
        {
            $this->require_task_prefix = true;
        }
        else
        {
            $this->require_task_prefix = false;
        }

        parent::_preSave();
    }

    /**
     * @param array $forcePrefixes
     * @return array
     */
    public function getMultipleUsablePrefixes(array $forcePrefixes = [])
    {
        $prefixes = $this->prefixes;

        $prefixes = $prefixes->filter(function ($prefix) use ($forcePrefixes)
        {
            if ($forcePrefixes && \in_array($prefix->prefix_id, $forcePrefixes))
            {
                return true;
            }

            return $this->isPrefixUsable($prefix);
        });

        return $prefixes->groupBy('prefix_group_id');
    }

    /**
     * @param int|array|Category $prefix
     *
     * @return bool
     */
    public function isPrefixValid($prefix)
    {
        if (\is_array($prefix))
        {
            foreach ($prefix as $_prefix)
            {
                if (!parent::isPrefixValid($_prefix))
                {
                    return false;
                }
            }
            return true;
        }

        return parent::isPrefixValid($prefix);
    }

    public function getSvMinPrefixes()
    {
        return $this->sv_min_project_prefixes;
    }

    public function getSvMaxPrefixes()
    {
        return $this->sv_max_project_prefixes;
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['sv_min_project_prefixes'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['sv_max_project_prefixes'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['sv_min_task_prefixes'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['sv_max_task_prefixes'] = ['type' => self::UINT, 'default' => 0];

        $structure->getters['sv_min_prefixes'] = true;
        $structure->getters['sv_max_prefixes'] = true;

        $structure->columns['sv_thread_prefix_ids'] = [
            'type'     => Entity::LIST_COMMA,
            'default'  => [],
            'nullable' => true,
            'list' => ['type' => 'posint', 'unique' => true], // note; do not use sorting!
        ];
        $structure->getters['sv_thread_prefix_ids'] = true;

        return $structure;
    }
}