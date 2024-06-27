<?php

namespace FS\ThreadDeleteEdit\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['users'] =  ['type' => self::STR, 'default' => ''];

        return $structure;
    }
}
