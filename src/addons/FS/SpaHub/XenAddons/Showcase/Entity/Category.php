<?php

namespace FS\SpaHub\XenAddons\Showcase\Entity;

use XF\Entity\AbstractCategoryTree;
use XF\Mvc\Entity\Structure;

class Category extends XFCP_Category
{
    public static function getStructure(\XF\Mvc\Entity\Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['short_url'] = ['type' => self::STR, 'default' => ''];

        $structure->relations += [
            'ParentCategory' => [
                'entity' => 'XenAddons\Showcase:Category',
                'type' => self::TO_ONE,
                'conditions' => [
                    ['category_id', '=', '$parent_category_id'],
                ]
            ]
        ];

        return $structure;
    }
    protected function _preSave()
    {
        $parent = parent::_preSave();

        $request = \XF::app()->request();

        $this->short_url = $request->filter('short_url', 'str');

        return $parent;
    }
}
