<?php

namespace FS\BanUserChanges\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionBanLift(ParameterBag $params)
    {

        if ($this->isPost()) {
            $user = $this->assertViewableUser($params->user_id, [], true);

            $bannedUsersService = \xf::app()->service('FS\BanUserChanges:BannedUsers');

            $bannedUsersService->banLiftDeletePosts($user);

            return parent::actionBanLift($params);
        } else {
            return parent::actionBanLift($params);
        }
    }

    public function actionBanSave(ParameterBag $params)
    {
        $parent = parent::actionBanSave($params);

        $bannedUsersService = \xf::app()->service('FS\BanUserChanges:BannedUsers');
        $bannedUsersService->BannedUserSave($params->user_id, $this);

        return $parent;
    }
}
