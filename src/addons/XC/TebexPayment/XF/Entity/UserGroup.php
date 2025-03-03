<?php

namespace XC\TebexPayment\XF\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;

class UserGroup extends XFCP_UserGroup {

    public static function getStructure(Structure $structure) {

        $structure = parent::getStructure($structure);

        $structure->columns['wallet_address'] = ['type' => self::STR, 'default' => Null];
        $structure->columns['comission'] = ['type' => self::FLOAT, 'default' => 0.00, 'min' => 0.00, 'max' => 99.00];
       

        return $structure;
    }
    
   
}
