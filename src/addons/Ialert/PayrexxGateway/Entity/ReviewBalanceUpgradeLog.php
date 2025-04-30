<?php


namespace Ialert\PayrexxGateway\Entity;


use XF\Mvc\Entity\Structure;

class ReviewBalanceUpgradeLog extends \XF\Mvc\Entity\Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'amp_reviews_balance_upgrade_log';
        $structure->shortName = 'Ialert\PayrexxGateway:ReviewBalanceUpgradeLog';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'date' => ['type' => self::STR, 'default' => ''],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'gain' => ['type' => self::INT],
        ];

        $structure->getters = [];

        return $structure;
    }

}