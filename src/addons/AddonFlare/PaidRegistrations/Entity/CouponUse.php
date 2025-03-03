<?php

namespace AddonFlare\PaidRegistrations\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class CouponUse extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_af_paidregistrations_coupon_use';
        $structure->shortName = 'AddonFlare\PaidRegistrations:CouponUse';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'coupon_id' => ['type' => self::UINT, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'use_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'purchase_request_key' => ['type' => self::STR, 'maxLength' => 32, 'nullable' => true],
        ];

        $structure->getters = [

        ];

        $structure->relations = [

        ];

        return $structure;
    }
}