<?php

namespace FS\ShowcaseAddonShorUrl;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1() {
        $this->schemaManager()->alterTable('xf_xa_sc_category', function (\XF\Db\Schema\Alter $table) {
            $table->addColumn('short_url', 'varchar',255)->setDefault('');
            
        });
    }
 
    public function uninstallStep1() {
        $this->schemaManager()->alterTable('xf_xa_sc_category', function (\XF\Db\Schema\Alter $table) {
            $table->dropColumns(['short_url']);
        });
    }
}