<?php

namespace FS\ThreadScoringSystem\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['threads_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['reply_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['worlds_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['reactions_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['solutions_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['total_score'] =  ['type' => self::FLOAT, 'default' => 0];

        return $structure;
    }

}
