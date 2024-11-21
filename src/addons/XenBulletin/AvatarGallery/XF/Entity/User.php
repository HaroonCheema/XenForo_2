<?php

namespace XenBulletin\AvatarGallery\XF\Entity;

class User extends XFCP_User
{
    public function canUploadAvatar()
    {
        return true;
        $canUploadAvatar = parent::canUploadAvatar();
        if ($canUploadAvatar) {
            return $canUploadAvatar;
        }

        return ($this->user_id && !$this->hasPermission('general', 'xb_cannot_use_avatar_glry'));
    }
}
