<?php

namespace FS\TagPermissions;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ############################### INSTALL ###########################

	public function installstep1()
	{
		$this->alterTable('xf_tag', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('fs_usergroup_ids', 'varbinary', 255)->setDefault(null);
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_tag', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['fs_usergroup_ids']);
		});
	}
}
