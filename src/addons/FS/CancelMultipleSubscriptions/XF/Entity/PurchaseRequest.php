<?php

namespace FS\CancelMultipleSubscriptions\XF\Entity;

use XF\Mvc\Entity\Structure;

class PurchaseRequest extends XFCP_PurchaseRequest
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['is_canceled'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}
