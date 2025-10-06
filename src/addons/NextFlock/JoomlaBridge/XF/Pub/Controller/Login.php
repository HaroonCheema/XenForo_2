<?php


namespace NextFlock\JoomlaBridge\XF\Pub\Controller;


class Login extends XFCP_Login
{
    public function actionLogin()
    {
        $response = parent::actionLogin();
        return $response;
    }
}
