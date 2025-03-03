<?php

namespace FH\Razorpay;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    /*
     * Add providers
     */
    public function installStep1()
    {
        $this->db()->insertBulk('xf_payment_provider', [
            [
                'provider_id' => 'razor_pay',
                'provider_class' => 'FH\\Razorpay:Pay',
                'addon_id' => 'FH/Razorpay'
            ]
        ], 'provider_id');
    }

    public function uninstallStep1()
    {
        // todo
        $this->db()->delete('xf_payment_provider', 'provider_id IN (?)', implode(',', [
            'razor_pay'
        ]));
    }
}