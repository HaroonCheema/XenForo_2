<?php

namespace XenBulletins\PaySeraIntegration\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class UserUpgrade extends XFCP_UserUpgrade {
    
    	protected function upgradeSaveProcess(\XF\Entity\UserUpgrade $upgrade)
	{
		$form = $this->formAction();

		$input = $this->filter([
			'title' => 'str',
			'description' => 'str',
			'display_order' => 'uint',
			'extra_group_ids' => 'array-uint',
			'recurring' => 'bool',
			'cost_amount' => 'unum',
			'cost_currency' => 'str',
			'length_amount' => 'uint',
			'length_unit' => 'string',
			'payment_profile_ids' => 'array-uint',
			'disabled_upgrade_ids' => 'array-uint',
			'can_purchase' => 'bool'
		]);
                
                
                
                $payseraProfileId = $this->finder('XF:PaymentProfile')->where('provider_id','paysera')->pluckFrom('payment_profile_id')->fetchOne();
                if($payseraProfileId)
                {
                      
                    if(in_array($payseraProfileId, $input['payment_profile_ids']) && $input['recurring'])
                    {
                        throw $this->exception($this->error(\XF::phrase('recurring_with_paysera_not_allowed')));
                    }
                }

		$form->basicEntitySave($upgrade, $input);

		$form->setup(function() use($upgrade)
		{
			if ($this->filter('length_type', 'str') == 'permanent')
			{
				$upgrade->length_amount = 0;
				$upgrade->length_unit = '';
			}
		});

		return $form;
	}
}
