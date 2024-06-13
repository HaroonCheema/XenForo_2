<?php

namespace FS\UserProfileAddFields\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{

    public function actionSotd(ParameterBag $params)
    {
        // $visitor = \XF::visitor();
        $user = $this->assertViewableUser($params->user_id);

        if (!$user['user_id']) {
            return $this->noPermission();
        }

        $viewParams = [
            'user' => $user
        ];

        return $this->view('FS\UserProfileAddFields', 'fs_UserProfileAddFields_sotd', $viewParams);
    }
}
