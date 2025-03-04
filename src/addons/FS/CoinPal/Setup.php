<?php

namespace FS\CoinPal;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	/*
     * Add providers
     */
	public function installStep1()
	{
		$this->db()->insertBulk('xf_payment_provider', [
			[
				'provider_id' => 'coin_pal',
				'provider_class' => 'FS\\CoinPal:Coin',
				'addon_id' => 'FS/CoinPal'
			]
		], 'provider_id');
	}

	public function uninstallStep1()
	{
		$this->db()->delete('xf_payment_provider', 'provider_id IN (?)', implode(',', [
			'coin_pal'
		]));
	}
}
