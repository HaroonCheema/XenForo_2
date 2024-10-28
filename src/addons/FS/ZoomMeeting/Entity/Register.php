<?php

namespace FS\ZoomMeeting\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;

class Register extends Entity {

    public static function getStructure(Structure $structure) {


        $structure->table = 'zoom_meeting_register';
        $structure->shortName = 'FS\ZoomMeeting:Register';
        $structure->primaryKey = 'log_id';
        $structure->contentType = 'zoom_meeting_register';
        $structure->columns = [
            
            'log_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'username' => ['type' => self::STR, 'default' => null],
            'email' => ['type' => self::STR, 'default' => null],
            'participant_uuid' => ['type' => self::STR, 'default' => 0],
            'meeting_id' => ['type' => self::STR, 'default' => null],
            'is_host' => ['type' => self::UINT, 'default' => 0],
            'join_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'left_date' => ['type' => self::UINT, 'default' => 0],
        ];

        $structure->relations = [
            'Meeting' => [
                'entity' => 'FS\ZoomMeeting:Meeting',
                'type' => self::TO_ONE,
                'conditions' => 'meeting_id',
            ]
        ];

        return $structure;
    }
}
