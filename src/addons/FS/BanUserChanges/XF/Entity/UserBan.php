<?php

namespace FS\BanUserChanges\XF\Entity;

use XF\Mvc\Entity\Structure;

class UserBan extends XFCP_UserBan
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['thread_id'] =  ['type' => self::UINT, 'default' => 0];

        $structure->relations += [
            'Thread' => [
                'entity' => 'XF:Thread',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary' => true
            ],
        ];

        return $structure;
    }
}
