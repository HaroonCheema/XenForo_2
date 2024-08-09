<?php

namespace FS\CustomForumWidget\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['click_count'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}
