<?php

namespace FS\BanUserChanges\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;


class Banning extends XFCP_Banning
{
    public function actionUsersSave(ParameterBag $params)
    {
        $parent = parent::actionUsersSave($params);

        $userId = 0;

        if ($params['user_id']) {
            $userId = $params['user_id'];
        } else {
            $input = $this->filter([
                'username' => 'str',
            ]);

            $user = $this->finder('XF:User')->where('username', $input['username'])->fetchOne();
            if ($user) {
                $userId = $user['user_id'];
            }
        }

        $bannedUsersService = \xf::app()->service('FS\BanUserChanges:BannedUsers');
        $bannedUsersService->BannedUserSave($userId, $this);


        return $parent;
    }

    public function actionUsersLift(ParameterBag $params)
    {
        if ($this->isPost()) {
            $userBan = $this->assertUserBanExists($params->user_id);

            $bannedUsersService = \xf::app()->service('FS\BanUserChanges:BannedUsers');

            $bannedUsersService->banLiftDeletePosts($userBan->User);

            return parent::actionUsersLift($params);
        } else {
            return parent::actionUsersLift($params);
        }
    }
}
