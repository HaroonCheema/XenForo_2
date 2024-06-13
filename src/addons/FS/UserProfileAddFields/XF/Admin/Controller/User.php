<?php

namespace FS\UserProfileAddFields\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class User extends XFCP_User
{

    public function actionSotd(ParameterBag $params)
    {
        // $visitor = \XF::visitor();
        $user = $this->assertUserExists($params->user_id);

        if (!$user['user_id']) {
            return $this->noPermission();
        }

        $viewParams = [
            'user' => $user
        ];

        return $this->view('FS\UserProfileAddFields', 'fs_UserProfileAddFields_sotd', $viewParams);
    }
}
