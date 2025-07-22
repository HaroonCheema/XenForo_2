<?php

namespace FS\CoinPaymentsIntegrationNew;

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

		$providerClass = 'FS\CoinPaymentsIntegrationNew:CoinPaymentsNew';
		$addonId = 'FS/CoinPaymentsIntegrationNew';

		$sql = "INSERT INTO xf_payment_provider
				(provider_id, provider_class, addon_id)
			VALUES
				('coin_payments_new', ?, ?)";


		$this->db()->query($sql, [$providerClass, $addonId]);
	}

	public function uninstallStep1()
	{
		$sql = "DELETE FROM xf_payment_provider WHERE provider_id='coin_payments_new'";
		$this->db()->query($sql);
	}
}
