<?php

namespace AddonFlare\PaidRegistrations\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class PurchaseRequest extends XFCP_PurchaseRequest
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['af_pr_guest_pending'] = [
            'type' => self::BOOL,
            'default' => null,
            'nullable' => true
        ];

        return $structure;
    }
}