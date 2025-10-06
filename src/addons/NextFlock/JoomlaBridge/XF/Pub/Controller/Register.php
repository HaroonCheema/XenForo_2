<?php


namespace NextFlock\JoomlaBridge\XF\Pub\Controller;

class Register extends XFCP_Register
{
    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $regForm = $this->service('XF:User\RegisterForm', $this->session());
        $input = $this->getRegistrationInput($regForm);

        $userData = [
            'name' => $input['username'],
            'username' => $input['username'],
            'password1' => $input['password'],
            'password2' => $input['password'],
            'email1' => $input['email'],
            'email2' => $input['email'],
            'user_state' => $user->user_state,
        ];

        $jService =  $this->service('NextFlock\JoomlaBridge:JoomlaBridge');
        $jService->register($userData);
        return parent::finalizeRegistration($user);
    }

}
