<?php

namespace FS\BitcoinIntegration\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class BitcoinIntegration extends AbstractController
{

	public function actionIndex(ParameterBag $params)
	{
		$viewpParams = [];

		return $this->view('fS\BitcoinIntegration:index', 'fs_bitcoin_upgrade_cards_index', $viewpParams);
	}

	public function actionPurchase()
	{
		$vipMember = \xf::options()->fs_bitcoin_provider_vip_group_id;
		$visitor = \xf::visitor();

		$encryptArray = $this->encrypt(array($visitor->user_id, $vipMember, \xf::$time));


		$viewParams = [
			'encrypt' => $encryptArray,
		];
		return $this->view('FS\BitcoinIntegration:Bitcoin\Purchase', '', $viewParams);
	}

	public function insertPrucase($userId, $upgradeId)
	{
	}

	public function encrypt(array $data)
	{

		$data = json_encode($data);

		$packed = unpack('H*', $data);

		return $packed[1];
	}
}
