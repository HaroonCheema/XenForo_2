<?php

namespace FS\NowPaymentsIntegration;

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

		$providerClass = 'FS\NowPaymentsIntegration:NowPayments';
		$addonId = 'FS/NowPaymentsIntegration';

		$sql = "INSERT INTO xf_payment_provider
				(provider_id, provider_class, addon_id)
			VALUES
				('now_payments', ?, ?)";


		$this->db()->query($sql, [$providerClass, $addonId]);
	}

	public function uninstallStep1()
	{
		$sql = "DELETE FROM xf_payment_provider WHERE provider_id='now_payments'";
		$this->db()->query($sql);
	}
}
