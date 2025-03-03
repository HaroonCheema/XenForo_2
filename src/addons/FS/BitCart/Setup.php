<?php

namespace FS\BitCart;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
class Setup extends AbstractSetup {

    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;


    public function installStep1() {
        
        $this->db()->insertBulk('xf_payment_provider', [
            [
                'provider_id' => 'bit_cart',
                'provider_class' => 'FS\\BitCart:Cart',
                'addon_id' => 'FS/BitCart'
            ]
                ], 'provider_id');

//        $this->schemaManager()->alterTable('xf_purchase_request', function (Alter $alter) {
//            $alter->addColumn('bitcart', "mediumtext")->nullable()->setDefault(null);
//        });
    }

    public function uninstallStep1() {
        
        $this->db()->delete('xf_payment_provider', 'provider_id IN (?)', implode(',', [
            'bit_cart'
        ]));

        $sm = $this->schemaManager();

//        $sm->alterTable('xf_purchase_request', function (Alter $alter) {
//            $alter->dropColumns(['bitcart']);
//        });
    }
}
