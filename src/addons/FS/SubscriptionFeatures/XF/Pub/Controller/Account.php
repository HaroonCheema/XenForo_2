<?php

namespace FS\SubscriptionFeatures\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{

    public function actionUpgrades()
    {
        $parent = parent::actionUpgrades();

        if ($parent instanceof \XF\Mvc\Reply\View) {
            list($available, $purchased) = $this->getFilteredUserUpgradesForList();

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

    protected function findUserUpgradesForList()
    {
        $options = \XF::options();

        $ids = explode(',', $options->fs_subscrip_applicable_userGroups);

        return $this->finder('XF:UserUpgrade')->where('user_upgrade_id', $ids)
            ->setDefaultOrder('display_order');
    }

    protected function getFilteredUserUpgradesForList()
    {
        $visitor = \XF::visitor();

        $finder = $this->findUserUpgradesForList()
            ->with(
                'Active|'
                    . $visitor->user_id
                    . '.PurchaseRequest'
            );

        $purchased = [];
        $upgrades = $finder->fetch();

        if ($visitor->user_id && $upgrades->count()) {
            /** @var \XF\Entity\UserUpgrade $upgrade */
            foreach ($upgrades as $upgradeId => $upgrade) {
                if (isset($upgrade->Active[$visitor->user_id])) {
                    // purchased
                    $purchased[$upgradeId] = $upgrade;
                    unset($upgrades[$upgradeId]); // can't buy again

                    // remove any upgrades disabled by this
                    foreach ($upgrade['disabled_upgrade_ids'] as $disabledId) {
                        unset($upgrades[$disabledId]);
                    }
                } else if (!$upgrade->canPurchase()) {
                    unset($upgrades[$upgradeId]);
                }
            }
        }

        return [$upgrades, $purchased];
    }
}
