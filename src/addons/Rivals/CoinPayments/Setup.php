<?php

namespace Rivals\CoinPayments;

use XF\AddOn\AbstractSetup;

class Setup extends AbstractSetup
{
	public function install(array $stepParams = [])
	{
		$db = \XF::db();

		$db->query("INSERT INTO xf_payment_provider (provider_id, provider_class, addon_id) VALUES ('coinpayments', 'Rivals\\\\CoinPayments\\\\Payment\\\\CoinPayments', 'Rivals\\\\CoinPayments')");
	}

	public function upgrade(array $stepParams = [])
	{

	}

	public function uninstall(array $stepParams = [])
	{
		$db = \XF::db();

		$db->query("DELETE FROM xf_payment_provider WHERE provider_id = 'coinpayments'");
	}
}
