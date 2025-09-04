<?php

namespace FS\UpgradePauseUnpause\Job;

use XF\Job\AbstractJob;

class UserUpgradeUnpause extends AbstractJob
{
    public function run($maxRunTime)
    {
        if ($this->data['user_id']) {

            $userUpgradePaused = \XF::finder('FS\UpgradePauseUnpause:UpgradePaused')->where('user_id', $this->data['user_id'])->fetchOne();

            if ($userUpgradePaused) {

                $endDate = 0;

                if ($userUpgradePaused['UserUpgradeExpired']['original_end_date']) {
                    $endDate = (time() - $userUpgradePaused['create_at']) + $userUpgradePaused['UserUpgradeExpired']['original_end_date'];
                }

                /** @var \XF\Service\User\Upgrade $upgradeService */
                $upgradeService = \XF::app()->service('XF:User\Upgrade', $userUpgradePaused['UserUpgradeExpired']['Upgrade'], $userUpgradePaused['UserUpgradeExpired']['User']);
                $upgradeService->setEndDate($endDate);
                $upgradeService->setPurchaseRequestKey($userUpgradePaused['UserUpgradeExpired']['purchase_request_key']);
                $upgradeService->setExtraData($userUpgradePaused['UserUpgradeExpired']['extra']);

                $upgradeService->ignoreUnpurchasable(true);
                $upgradeService->upgrade();

                $userUpgradePaused->delete();
            }
        }

        return $this->complete();
    }

    public function writelevel() {}

    public function getStatusMessage()
    {
        return \XF::phrase('processing_successfully...');
    }

    public function canCancel()
    {
        return false;
    }

    public function canTriggerByChoice()
    {
        return false;
    }
}
