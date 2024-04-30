<?php

namespace FS\BatchProfile;

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
		$this->alterTable('fs_usergroup_batch', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('allow_thread', 'tinyint', 3)->setDefault(1);
			$table->addColumn('allow_profile', 'tinyint', 3)->setDefault(1);
		});
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('fs_usergroup_batch', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['allow_thread']);
			$table->dropColumns(['allow_profile']);
		});
	}
}
