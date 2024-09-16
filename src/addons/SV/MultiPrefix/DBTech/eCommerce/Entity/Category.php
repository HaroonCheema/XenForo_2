<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Entity;

use XF\Mvc\Entity\Structure;

/**
 * @property int sv_min_prefixes
 * @property int sv_max_prefixes
 * @property int require_prefix
 */
class Category extends XFCP_Category
{
    protected function _preSave()
    {
        parent::_preSave();

        if ($this->sv_min_prefixes !== 0 && $this->sv_max_prefixes !== 0)
        {
            if ($this->sv_max_prefixes < $this->sv_min_prefixes)
            {
                $this->sv_min_prefixes = 0;
            }
        }

        if ($this->sv_min_prefixes !== 0)
        {
            $this->require_prefix = true;
        }
        else
        {
            $this->require_prefix = false;
        }
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
    public function isPrefixValid($prefix): bool
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

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure): Structure
    {
        $structure = parent::getStructure($structure);

        $structure->columns['sv_min_prefixes'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['sv_max_prefixes'] = ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}