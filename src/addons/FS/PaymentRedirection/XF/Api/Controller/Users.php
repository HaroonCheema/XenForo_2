<?php

namespace FS\PaymentRedirection\XF\Api\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

class Users extends XFCP_Users
{
    public function actionPostUpgradeUser()
    {

        $options = \XF::options();
        $userUpgradeIdsNew = [];

        $user = false;
        $upgrade = false;

        $userId = $this->filter('user_id', 'int');
        $endDate = $this->filter('endDate', 'int');
        $userUpgradeId = $this->filter('user_upgrade_id', 'int');
        $upgradeTitle = $this->filter('title', 'str');

        $username = ltrim($this->filter('username', 'str', ['no-trim']));

        $userUpgradIdsOption = $options->fspr_user_upgrade_ids;

        if ($userUpgradIdsOption) {
            $pairArray = explode(',', $userUpgradIdsOption);
            $userUpgradeIds = array_map('trim', $pairArray);

            foreach ($userUpgradeIds as $pair) {
                list($key, $value) = array_map('trim', explode(':', $pair));
                $userUpgradeIdsNew[$key] = intval($value);
            }
        }

        if ($username !== '' && utf8_strlen($username) >= 2) {
            $user = $this->em()->findOne('XF:User', ['username' => $username]);
        }

        if ($userUpgradeIdsNew && isset($userUpgradeIdsNew[$userUpgradeId]) && $userUpgradeId != 0) {
            $upgrade = $this->em()->findOne('XF:UserUpgrade', ['user_upgrade_id' => $userUpgradeIdsNew[$userUpgradeId]]);
        }

        if ($user && $upgrade) {

            /** @var \XF\Service\User\Upgrade $upgradeService */
            $upgradeService = $this->service('XF:User\Upgrade', $upgrade, $user);
            $upgradeService->setEndDate($endDate);
            $upgradeService->ignoreUnpurchasable(true);
            $upgradeService->upgrade();
        }

        return $this->apiSuccess();
    }
}
