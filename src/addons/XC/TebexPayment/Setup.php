<?php

namespace XC\TebexPayment;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

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
        $sm = $this->schemaManager();
        $this->db()->insertBulk('xf_payment_provider', [
            [
                'provider_id' => 'xc_tebex',
                'provider_class' => 'XC\\TebexPayment:Tebex',
                'addon_id' => 'XC/TebexPayment'
            ]
        ], 'provider_id');
        
         $sm->alterTable('xf_user_group', function (Alter $table) {
            $table->addColumn('wallet_address', 'mediumtext')->nullable()->setDefault(null);;
            $table->addColumn('comission', 'double')->nullable()->unsigned(false)->setDefault(0);
        });
    }

    public function uninstallStep1()
    {
         $sm = $this->schemaManager();
          
        $this->db()->delete('xf_payment_provider', 'provider_id IN (?)', implode(',', [
            'xc_tebex'
        ]));
        
         $sm->alterTable('xf_user_group', function (Alter $table) {
            $table->dropColumns(['wallet_address','comission']);
        });
    }
    
    public function upgrade1080010Step1()
    {
         $sm = $this->schemaManager();
        $sm->alterTable('xf_user_group', function (Alter $table) {
            $table->addColumn('wallet_address', 'mediumtext')->nullable()->setDefault(null);;
            $table->addColumn('comission', 'double')->nullable()->unsigned(false)->setDefault(0);
        });
        
    }
}