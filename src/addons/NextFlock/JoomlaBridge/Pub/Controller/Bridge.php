<?php

namespace NextFlock\JoomlaBridge\Pub\Controller;

use XF\Pub\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Bridge extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $input = $this->filter([
            'username' => 'str',
            'token' => 'str',
        ]);

        if($input['token'] == \XF::options()->nf_jb_token)
        {
            $comingHost = parse_url($_SERVER['HTTP_REFERER'])['host'];
            $baseUrl = \XF::options()->nf_jb_baseurl;
            if($comingHost == parse_url($baseUrl)['host'])
            {
                $username = $input['username'];
                $session = $this->app->session();
                $user = $this->em()->findOne('XF:User', ['username' => $username]);
                if($user)
                {
                    $loginPlugin = $this->plugin('XF:Login');
                    $loginPlugin->completeLogin($user,0);
                    $session->set('jlogged_in',1);
                    $session->save();
                    $redirect = $this->getDynamicRedirectIfNot($this->buildLink('login'));
                    return $this->redirect($redirect, '');
                }
            }
        }

        header('Location:'." ". $this->options()->nf_jb_baseurl, true, 302);exit;

    }

    public function actionLogout(ParameterBag $params)
    {
        $input = $this->filter([
//            'username' => 'str',
            'token' => 'str',
        ]);

        if($input['token'] == \XF::options()->nf_jb_token && isset($_SERVER['HTTP_REFERER']))
        {
            $comingHost = parse_url($_SERVER['HTTP_REFERER'])['host'];
            $baseUrl = \XF::options()->nf_jb_baseurl;
            if($comingHost == parse_url($baseUrl)['host'])
            {
                /** @var \XF\ControllerPlugin\Login $loginPlugin */
                $loginPlugin = $this->plugin('XF:Login');
                $loginPlugin->logoutVisitor();
                $session = $this->app->session();
                $session->remove('jlogin');
                $session->remove('jlogged_in');
                $session->save();

            }
        }
        header('Location:'." ". $this->options()->nf_jb_baseurl, true, 302);exit;
    }
}
