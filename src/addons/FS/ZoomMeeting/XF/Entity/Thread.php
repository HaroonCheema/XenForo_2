<?php

namespace FS\ZoomMeeting\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread {

    public static function getStructure(Structure $structure) {
        $structure = parent::getStructure($structure);

        $structure->columns['meeting_id'] = ['type' => self::INT, 'default' => 0];

        $structure->relations['Meeting'] = [
            'entity' => 'FS\ZoomMeeting:Meeting',
            'type' => self::TO_ONE,
            'conditions' => 'meeting_id',
            'primary' => true,
            'api' => true
        ];
        return $structure;
    }
}
