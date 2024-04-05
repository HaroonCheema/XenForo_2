<?php

namespace FS\GuestReceiveEmail\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class GuestEmail extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_guest_email_details';
        $structure->shortName = 'FS\GuestReceiveEmail:GuestEmail';
        $structure->contentType = 'fs_guest_email_details';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'guest_id' => ['type' => self::STR, 'maxLength' => 120, 'required' => true],
            'thread_id' => ['type' => self::UINT, 'required' => true],
            'email' => ['type' => self::STR, 'maxLength' => 120, 'required' => true],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
