<?php

namespace FS\BitcoinIntegration\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class BitcoinIntegration extends AbstractController
{
	public function actionIndex(ParameterBag $params)
	{

		$visitor = \XF::visitor();

		if($visitor->account_type==1){
		return $this->noPermission();
		}

		
		$premiumUpgradeId = \xf::options()->fs_bitcoin_premium_companion;
		$providerCityUpgradeId = \xf::options()->fs_bitcoin_provider_city;
		$vipUpgradeId = \xf::options()->fs_bitcoin_vip_companion;
		$providerVipUpgradeId = \xf::options()->fs_bitcoin_provider_vip;

		$app = \xf::app();

		if (!$premiumUpgradeId || !$providerCityUpgradeId || !$vipUpgradeId  || !$providerVipUpgradeId) {
			($this->notFound(\XF::phrase("Admin options setting reuired...!"))
			);
		}

		$premiumUpgrade = $app->em()->find('XF:UserUpgrade', $premiumUpgradeId);
		$providerCityUpgrade = $app->em()->find('XF:UserUpgrade', $providerCityUpgradeId);
		$vipUpgrade = $app->em()->find('XF:UserUpgrade', $vipUpgradeId);
		$providerVipUpgrade = $app->em()->find('XF:UserUpgrade', $providerVipUpgradeId);

		$premiumExist = $this->checkExisting($visitor->user_id, $premiumUpgradeId);

		$viewpParams = [
			'premiumUpgrade' => $premiumUpgrade,
			'providerCityUpgrade' => $providerCityUpgrade,
			'vipUpgrade' => $vipUpgrade,
			'providerVipUpgrade' => $providerVipUpgrade,
			'premiumExist' => $premiumExist ? false : true,
		];

		return $this->view('fS\BitcoinIntegration:index', 'fs_bitcoin_upgrade_cards_index', $viewpParams);
	}

	protected function checkExisting($userId, $upgradeGroupId)
	{
		$groupExist = $this->finder('FS\BitcoinIntegration:PurchaseRec')
			->where('user_id', $userId)->where('user_upgrade_id', $upgradeGroupId)->where('status', 2)->where('end_at', '>', \XF::$time)->fetchOne();

		return $groupExist ? true : false;
	}

	public function actionPurchase()
	{

		$optionValue = $this->filter('optionValue', 'str');

		if (!$optionValue) {

			throw $this->exception(
				$this->notFound(\XF::phrase("complete Admin option Setting....!"))
			);
		}

		$widgetId = $optionValue . '_widget_uid';
		$userUpgradeId = \xf::options()->$optionValue;

		$widgetuuId = \xf::options()->$widgetId;


		$app = \xf::app();

		if (!$userUpgradeId || !$widgetuuId) {

			throw $this->exception(
				$this->notFound(\XF::phrase("complete Admin option Setting.....!"))
			);
		}


		$userUpgrade = $app->em()->find('XF:UserUpgrade', $userUpgradeId);


		if (!$userUpgrade) {

			throw $this->exception(
				$this->notFound(\XF::phrase("User upgrade not found.....!"))
			);
		}

		$visitor = \xf::visitor();
		if($visitor->account_type==1){
		return $this->noPermission();
		}


		if (!$visitor->user_id) {
			return $this->noPermission();
		}

		$premiumExist = $this->checkExisting($visitor->user_id, $userUpgradeId);

		if ($premiumExist && $userUpgrade->getUserUpgradeExit()) {

			return $this->noPermission();
		}

		$data = $this->insertPrucase($visitor->user_id, $userUpgradeId);

		$encryptArray = $this->encrypt(array($data->id, $visitor->user_id, $userUpgradeId, \xf::$time));

		$viewParams = [
			'widgetId' => $widgetuuId,
			'userUpgrade' => $userUpgrade,
			'encrypt' => $encryptArray,
		];
		return $this->view('FS\BitcoinIntegration:Bitcoin\Purchase', '', $viewParams);
	}

	public function insertPrucase($userId, $upgradeId)
	{
		$insertData = $this->em()->create('FS\BitcoinIntegration:PurchaseRec');

		$insertData->user_id = $userId;
		$insertData->user_upgrade_id = $upgradeId;
		$insertData->save();

		return $insertData;
	}

	public function encrypt(array $data)
	{
		$data = json_encode($data);

		$packed = unpack('H*', $data);

		return $packed[1];
	}
}
