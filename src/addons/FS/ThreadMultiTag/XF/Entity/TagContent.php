<?php

namespace FS\ThreadMultiTag\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class TagContent extends XFCP_TagContent
{

    public static function getStructure(Structure $structure)
    {

        $structure = parent::getStructure($structure);

        $structure->columns['multi_order'] = ['type' => self::INT, 'default' => 0];

        return $structure;
    }
}
