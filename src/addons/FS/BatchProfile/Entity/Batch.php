<?php

namespace FS\BatchProfile\Entity;

use XF\Mvc\Entity\Structure;

class Batch extends XFCP_Batch
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['allow_thread'] =  ['type' => self::BOOL, 'default' => true];
        $structure->columns['allow_profile'] =  ['type' => self::BOOL, 'default' => true];

        return $structure;
    }
}
