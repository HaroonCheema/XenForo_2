<?php

namespace FS\DisableBbCodes;

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

	public function installstep1()
	{
		$this->alterTable('xf_bb_code', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('usergroup_ids', 'varbinary', 255);
		});
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_bb_code', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['usergroup_ids']);
		});
	}
}
