<?php

namespace FS\RegisterVerfication\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{

    public static function getStructure(Structure $structure)
    {

        $structure = parent::getStructure($structure);

        $structure->columns['comp_verify_key'] = ['type' => self::INT, 'default' => 0];

        $structure->columns['comp_verify_val'] = ['type' => self::STR, 'default' => null];

        $structure->columns['fs_regis_referral'] = ['type' => self::STR, 'maxLength' => 500, 'default' => ''];

        return $structure;
    }

    public function getVerificationImgUrl($canonical = true)
    {
        $userId = $this->user_id;
        $path = sprintf('RegisterVerfication/' . '/%d/%d.jpg', floor($userId / 1000), $userId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }

    public function getVerificationImgPath()
    {
        $userId = $this->user_id;

        return sprintf('data://RegisterVerfication/' . '/%d/%d.jpg', floor($userId / 1000), $userId);
    }

    public function isImage()
    {
        $fs = $this->app()->fs();

        $ImgPath = $this->getVerificationImgPath();

        if ($fs->has($ImgPath)) {
            return true;
        }

        return false;
    }
}
