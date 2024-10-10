<?php

namespace FS\LatestThread\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['tile_layout'] =  [
            'type' => self::STR,
            'default' => 'grid',
            'allowedValues' => ['grid', 'girdLg', 'list']
        ];

        $structure->columns['new_tab'] =  [
            'type' => self::STR,
            'default' => 'yes',
            'allowedValues' => ['yes', 'no']
        ];

        $structure->columns['filter_sidebar'] =  [
            'type' => self::STR,
            'default' => 'normal',
            'allowedValues' => ['normal', 'sticky']
        ];

        $structure->columns['version_style'] =  [
            'type' => self::STR,
            'default' => 'small',
            'allowedValues' => ['small', 'large']
        ];

        return $structure;
    }
}
