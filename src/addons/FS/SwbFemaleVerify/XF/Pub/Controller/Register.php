<?php

namespace FS\SwbFemaleVerify\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{

    public function actionRegister()
    {
        $parent = parent::actionRegister();
        
        return $parent;

        $visitor=\xf::visitor();
                
        if($visitor->account_type == 1){
                     
        return $parent;
                     
                 }
                 
        return $this->redirect($this->buildLink('female-verify/add'));
    }
}
