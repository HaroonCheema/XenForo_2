<?php

namespace NextFlock\JoomlaBridge\XF\Pub\Controller;

use XF\Mvc\Reply\Redirect;


class Account extends XFCP_Account
{

    /**
     * @return \XF\Service\User\PasswordChange
     *
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function setupPasswordChange()
    {
        $response = Parent::setupPasswordChange();
        $input = $this->filter([
            'old_password' => 'str',
            'password' => 'str',
            'password_confirm' => 'str'
        ]);

        $visitor = \XF::visitor();

        $jService =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
        $jService->update([
            'password' => $input['password'],
            'username' => $visitor->username
        ]);

        return $response;
    }

    protected function emailSaveProcess(\XF\Entity\User $visitor)
    {
        $input = $this->filter([
            'email' => 'str',
            'password' => 'str'
        ]);
        $visitorOldEmail = $visitor->email;

        $response = Parent::emailSaveProcess($visitor);


        if ($input['email'] != $visitorOldEmail || $visitor->user_state === 'email_bounce')
        {
            $jService =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
            $jService->updateEmail([
                'email' => $input['email'],
                'username' => $visitor->username
            ]);
        }

        return $response;
    }
}
