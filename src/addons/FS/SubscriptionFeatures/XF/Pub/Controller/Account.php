<?php

namespace FS\SubscriptionFeatures\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{
    public function actionDowngrade()
    {
        $activeUpgrade = $this->assertRecordExists(
            'XF:UserUpgradeActive',
            $this->filter('user_upgrade_record_id', 'uint'),
            ['Upgrade', 'User']
        );

        if ($this->isPost()) {
            /** @var \XF\Service\User\Downgrade $downgradeService */
            $downgradeService = $this->service('XF:User\Downgrade', $activeUpgrade->Upgrade, $activeUpgrade->User);
            $downgradeService->setSendAlert(false);
            $downgradeService->downgrade();

            return $this->redirect($this->buildLink('crud'));
        } else {
            $viewParams = [
                'activeUpgrade' => $activeUpgrade
            ];
            return $this->view('XF:UserUpgrade\Downgrade', 'fs_user_upgrade_active_downgrade', $viewParams);
        }
    }
}
