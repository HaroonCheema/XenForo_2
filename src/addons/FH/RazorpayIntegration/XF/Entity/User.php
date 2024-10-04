<?php

namespace FH\RazorpayIntegration\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['razorpay_payment_id'] = ['type' => self::STR, 'default' => ''];

        return $structure;
    }
}
