<?php

namespace FS\RegisterVerfication\XF\Service\User;

class Registration extends XFCP_Registration
{

    public function setFromInput(array $input)
    {

        $parent = parent::setFromInput($input);

        $compVerifyKey = \xf::app()->request()->filter('comp_verify_key', 'int');

        $accountType = \xf::app()->request()->filter('account_type', 'int');

        if ($compVerifyKey == 1) {
            $this->user->error(\XF::phrase('please_select_verification_type'));
        }

        if ($accountType == 2) {

            $getVerifyValue = \xf::app()->request()->filter('fs_regis_referral', 'str');

            $this->user->fs_regis_referral = $getVerifyValue ?? "";

            $compVerifyValue = \xf::app()->request()->filter('comp_verify_val', 'str');

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
                // $compVerifyValue = \xf::app()->request()->filter('comp_verify_val', 'str');
                $this->user->comp_verify_val = $compVerifyValue ?? "";
            }

            //     $this->user->error(\XF::phrase('need_to_full_field_of_verfication'));

        } elseif ($accountType == 1) {

            if ($compVerifyKey != 10) {
                $admVerifyValue = \xf::app()->request()->filter('adm_verify_val', 'str');

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
