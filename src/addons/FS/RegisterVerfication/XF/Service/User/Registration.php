<?php

namespace FS\RegisterVerfication\XF\Service\User;

class Registration extends XFCP_Registration
{

    public function setFromInput(array $input)
    {

        $parent = parent::setFromInput($input);

        $request = \xf::app()->request();

        $compVerifyKey = $request->filter('comp_verify_key', 'int');

        $accountType = $request->filter('account_type', 'int');

        if ($compVerifyKey == 1) {
            $this->user->error(\XF::phrase('please_select_verification_type'));
        }

        if ($compVerifyKey == 10) {

            $registerImage = false;

            if ($accountType == 2) {
                $registerImage = $request->getFile('fs_image_companion', false, false);
            } elseif ($accountType == 1) {
                $registerImage = $request->getFile('fs_image', false, false);
            }

            if (!$registerImage) {

                return $this->user->error(\XF::phrase('please_complete_required_fields'));
            }
        }

        if ($accountType == 2) {

            $dobString = $input['custom_fields']['dateofbirth'] ?? '';

            if ($dobString) {
                $dob = new \DateTime($dobString);
                $today = new \DateTime();

                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dobString)) {
                    return $this->user->error("Date of birth Invalid format.");
                }

                if ($dob > $today) {
                    return $this->user->error("Date of birth cannot be in the future.");
                }

                $age = $dob->diff($today)->y;

                if (!($age >= 21)) {
                    return $this->user->error(\XF::phrase('fs_sorry_you_must_be_years_old_to_register'));
                }
            } else {
                return $this->user->error(\XF::phrase('please_complete_required_fields'));
            }

            $getVerifyValue = $request->filter('fs_regis_referral', 'str');

            $this->user->fs_regis_referral = $getVerifyValue ?? "";

            $compVerifyValue = $request->filter('comp_verify_val', 'str');

            if (strlen($compVerifyValue) < 1 && $compVerifyKey != 10) {

                $this->user->error(\XF::phrase('please_complete_required_fields'));
            }

            if ($compVerifyKey == 2) {

                if (strlen($compVerifyValue) > 7 || $compVerifyValue == "") {
                    $this->user->error(\XF::phrase('P411 Not allow to more than 7 characters'));
                } else {
                    $this->user->comp_verify_val = $compVerifyValue ?? "";
                }
            } elseif ($compVerifyKey != 10) {
                // $compVerifyValue = $request->filter('comp_verify_val', 'str');
                $this->user->comp_verify_val = $compVerifyValue ?? "";
            }

            //     $this->user->error(\XF::phrase('need_to_full_field_of_verfication'));

        } elseif ($accountType == 1) {

            if ($compVerifyKey != 10) {
                $admVerifyValue = $request->filter('adm_verify_val', 'str');

                if (strlen($admVerifyValue) < 1) {
                    // if ($compVerifyKey == 2 && strlen($admVerifyValue) < 1) {

                    $this->user->error(\XF::phrase('please_complete_required_fields'));
                }
                $this->user->comp_verify_val = $admVerifyValue ?? "";
            }
        }

        $this->user->comp_verify_key = $compVerifyKey;

        return $parent;
    }
}
