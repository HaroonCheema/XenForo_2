<?php

namespace NextFlock\JoomlaBridge\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Redirect;

class User extends XFCP_User
{

    public function actionSave(ParameterBag $params)
    {
        if($params->user_id)
        {
            $user = $this->assertUserExists($params->user_id);
            $username = $user->username;
        }

        $response = parent::actionSave($params);

        if (!$params->user_id)
        {
            $input = $this->filter([
                'user' => [
                    'username' => 'str',
                    'email' => 'str',
                    'user_state' => 'str',

                ],
                'password' => 'str',

            ]);

            $userData = [
                'name' => $input['user']['username'],
                'username' => $input['user']['username'],
                'password1' => $input['password'],
                'password2' => $input['password'],
                'email1' => $input['user']['email'],
                'email2' => $input['user']['email'],
                'user_state' => $input['user']['user_state'], // activating the user //@TODO check first
            ];

            $jService =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
            $jService->register($userData);
        }
        else
        {

            $input = [
                'change_password' => 'str',
                'password' => 'str',
                'user' => [
                    'username' => 'str',
                    'email' => 'str',
                    'user_state' => 'str',
                ],
            ];
            $params = $this->filter($input);
            $params['username'] = $username;
            $params['email'] = $params['user']['email'];
            $params['user_state'] = $params['user']['user_state'];
            $params['new_username'] = $params['user']['username'] == $user->username? $params['user']['username']:false;
            $jService =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
            $jService->update($params);
        }



        return $response;
    }

    public function actionDelete(ParameterBag $params)
    {
        $user = $this->assertUserExists($params->user_id);
        $response = parent::actionDelete($params);

        if($response instanceof Redirect)
        {
            $service =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
            $service->delete(['username' => $user->username]);
        }
        return $response;
    }
}
