<?php

namespace FS\EmbedZoomMeeting\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;

class Register extends Entity
{

    public static function getStructure(Structure $structure)
    {

        $structure->table = 'fs_zoom_meeting_register';
        $structure->shortName = 'FS\EmbedZoomMeeting:Register';
        $structure->primaryKey = 'log_id';
        $structure->contentType = 'fs_zoom_meeting_register';
        $structure->columns = [

            'log_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'username' => ['type' => self::STR, 'default' => null],
            'email' => ['type' => self::STR, 'default' => null],
            'user_id' => ['type' => self::UINT, 'default' => 0],
            'participant_uuid' => ['type' => self::STR, 'default' => 0],
            'meeting_id' => ['type' => self::STR, 'default' => null],
            'is_host' => ['type' => self::UINT, 'default' => 0],
            'join_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'status' => ['type' => self::UINT, 'default' => 1],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true,
                'api' => true
            ],
            'Registers' => [
                'entity' => 'FS\EmbedZoomMeeting:Register',
                'type' => self::TO_MANY,
                'conditions' => 'meeting_id',
            ],
        ];


        return $structure;
    }
}
