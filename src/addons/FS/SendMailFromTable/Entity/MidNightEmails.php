<?php

namespace FS\SendMailFromTable\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MidNightEmails extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_mid_night_emails';
        $structure->shortName = 'FS\SendMailFromTable:MidNightEmails';
        $structure->contentType = 'fs_mid_night_emails';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],

            'email' => ['type' => self::STR, 'maxLength' => 120],
            'date' => ['type' => self::UINT, 'default' => \XF::$time],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
