<?php

namespace TS\MGM;

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
		
		$this->schemaManager()->createTable('xf_ts_mgm_additional', function(\XF\Db\Schema\Create $table)
		{
			$table->addColumn('entity_id', 'int', 10)->autoIncrement();
			$table->addColumn('media_id', 'int', 10);
			$table->addColumn('additional_id', 'int', 10);
		});
		
	}
	
	public function uninstallStep1() {
		
		$this->schemaManager()->dropTable('xf_ts_mgm_additional');
		
	}
}