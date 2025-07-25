<?php

namespace FS\SendMailFromTable\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class EmailTemplates extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_email_templates';
        $structure->shortName = 'FS\SendMailFromTable:EmailTemplates';
        $structure->contentType = 'fs_email_templates';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],

            'title' => ['type' => self::STR, 'maxLength' => 100, 'required' => 'please_enter_valid_title'],
            'email_body' => ['type' => self::STR, 'required' => 'please_enter_valid_body']
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
