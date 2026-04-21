<?php

namespace TheJavaSea2024\NowPaymentsAPI;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
	{
		$db = $this->db();

		$db->insert('xf_payment_provider', [
			'provider_id'    => "NowPaymentsAPI",
			'provider_class' => "TheJavaSea2024\\NowPaymentsAPI:NowPaymentsAPI",
			'addon_id'       => "TheJavaSea2024/NowPaymentsAPI"
		]);
	}

public function uninstallStep1()
{
    // 

    // Execute the delete query
		$this->db()->delete('xf_payment_provider', "provider_id = 'NowPaymentsAPI'");
                $this->db()->delete('xf_payment_profile', "provider_id = 'NowPaymentsAPI'");

}

}
