<?php


namespace NextFlock\JoomlaBridge\XF\Pub\Controller;


class Logout extends XFCP_Logout
{
    public function actionIndex()
    {
        $response = parent::actionIndex();
        $session = $this->app->session();
        $session->remove('jlogin');
        $session->remove('jlogged_in');
        $session->save();
        $jService =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
        $jService->logout();
        return $response;
    }
}
