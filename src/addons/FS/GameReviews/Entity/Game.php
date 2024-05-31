<?php

namespace FS\GameReviews\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Game extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_game';
        $structure->shortName = 'FS\GameReviews:Game';
        $structure->contentType = 'fs_game';
        $structure->primaryKey = 'game_id';
        $structure->columns = [
            'game_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR, 'maxLength' => 100, 'required' => true],
            'description' =>  ['type' => self::STR, 'required' => true],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
