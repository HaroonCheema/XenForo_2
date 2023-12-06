<?php

namespace nick97\WatchList\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['watch_list'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}
