<?php

namespace FS\ClaimEmails\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{
    public $isClaimed = 0;

    protected function setupRegistration(array $input)
    {

        $regForm = $this->service('XF:User\RegisterForm', $this->session());

        $input = $this->getRegistrationInput($regForm);

        if ($input['email']) {

            $pervUser = $this->finder('XF:User')->where('email', $input['email'])->where('is_claimed', 0)->where('is_new', 0)->fetchOne();

            if ($pervUser) {
                $options = \XF::options();

                $randomEmail = $this->generateRandomEmail($options->fs_ranfom_email_domain, $options->fs_email_limit);

                $pervUser->bulkSet([
                    'email' => $randomEmail,
                ]);

                $pervUser->save();

                $this->isClaimed = $pervUser['user_id'];
            }
        }

        $parent = parent::setupRegistration($input);

        return $parent;
    }

    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $parent = parent::finalizeRegistration($user);

        $user->bulkSet([
            'is_new' => 1,
            'is_claimed' => $this->isClaimed,
        ]);

        $user->save();

        $this->isClaimed = 0;

        return $parent;
    }

    protected function generateRandomEmail($domain, $length)
    {
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';

        $randomString = $letters[rand(0, strlen($letters) - 1)];

        for ($i = 1; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString . '@' . $domain;
    }
}
