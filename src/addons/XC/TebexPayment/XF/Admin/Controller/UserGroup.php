<?php

namespace XC\TebexPayment\XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class UserGroup extends XFCP_UserGroup
{
    protected function userGroupSaveProcess(\XF\Entity\UserGroup $userGroup)
	{
        
        
        $parent=parent::userGroupSaveProcess($userGroup);
        $input = $this->filter([
			'wallet_address' => 'str',
			'comission' => 'num',
			
		]);
        
       
        if(isset($input['wallet_address']) && !$input['comission']){
                
            	
            throw $this->exception($this->error(\XF::phrase('xc_tebex_both_field_required')));
            
            
        }
        
        if(!$input['wallet_address'] && $input['comission']){
         
              
              throw $this->exception($this->error(\XF::phrase('xc_tebex_both_field_required')));
          }
        
      
       
         if(isset($input['wallet_address']) && isset($input['comission'])){
        
             if(!is_numeric($input['comission'])){
                 
                   throw $this->exception($this->error(\XF::phrase('tebex_revenue_share_should_be_digit')));
             }
             
         }

        
        
        $parent->basicEntitySave($userGroup,$input);
        
        return $parent;
        }
    
    
}
    