<?php

namespace SV\MultiPrefix\XFRM\Entity;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use SV\MultiPrefix\ILinkablePrefix;
use XF\Mvc\Entity\Structure;

/**
 * @property int[] $sv_prefix_ids
 * @property \SV\MultiPrefix\Entity\ResourcePrefixLink PrefixesLink
 */
class ResourceItem extends XFCP_ResourceItem implements ILinkablePrefix
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
        return $category ? \XF::app()->router()->buildLink($linkType . 'resources/categories', $category, ['prefix_id' => $prefixId]) : '';
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->relations['PrefixesLink'] = [
            'entity'        => 'SV\MultiPrefix:ResourcePrefixLink',
            'type'          => self::TO_MANY,
            'conditions'    => 'resource_id',
            'key'           => 'prefix_id',
            'cascadeDelete' => true
        ];

        $structure->behaviors['SV\MultiPrefix:MultiPrefixable'] = [
            'containerIdField' => 'resource_category_id',
            'containerRelation' => 'Category',
            'containerPhrase' => 'resource_category',
            'linkTable' => 'xf_sv_resource_prefix_link',
        ];
        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}
