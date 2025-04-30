<?php

namespace Ialert\PayrexxGateway\Listener;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;

class UserUpgradeListener
{

    public static function userUpgradeStructure(Manager $em, Structure &$structure) {
        $structure->columns['is_review_balance'] = ['type' => Entity::BOOL, 'default' => false];
    }

}