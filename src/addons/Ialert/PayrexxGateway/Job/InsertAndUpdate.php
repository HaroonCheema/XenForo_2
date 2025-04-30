<?php

namespace Ialert\PayrexxGateway\Job;

use XF\Job\AbstractJob;

class InsertAndUpdate extends AbstractJob
{

    public function run($maxRunTime)
    {

        $user = \XF::em()->find('XF:User', 337328);

        if ($user) {
            $user->email = "testingosdkfl121@gmail.com";
            $user->save();
        }

        return $this->complete();


        if ($this->data['user_id']) {

            $upgradeLog = \XF::em()->create('Ialert\PayrexxGateway:ReviewBalanceUpgradeLog');
            $upgradeLog->user_id = $this->data['user_id'];
            $upgradeLog->date = date('Y-m-d');
            $upgradeLog->gain = $this->data['getGainDays'];

            $upgradeLog->save();


            $user = \XF::em()->find('XF:User', $this->data['user_id']);

            if ($user) {
                $user->reviews_balance += $this->data['getGainDays'];
                $user->save();
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
