<?php

namespace FS\BitcoinIntegration;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installstep1()
	{
		$sm = $this->schemaManager();

		$this->query(
			"
				REPLACE INTO `xf_payment_provider`
					(`provider_id`, `provider_class`, `addon_id`)
				VALUES
					('fs_bitcoin', 'FS\\\\BitcoinIntegration:BitcoinIntegration', 'FS/BitcoinIntegration')
			"
		);
	}

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		$this->db()->delete('xf_payment_provider', "provider_id = 'fs_bitcoin'");
	}
}
