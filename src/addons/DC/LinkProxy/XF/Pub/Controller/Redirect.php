<?php

namespace DC\LinkProxy\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;

class Redirect extends \XF\Pub\Controller\AbstractController
{
    public function actionIndex()
    {
        $visitor = \XF::visitor();

        if (!$visitor->hasPermission('bypassPasswordGroup', 'bypassPassword')) {

            $to = isset($_GET['to']) ? $_GET['to'] : '';

            $viewParams = [
                'to' => $to,
            ];

            return $this->view('DC\LinkProxy:Redirect\Index', 'DC_LinkProxy_password', $viewParams);
        }

        $encodedUrl = isset($_GET['to']) ? $_GET['to'] : '';

        if (!$encodedUrl) return $this->error(\XF::phrase('DC_LinkProxy_url_not_valid'));
        $visitor = \XF::visitor();
        $urlDecoded = base64_decode($encodedUrl);
        
        if (filter_var($urlDecoded, FILTER_VALIDATE_URL) === FALSE) {
            return $this->error(\XF::phrase('DC_LinkProxy_url_not_valid'));
        }

        $order = $this->app()->options()->fs_link_group_apply_settings ? 'DESC' : 'ASC';
        if ($visitor->user_id) {
            if (count($visitor->secondary_group_ids)) {
                $ids_array =   $visitor->secondary_group_ids;
                array_push($ids_array, $visitor->user_group_id);
                $group_id = $ids_array;
            } else {
                $group_id[] = $visitor->user_group_id;
            }

            $finder = $this->finder('XF:UserGroup')->where('user_group_id', $group_id);
            $top_priority_group = $finder->order('display_style_priority', $order)->fetchOne();
            $user_link_setting = $this->finder('DC\LinkProxy:LinkProxyList')->where('user_group_id',  $top_priority_group->user_group_id)->fetchOne();
        } else {

            $groupIds = $this->finder('DC\LinkProxy:LinkProxyList')->pluckFrom('user_group_id')->fetch()->toArray();

            if (in_array($visitor->user_group_id, $groupIds)) {

                $finder = $this->finder('XF:UserGroup')->where('user_group_id', $visitor->user_group_id);
                $top_priority_group = $finder->order('display_style_priority', $order)->fetchOne();
                $user_link_setting = $this->finder('DC\LinkProxy:LinkProxyList')->where('user_group_id',  $top_priority_group->user_group_id)->fetchOne();
            } else {

                $user_link_setting = NULL;
            }
        }

        $redirect_time = $user_link_setting ? $user_link_setting->redirect_time : $this->app()->options()->DC_LinkProxy_AutoRedirection__time;
        $html = $user_link_setting ? $user_link_setting->link_redirect_html : '';

        $viewParams = [
            'url' => $urlDecoded,
            'redirect_time' => $redirect_time,
            'html' => $html,

        ];
        return $this->view('DC\LinkProxy:Redirecting', 'DC_LinkProxy_Redirecting', $viewParams);
    }

    public function actionMatchPassword()
    {
        $input = $this->filter([
            'password' => 'str',
        ]);

        if ($input['password'] == '') {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        $encodedUrl = isset($_GET['to']) ? $_GET['to'] : '';

        $password = $input['password'];

        $getPassword = \XF::finder('DC\LinkProxy:TFAuth')->where('auth_password', $password)->where('expired_at', '>', time())->fetchOne();

        if (!isset($getPassword->id)) {
            throw $this->exception($this->notFound(\XF::phrase('dc_link_proxy_password_not_matching')));
        }

        if ($password != $getPassword->auth_password) {
            throw $this->exception($this->notFound(\XF::phrase('dc_link_proxy_password_not_matching')));
        }

        if (!$encodedUrl) return $this->error(\XF::phrase('DC_LinkProxy_url_not_valid'));
        $visitor = \XF::visitor();
        $urlDecoded = base64_decode($encodedUrl);

        if (filter_var($urlDecoded, FILTER_VALIDATE_URL) === FALSE) {
            return $this->error(\XF::phrase('DC_LinkProxy_url_not_valid'));
        }

        $order = $this->app()->options()->fs_link_group_apply_settings ? 'DESC' : 'ASC';
        if ($visitor->user_id) {
            if (count($visitor->secondary_group_ids)) {
                $ids_array =   $visitor->secondary_group_ids;
                array_push($ids_array, $visitor->user_group_id);
                $group_id = $ids_array;
            } else {
                $group_id[] = $visitor->user_group_id;
            }

            $finder = $this->finder('XF:UserGroup')->where('user_group_id', $group_id);
            $top_priority_group = $finder->order('display_style_priority', $order)->fetchOne();
            $user_link_setting = $this->finder('DC\LinkProxy:LinkProxyList')->where('user_group_id',  $top_priority_group->user_group_id)->fetchOne();
        } else {

            $groupIds = $this->finder('DC\LinkProxy:LinkProxyList')->pluckFrom('user_group_id')->fetch()->toArray();

            if (in_array($visitor->user_group_id, $groupIds)) {

                $finder = $this->finder('XF:UserGroup')->where('user_group_id', $visitor->user_group_id);
                $top_priority_group = $finder->order('display_style_priority', $order)->fetchOne();
                $user_link_setting = $this->finder('DC\LinkProxy:LinkProxyList')->where('user_group_id',  $top_priority_group->user_group_id)->fetchOne();
            } else {

                $user_link_setting = NULL;
            }
        }

        $redirect_time = $user_link_setting ? $user_link_setting->redirect_time : $this->app()->options()->DC_LinkProxy_AutoRedirection__time;
        $html = $user_link_setting ? $user_link_setting->link_redirect_html : '';

        $viewParams = [
            'url' => $urlDecoded,
            'redirect_time' => $redirect_time,
            'html' => $html,

        ];
        return $this->view('DC\LinkProxy:Redirecting', 'DC_LinkProxy_Redirecting', $viewParams);
    }
}
