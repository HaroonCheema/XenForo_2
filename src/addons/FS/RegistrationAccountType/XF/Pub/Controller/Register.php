<?php

namespace FS\RegistrationAccountType\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{

    public function actionRegister()
    {
        if (!$this->filter('reg_account_type', 'str')) {
            return $this->error(\XF::phrase('please_complete_required_fields'));
        }

        if ($this->filter('reg_account_type', 'str') == "donee") {

            $referrerId = \XF::app()->request()->getCookie('referrer_id');

            if (!$referrerId) {
                return $this->error(\XF::phrase('fs_registration_account_type_referrer_required'));
            }
        }

        return parent::actionRegister();
    }

    protected function getRegistrationInput(\XF\Service\User\RegisterForm $regForm)
    {
        $input = parent::getRegistrationInput($regForm);

        $input['reg_account_type'] = $this->filter('reg_account_type', 'str');

        return $input;
    }

    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $parent = parent::finalizeRegistration($user);

        $user->bulkSet([
            'reg_account_type' => $this->filter('reg_account_type', 'str'),
        ]);

        $user->save();

        return $parent;
    }
}
