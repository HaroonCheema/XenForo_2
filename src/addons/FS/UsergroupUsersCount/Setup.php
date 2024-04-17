<?php

namespace FS\UsergroupUsersCount;

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
		$this->alterTable('xf_user_group', function (Alter $table) {
			$table->addColumn('primary_users_count', 'int')->setDefault(0);
			$table->addColumn('secondary_users_count', 'int')->setDefault(0);
		});
	}

	public function postInstall(array &$stateChanges)
	{
		$updateCounts = \xf::app()->service('FS\UsergroupUsersCount:UsersCount');
		$updateCounts->countAllUsers();
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_user_group', function (Alter $table) {
			$table->dropColumns(['primary_users_count']);
			$table->dropColumns(['secondary_users_count']);
		});
	}
}
