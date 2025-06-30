<?php

namespace FS\RegisterVerfication;

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
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->addColumn('comp_verify_key', 'int')->setDefault(0);
            $table->addColumn('comp_verify_val', 'mediumtext')->nullable()->setDefault(null);
        });
    }
}
