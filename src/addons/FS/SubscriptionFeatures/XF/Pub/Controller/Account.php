<?php

namespace FS\SubscriptionFeatures\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{

    public function actionUpgrades()
    {
        $parent = parent::actionUpgrades();

        if ($parent instanceof \XF\Mvc\Reply\View) {
            $upgradeRepo = $this->repository('XF:UserUpgrade');
            list($available, $purchased) = $upgradeRepo->getFilteredUserUpgradesForList();

            if (!$available && !$purchased) {
                return $this->message(\XF::phrase('no_account_upgrades_can_be_purchased_at_this_time'));
            }

            $parent->setParams([
                'purchased' => $purchased,
                'available' => $available,
            ]);
        }

        return $parent;
    }

    public function actionDowngrade()
    {
        $activeUpgrade = $this->assertRecordExists(
            'XF:UserUpgradeActive',
            $this->filter('user_upgrade_record_id', 'uint'),
            ['Upgrade', 'User']
        );

        $user = \XF::visitor();

        if (!($activeUpgrade->User->user_id == $user->user_id && $activeUpgrade)) {
            return $this->noPermission();
        }

        if ($this->isPost()) {
            /** @var \XF\Service\User\Downgrade $downgradeService */
            $downgradeService = $this->service('XF:User\Downgrade', $activeUpgrade->Upgrade, $activeUpgrade->User);
            $downgradeService->setSendAlert(false);
            $downgradeService->downgrade();

            return $this->redirect($this->buildLink('donations'));
        } else {
            $viewParams = [
                'activeUpgrade' => $activeUpgrade
            ];
            return $this->view('XF:UserUpgrade\Downgrade', 'fs_user_upgrade_active_downgrade', $viewParams);
        }
    }
}
