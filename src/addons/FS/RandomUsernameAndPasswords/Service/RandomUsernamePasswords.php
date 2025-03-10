<?php

namespace FS\RandomUsernameAndPasswords\Service;

class RandomUsernamePasswords extends \XF\Service\AbstractService
{
    public function changeUsernamePassword(\XF\Entity\User $user)
    {
        $randomPassword = $this->generateRandomPassword();

        /** @var \XF\Service\User\PasswordChange $passwordChange */

        $passwordChange = \XF::service('XF:User\PasswordChange', $user, $randomPassword);
        if (!$passwordChange->isValid($error)) {
            return false;
        }

        $passwordChange->setInvalidateRememberKeys(false);
        $passwordChange->save();

        $randomUser = \XF::finder('FS\RandomUsernameAndPasswords:RandomUsers')->where('is_name_used', 0)->fetchOne();

        $randomUsername = ucfirst(strtolower(trim($randomUser['first_name']) . trim($randomUser['last_name'])));

        $user->bulkSet([
            'username' => $randomUsername,
            'is_renamed' => 1
        ]);
        $user->save();

        $randomUser->bulkSet([
            'is_name_used' => 1
        ]);
        $randomUser->save();

        return true;
    }

    public function generateRandomPassword($length = 12, $addSpecialChars = true)
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}<>?';

        $allChars = $lowercase . $uppercase . $numbers;
        if ($addSpecialChars) {
            $allChars .= $specialChars;
        }

        $password = '';
        $allCharsLength = strlen($allChars);

        for ($i = 0; $i < $length; $i++) {
            $password .= $allChars[random_int(0, $allCharsLength - 1)];
        }

        return $password;
    }
}
