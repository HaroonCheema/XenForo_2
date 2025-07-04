<?php

namespace FS\RegisterVerfication;

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

    // ################################ INSTALLATION ######################

    public function installStep1()
    {
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->addColumn('comp_verify_key', 'int')->setDefault(0);
            $table->addColumn('comp_verify_val', 'mediumtext')->nullable()->setDefault(null);
            $table->addColumn('fs_regis_referral', 'varchar', 500)->setDefault('');
        });
    }

    // ############################### UPGRADE ###########################

    public function upgrade1000600Step1(array $stepParams)
    {
        $this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {

            $table->addColumn('fs_regis_referral', 'varchar', 500)->setDefault('');
        });
    }

    // ############################### UNINSTALL ###########################

    public function uninstallStep1()
    {
        $sm = $this->schemaManager();

        $sm->alterTable('xf_user', function (Alter $table) {
            $table->dropColumns(['comp_verify_key', 'comp_verify_val', 'fs_regis_referral']);
        });
    }
}
