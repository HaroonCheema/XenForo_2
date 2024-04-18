<?php

namespace FS\InfoText\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class InfoText extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_info_text';
        $structure->shortName = 'FS\InfoText:InfoText';
        $structure->contentType = 'fs_info_text';
        $structure->primaryKey = 'id';

        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'word' => ['type' => self::STR, 'maxLength' => 50, 'required' => true],
            'link' =>  ['type' => self::STR, 'required' => true],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
