<?php

namespace XenGenTr\XGTCoreLibrary\Listener;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;

class Listener
{
    public static function nodeEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
        $structure->columns['xgt_style_fa_ikon'] = ['type' => Entity::STR, 'default' => NULL, 'nullable' => true];
    }
}