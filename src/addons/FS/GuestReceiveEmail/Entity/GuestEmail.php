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
        $structure->primaryKey = 'thread_id';
        $structure->columns = [
            'thread_id' => ['type' => self::UINT, 'required' => true],
            'email' => ['type' => self::STR, 'maxLength' => 120],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
