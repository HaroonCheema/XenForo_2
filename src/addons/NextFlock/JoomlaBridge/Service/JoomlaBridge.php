<?php

namespace NextFlock\JoomlaBridge\Service;

use XF\Service\AbstractService;
use XF\Mvc\Reply\Redirect;

class JoomlaBridge extends AbstractService
{
    private $baseUrl,$token,$boardUrl;
    public function __construct(\XF\App $app)
    {
        $options = \XF::options();
        $this->baseUrl = $options->nf_jb_baseurl . '/index.php?option=com_xf2bridge';
        $this->token = $options->nf_jb_token;
        $this->boardUrl = $options->boardUrl;
    }

    public function sendRequest($action, $params = [])
    {
//        $data = [
//            'token' => $this->token,
//            'action' => $action,
//            'params' => $params
//        ];
//        $params['option'] = 'com_xf2bridge';
        $params['token'] = $this->token;
        $params['action'] = $action;
        $params = http_build_query($params);

        // Initialize cURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        dd(\XF::options()->nf_jb_baseurl.'/index.php');
        // Set request URL for Joomla
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl."&".$params);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, $this->boardUrl);
        $output = curl_exec($ch);
        if ($output === false) {
//            var_dump(curl_error($ch), curl_errno($ch));exit;
        }
        curl_close($ch);
        return $output;
    }

    protected function redirectForRequest($action, $params = [])
    {
        $user = \XF::visitor();
        $params['token'] = $this->token;
        $params['action'] = $action;
        $params['username'] = $user->username;
//        $params['params'] = ['username' => $user->username];
        $params = http_build_query($params);
        header('Location:'." ". $this->baseUrl."&".$params, true, 302);
        exit();
    }

    public function login()
    {
        $this->redirectForRequest('autoLogin');
    }

    public function logout()
    {
        return $this->redirectForRequest('logoutUser');
    }

    public function register($params)
    {
        return $this->sendRequest('register',$params);
    }

    public function delete($params)
    {
        return $this->sendRequest('delete',$params);
    }

    public function update($params)
    {
        return $this->sendRequest('update',$params);
    }

    public function updateEmail($params)
    {

        return $this->sendRequest('updateEmail',$params);
    }

}
