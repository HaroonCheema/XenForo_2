<?php

namespace FS\FemaleAgeVerification\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{
    public function actionIndex()
    {
        if (!$this->filter('accept', 'bool')) {
            return $this->view('XF:Register\Form', 'fs_female_age_verfication_terms_conditions', []);
        }

        return parent::actionIndex();
    }

    public function actionRegister()
    {
        if (!$this->filter(['gender' => 'str'])) {
            return $this->error(\XF::phrase('please_complete_required_fields'));
        }

        return parent::actionRegister();
    }

    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $parent = parent::finalizeRegistration($user);

        $gender = $this->filter([
            'gender' => 'str'
        ]);

        $femaleGroup = $this->app()->options()->fsFemaleAgeVerificationGroup;

        if ($femaleGroup != 0 && $gender['gender'] == 'female') {
            $user->bulkSet([
                'gender' => $gender['gender'],
                'user_group_id' => $femaleGroup,
            ]);
        } else {
            $user->bulkSet([
                'gender' => $gender['gender'],
            ]);
        }

        $user->save();

        return $parent;
    }
}
