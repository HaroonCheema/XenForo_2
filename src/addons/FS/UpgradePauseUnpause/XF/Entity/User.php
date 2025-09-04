<?php

namespace FS\UpgradePauseUnpause\XF\Entity;


class User extends XFCP_User
{
    public function canPauseUnpauseUser(User $user)
    {

        if (!$this->is_moderator && !$this->is_admin) {
            return false;
        }

        $userUpgrade = \XF::finder('XF:UserUpgradeActive')->where('user_id', $user->user_id)->fetchOne();

        $userUpgradePaused = \XF::finder('FS\UpgradePauseUnpause:UpgradePaused')->where('user_id', $user->user_id)->fetchOne();

        if (!$userUpgrade && !$userUpgradePaused) {
            return false;
        }

        return true;
    }

    public function isPaused()
    {
        $userUpgradePaused = \XF::finder('FS\UpgradePauseUnpause:UpgradePaused')->where('user_id', $this->user_id)->fetchOne();

        if ($userUpgradePaused) {
            return true;
        }

        return false;
    }
}
