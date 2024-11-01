<?php

namespace FS\XFMG\Entity;

use XF\Mvc\Entity\Structure;

class Album extends XFCP_Album
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['media_id'] =  ['type' => self::UINT, 'default' => '0'];

        $structure->relations += [
            'MediaItem' => [
                'entity' => 'XFMG:MediaItem',
                'type' => self::TO_ONE,
                'conditions' => 'media_id',
                'primary' => true
            ],
        ];


        return $structure;
    }
}
