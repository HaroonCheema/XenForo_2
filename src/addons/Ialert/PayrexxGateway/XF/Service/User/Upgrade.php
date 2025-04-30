<?php

namespace Ialert\PayrexxGateway\XF\Service\User;

class Upgrade extends \XF\Service\User\Upgrade
{

    public function upgrade()
    {
        $active = parent::upgrade();

        if ($active && $this->userUpgrade->is_review_balance && $this->userUpgrade->length_amount > 0) {
            // $this->insertReviewLog();
            // $this->updateUserBalance();

            $app = \XF::app();
            $jobID = "log_balance_" . time();

            $jobParams = [
                'user_id' => $this->user->user_id,
                'getGainDays' => $this->getGainDays()
            ];

            $app->jobManager()->enqueueUnique($jobID, 'Ialert\PayrexxGateway:InsertAndUpdate', $jobParams, false);
        }

        return $active;
    }

    // protected function insertReviewLog()
    // {
    //     $upgradeLog = $this->em()->create('Ialert\PayrexxGateway:ReviewBalanceUpgradeLog');
    //     $upgradeLog->user_id = $this->user->user_id;
    //     $upgradeLog->date = date('Y-m-d');
    //     $upgradeLog->gain = $this->getGainDays();

    //     $upgradeLog->save();
    // }

    protected function getGainDays()
    {

        switch ($this->userUpgrade->length_unit) {
            case 'month':
                return $this->userUpgrade->length_amount * 30;
                break;
            case 'year':
                return $this->userUpgrade->length_amount * 365;
                break;
            case 'day':
            default:
                return $this->userUpgrade->length_amount;
                break;
        }
    }

    // protected function updateUserBalance()
    // {

    //     $user = \XF::em()->find('XF:User', $this->user->user_id);

    //     if ($user) {
    //         $user->reviews_balance += $this->getGainDays();
    //         $user->save();
    //     }
    // }
}
