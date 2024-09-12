<?php

namespace FS\LayeredPostersChanges\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Post extends XFCP_Post
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['message'] =  [
            'type' => self::STR,
            'default' => '',
            'api' => true
        ];

        return $structure;
    }
}
