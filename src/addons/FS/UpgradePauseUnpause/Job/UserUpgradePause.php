<?php

namespace FS\UpgradePauseUnpause\Job;

use XF\Job\AbstractJob;

class UserUpgradePause extends AbstractJob
{
    public function run($maxRunTime)
    {
        if ($this->data['user_id']) {

            $userUpgrade = \XF::finder('XF:UserUpgradeActive')->where('user_id', $this->data['user_id'])->fetchOne();

            if ($userUpgrade) {

                $activeUpgrade = \XF::finder('XF:UserUpgradeActive')->where('user_upgrade_record_id', $userUpgrade['user_upgrade_record_id'])
                    ->with(['Upgrade', 'User'])->fetchOne();

                /** @var \XF\Service\User\Downgrade $downgradeService */
                $downgradeService = \XF::app()->service('XF:User\Downgrade', $activeUpgrade->Upgrade, $activeUpgrade->User);
                $downgradeService->setSendAlert(false);
                $downgradeService->downgrade();

                $upgradePausedRecord = \XF::em()->create('FS\UpgradePauseUnpause:UpgradePaused');

                $upgradePausedRecord->user_upgrade_record_id = $userUpgrade['user_upgrade_record_id'];
                $upgradePausedRecord->user_id = $this->data['user_id'];
                $upgradePausedRecord->save();
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
