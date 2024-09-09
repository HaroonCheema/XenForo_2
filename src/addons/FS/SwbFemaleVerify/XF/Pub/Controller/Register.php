<?php

namespace FS\SwbFemaleVerify\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{

    public function actionRegister()
    {
        $parent = parent::actionRegister();

        return $this->redirect($this->buildLink('female-verify/add'));
    }
}
