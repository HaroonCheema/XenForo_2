<?php

namespace FS\RegistrationSteps\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{

    protected function getRegistrationInput(\XF\Service\User\RegisterForm $regForm)
    {

        $input = parent::getRegistrationInput($regForm);
        $input['account_type'] = $this->filter('account_type', 'int');
        $input['password_confirm'] = $this->filter('password_confirm', 'str');
        return $input;
    }

    public function actionRegister()
    {
        $parent = parent::actionRegister();

        // $compVerifyKey = $this->filter('comp_verify_key', 'int');

        // $accountType = $this->filter('account_type', 'int');

        // if ($compVerifyKey == 10) {

        //     $registerImage = false;

        //     if ($accountType == 2) {
        //         $registerImage = $this->request->getFile('fs_image_companion', false, false);
        //     } elseif ($accountType == 1) {
        //         $registerImage = $this->request->getFile('fs_image', false, false);
        //     }

        //     if (!$registerImage) {

        //         return $this->error(\XF::phrase('please_complete_required_fields'));
        //     }
        // }

        // if ($accountType == 2) {

        //     $regForm = $this->service('XF:User\RegisterForm', $this->session());

        //     $input = $this->getRegistrationInput($regForm);

        //     $dobString = $input['custom_fields']['dateofbirth'] ?? '';

        //     if ($dobString) {
        //         $dob = new \DateTime($dobString);
        //         $today = new \DateTime();

        //         if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dobString)) {
        //             return $this->error("Date of birth Invalid format.");
        //         }

        //         if ($dob > $today) {
        //             return $this->error("Date of birth cannot be in the future.");
        //         }

        //         $age = $dob->diff($today)->y;

        //         if (!($age >= 21)) {
        //             return $this->error(\XF::phrase('fs_sorry_you_must_be_years_old_to_register'));
        //         }
        //     } else {
        //         return $this->error(\XF::phrase('please_complete_required_fields'));
        //     }
        // }

        return $parent;
    }

    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $parent = parent::finalizeRegistration($user);

        $accountType = $this->filter('account_type', 'int');

        if ($user->comp_verify_key == 10) {

            $registerImage = false;

            if ($accountType == 2) {
                $registerImage = $this->request->getFile('fs_image_companion', false, false);
            } elseif ($accountType == 1) {
                $registerImage = $this->request->getFile('fs_image', false, false);
            }

            if ($registerImage) {

                $uploadService = $this->service('FS\RegisterVerfication:Upload', $user);

                if (!$uploadService->setImageFromUpload($registerImage)) {
                    return $this->error($uploadService->getError());
                }

                if (!$uploadService->uploadImage()) {
                    return $this->error(\XF::phrase('new_image_could_not_be_processed'));
                }
            }
        }

        // $registration = $this->service('XF:User\Registration');
        // if ($user && $user->email && $user->account_type == 2) {
        //     $registration->sendverifyMail($user);

        //     $mail = $this->app->mailer()->newMail()->setTo($user->email);
        //     $mail->setTemplate('fs_limitations_companion_mail');
        //     $mail->queue();
        // }

        // if ($user && $user->email && $user->account_type == 1) {

        //     $mail = $this->app->mailer()->newMail()->setTo($user->email);
        //     $mail->setTemplate('fs_limitations_admirer_mail');

        //    $mail->queue();
        // }
        $this->assingStaticGroup($user);
        return $parent;
    }
    protected function assingStaticGroup($user)
    {
        // if ($user &&  $user->account_type == 2) {
        //     $user->user_group_id = 5;
        //     // $user->user_group_id = 16;
        // } elseif ($user &&  $user->account_type == 1) {
        //     $user->user_group_id = 6;
        // }

        $user->user_group_id = 16;
        $user->save();
    }

    protected function sendMail($user)
    {
        $mail = $this->app->mailer()->newMail()->setTo($user->email);
        $mail->setTemplate('fs_register_send_newAccount_mail', [
            'user' => $user
        ]);
        $mail->queue();
    }

    public function actionverify()
    {

        $verifyCode = $this->filter('i', 'str');

        if (!$verifyCode) {

            throw $this->exception(
                $this->error(\XF::phrase("activation_key_not_found"))
            );
        }

        $user = $this->finder('XF:User')->where('activation_id', $verifyCode)->fetchOne();

        if (!$user) {

            throw $this->exception(
                $this->error(\XF::phrase("invalid_activation_key"))
            );
        }

        $this->verifyAccountRequire($verifyCode, $user);

        return $this->redirect($this->getDynamicRedirect());
    }



    public function actiondirectVerify()
    {

        if ($this->ispost()) {

            $username = $this->filter('username', 'str');

            $verifyCode = $this->filter('activation_id', 'str');

            $user = $this->finder('XF:User')->where('username', $username)->fetchOne();

            if (!$user) {

                throw $this->exception(
                    $this->error(\XF::phrase("invalid_username"))
                );
            }


            if ($user->is_verify) {

                throw $this->exception(
                    $this->error(\XF::phrase("you_have_already_verified"))
                );
            }
            if (!$verifyCode) {

                throw $this->exception(
                    $this->error(\XF::phrase("required_activation_key"))
                );
            }

            $this->verifyAccountRequire($verifyCode, $user);

            return $this->redirect($this->buildLink('forums'));
        }

        $visitor = \xf::visitor();

        if ($visitor->user_id && $visitor->is_verify) {

            throw $this->exception(
                $this->error(\XF::phrase("you_have_already_verified"))
            );
        }

        return $this->view('FS\RegistrationSteps', 'fs_direct_verify_account');
    }

    public function verifyAccountRequire($verifyCode, $user)
    {

        if (strcmp($verifyCode, $user->activation_id) != 0) {

            throw new \XF\PrintableException(
                $this->error(\XF::phrase("invalid_activation_key"))
            );
        }

        $user->user_state = "moderated";

        $user->is_verify = 1;

        $user->save();
        // $this->sendMail($user);
    }

    public function actionverifyReagain()
    {

        $visitor = \xf::visitor();

        if (!$visitor->user_id || $visitor->is_verify) {

            throw $this->exception($this->noPermission());
        }

        $registration = $this->service('XF:User\Registration');
        $registration->sendverifyMail($visitor);

        return $this->redirect($this->getDynamicRedirect());
    }

    public function actionPremuim()
    {
        return $this->view('FS\RegistrationSteps', 'fs_register_premiuem');
    }
}
