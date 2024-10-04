<?php

namespace FH\RazorpayIntegration\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class PaidRegistrations extends Entity
{
    public static function getStructure(Structure $structure)
    {
        //        fh_razorpay_paid_registrations
        $structure->table = 'fh_razorpay_paid_registrations';
        $structure->shortName = 'FH\RazorpayIntegration:PaidRegistrations';
        $structure->primaryKey = 'paid_registrations_id';
        $structure->columns = [
            'paid_registrations_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'user_upgrade_id' => ['type' => self::UINT, 'default' => 0],
            'razorpay_order_id' => ['type' => self::STR, 'default' => ''],
            'razorpay_payment_id' => ['type' => self::STR, 'default' => ''],
            'razorpay_signature' => ['type' => self::STR, 'default' => ''],
            'date' => ['type' => self::UINT, 'default' => \XF::$time],
            'user_upgrade_record_id' => ['type' => self::UINT, 'default' => 0]
        ];

        $structure->getters = [];
        $structure->relations = [];

        return $structure;
    }
}
