<?php

namespace FS\CancelMultipleSubscriptions\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class SubscriptionUserGroups extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_cancel_subscription_user_groups';
        $structure->shortName = 'FS\CancelMultipleSubscriptions:SubscriptionUserGroups';
        $structure->contentType = 'fs_cancel_subscription_user_groups';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'user_group_id' => ['type' => self::UINT, 'required' => true],
            'end_at' => ['type' => self::UINT, 'default' => \XF::$time],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
            ],
            'UserGroup' => [
                'entity' => 'XF:UserGroup',
                'type' => self::TO_ONE,
                'conditions' => 'user_group_id',
            ],
        ];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
