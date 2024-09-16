<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Entity;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use SV\MultiPrefix\ILinkablePrefix;
use XF\Mvc\Entity\Structure;

/**
 * @property int[] $sv_prefix_ids
 * @property \SV\MultiPrefix\Entity\XCProjectPrefixLink PrefixesLink
 */
class ProjectItem extends XFCP_ProjectItem implements ILinkablePrefix
{
    /**
     * @return array
     */
    public function getSvPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this);
    }

    public function getSvPrefixFilterLink(int $prefixId, string $linkType = ''): string
    {
        $category = $this->Category;
        return $category ? \XF::app()->router()->buildLink($linkType . 'projects/categories', $category, ['prefix_id' => $prefixId]) : '';
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

    public function getSvMinPrefixes()
    {
        return $this->Category->sv_min_task_prefixes;
    }

    public function getSvMaxPrefixes()
    {
        return $this->Category->sv_max_task_prefixes;
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->getters['sv_min_prefixes'] = true;
        $structure->getters['sv_max_prefixes'] = true;

        $structure->relations['PrefixesLink'] = [
            'entity'        => 'SV\MultiPrefix:XCProjectPrefixLink',
            'type'          => self::TO_MANY,
            'conditions'    => 'project_id',
            'key'           => 'prefix_id',
            'cascadeDelete' => true
        ];

        $structure->behaviors['SV\MultiPrefix:MultiPrefixable'] = [
            'containerIdField' => 'project_category_id',
            'containerRelation' => 'Category',
            'containerPhrase' => 'xcpm_project_category',
            'linkTable' => 'xf_sv_xc_project_manager_project_prefix_link',
        ];
        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}
