<?php

namespace FS\CreateZoomMeeting\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['meetingId'] = ['type' => self::INT, 'default' => 0];

        $structure->relations['zoomMeeting'] = [
            'entity' => 'FS\CreateZoomMeeting:Meeting',
            'type' => self::TO_ONE,
            'conditions' => 'meetingId',
            'primary' => true,
            'api' => true
        ];
        return $structure;
    }
}
