<?php


namespace Ialert\PayrexxGateway\XF\Admin\Controller;


class User extends \XF\Admin\Controller\User
{

    private $user;

    protected function userSaveProcess(\XF\Entity\User $user)
    {
        $this->user = $user;

        $add_balance = $this->filter('add_balance', 'int');
        if ($add_balance > 0) {
            $this->insertReviewLog($add_balance);
            $this->updateUserBalance($add_balance);
        }

        return parent::userSaveProcess($user);
    }

    protected function insertReviewLog($amount)
    {

        $upgradeLog = $this->getTodayLog($this->user->user_id);

        if (null === $upgradeLog) {
            $upgradeLog = $this->em()->create('Ialert\PayrexxGateway:ReviewBalanceUpgradeLog');
            $upgradeLog->user_id = $this->user->user_id;
            $upgradeLog->date = date('Y-m-d');
        }

        $upgradeLog->gain += $this->getGainDays($amount);

        $upgradeLog->save();
    }


    protected function getGainDays($amount)
    {

        return $amount;
    }

    protected function getTodayLog($userid)
    {
        return $this->app
            ->finder('Ialert\PayrexxGateway:ReviewBalanceUpgradeLog')
            ->where('date', date('Y-m-d'))
            ->where('user_id', $userid)
            ->fetchOne();
    }

    protected function updateUserBalance($amount)
    {

        $user = $this->em()->find('XF:User', $this->user->user_id);

        if ($user) {
            $user->reviews_balance += $this->getGainDays($amount);
            $user->save();
        }
    }
}
