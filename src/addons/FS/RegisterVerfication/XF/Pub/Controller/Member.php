<?php

namespace FS\RegisterVerfication\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{

    public function actioncomVerify(ParameterBag $params)
    {

        $user = $this->assertViewableUser($params->user_id);

        $visitor = \xf::visitor();

        if (
            // $visitor->user_id == $user->user_id ||
            $visitor->is_admin ||
            $visitor->is_moderator
        ) {

            $viewParams = ['user' => $user];

            return $this->view('FS\RegisterVerfication', 'comp_verify_detail', $viewParams);
        }

        return $this->noPermission();
    }
}
