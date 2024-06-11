<?php

namespace FS\SubscriptionFeatures\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class UserUpgrade extends XFCP_UserUpgrade
{

    protected function upgradeSaveProcess(\XF\Entity\UserUpgrade $upgrade)
    {
        if (!empty($upgrade['user_upgrade_id'])) {
            $input = $this->filter([
                'cost_amount' => 'unum',
            ]);

            if ($input['cost_amount'] != $upgrade['cost_amount']) {

                $app = \XF::app();

                $userUpgradeId = $upgrade['user_upgrade_id'];

                $jopParams = [
                    'userUpgradeId' => $userUpgradeId,
                    'cost_amount' => $input['cost_amount'],
                ];

                $jobID = $userUpgradeId . '_userUpgradeCostAmount_' . time();

                $app->jobManager()->enqueueUnique($jobID, 'FS\SubscriptionFeatures:UpgradeCostAmount', $jopParams, false);
                // $app->jobManager()->runUnique($jobID, 120);
            }
        }
        return parent::upgradeSaveProcess($upgrade);
    }
}
