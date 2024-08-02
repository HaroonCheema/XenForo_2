<?php

namespace FS\ExcludeReactionScore\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Forum extends XFCP_Forum
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['count_reactions'] =  ['type' => self::BOOL, 'default' => true];

        return $structure;
    }
}
