<?php


namespace NextFlock\JoomlaBridge\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Redirect;
use XF\Mvc\Reply\Reroute;

class Forum extends XFCP_Forum
{
    public function actionIndex(ParameterBag $params)
    {
        $response = parent::actionIndex($params);

        $session = $this->app->session();

//        if($session->keyExists('jlogged_in') && !empty($session->get('jlogged_in')))
//        {
//            $session->remove('jlogged_in');
//            $session->save();
//            header('Location:'." ". $this->options()->nf_jb_baseurl, true, 302);exit;
//        }

        if(!$session->get('jlogin') && \XF::visitor()->user_id > 0 && \XF::visitor()->user_state == 'valid')
        {


            $session->set('jlogin',1);
            $session->save();
//            \XF::session()->set('jlogin',1);

            $jService =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
            $jService->login();
        }

        return $response;
    }
}
