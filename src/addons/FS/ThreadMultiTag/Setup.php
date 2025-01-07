<?php

namespace FS\ThreadMultiTag;

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

    public function installstep1() {
        $sm = $this->schemaManager();

        $sm->alterTable('xf_tag_content', function (Alter $table) {
            $table->addColumn('multi_order', 'int')->setDefault(0);
        });
    }

    public function uninstallStep1() {
        $sm = $this->schemaManager();

        $sm->alterTable('xf_tag_content', function (Alter $table) {

            $table->dropColumns(['multi_order']);
        });
    }
}
