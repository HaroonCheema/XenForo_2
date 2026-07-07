<?php

namespace xenMade\LAU\XF\Repository;


class SessionActivity extends XFCP_SessionActivity
{
    public function updateSessionActivity($userId, $ip, $controller, $action, array $params, $viewState, $robotKey)
    {
        $session = \XF::app()->session();

        if(!$session->exists())
        {
            parent::updateSessionActivity($userId, $ip, $controller, $action, $params, $viewState, $robotKey);
        }

        if(
            $session->offsetExists('lau_id') &&
            $session->offsetExists('lau_stealth')
        )
        {
            if(\XF::options()->lau_Stealth)
            {
                return;
            }
        }

        parent::updateSessionActivity($userId, $ip, $controller, $action, $params, $viewState, $robotKey);
    }
}