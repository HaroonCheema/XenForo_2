<?php

namespace FS\ShowcaseAddonShorUrl\XenAddons\Showcase\Entity;

use XF\Mvc\Entity\Structure;

class Category extends XFCP_Category
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['short_url'] = ['type' => self::STR, 'maxLength' => 255, 'default' => ''];

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
