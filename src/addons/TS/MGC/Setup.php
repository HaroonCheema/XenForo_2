<?php

namespace TS\MGC;

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
	
	public function installStep1() {
		
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->addColumn('ts_mgc_counter', 'int', '10')->setDefault(0);
        });		
		
	}
	
	public function uninstallStep1() {
		
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->dropColumns(['ts_mgc_counter']);
        });
		
	}
	
    public function postInstall(array &$stateChanges)
    {
        \XF::repository("XF:User")->rebuildAllGalleryCommentCounters();
    }	
}