<?php

namespace FS\RegisterVerfication\XF\Service\User;

class Registration extends XFCP_Registration {

    public function setFromInput(array $input) {

        $parent = parent::setFromInput($input);

        $compVerifyKey = \xf::app()->request()->filter('comp_verify_key', 'int');

        $compVerifyValue = \xf::app()->request()->filter('comp_verify_val', 'str');

        $accountType = \xf::app()->request()->filter('account_type', 'int');

        if ($accountType == 2) {

            if ($compVerifyValue == "") {

                $this->user->error(\XF::phrase('need_to_full_field_of_verfication'));
            }

            $this->user->comp_verify_key = $compVerifyKey;
            $this->user->comp_verify_val = $compVerifyValue;
        }

        return $parent;
    }
}
