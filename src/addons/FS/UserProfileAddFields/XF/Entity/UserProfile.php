<?php

namespace FS\UserProfileAddFields\XF\Entity;

use XF\Mvc\Entity\Structure;

class UserProfile extends XFCP_UserProfile
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['sotd'] =  ['type' => self::STR, 'default' => ''];
        $structure->columns['sotd_img'] =  ['type' => self::STR, 'default' => ''];
        $structure->columns['sotd_link'] =  ['type' => self::STR, 'default' => ''];
        $structure->columns['sotd_date'] =  ['type' => self::UINT, 'default' => \XF::$time];
        $structure->columns['sotd_hide'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['sotd_streak'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['review_count'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['wardrobe_icon'] =  ['type' => self::STR, 'default' => ''];
        $structure->columns['wardrobe_hide'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }
}
