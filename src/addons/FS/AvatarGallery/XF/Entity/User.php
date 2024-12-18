<?php

namespace FS\AvatarGallery\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['random_avatar_limit'] = ['type' => self::INT, 'default' => 0];

        return $structure;
    }

    public function canUploadAvatar()
    {
        $canUploadAvatar = parent::canUploadAvatar();
        if ($canUploadAvatar) {
            return $canUploadAvatar;
        }

        return ($this->user_id && !$this->hasPermission('general', 'fs_cannot_use_avatar_glry'));
    }

    public function canUseRandomAvatar()
    {
        $isEnabled = \xf::options()->fs_use_random;
        $randomLimit = intval(\xf::options()->fs_random_limit);

        if ($isEnabled && ($this->random_avatar_limit < $randomLimit)) {
            return true;
        }

        return false;
    }
}
