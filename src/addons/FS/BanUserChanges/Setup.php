<?php

namespace FS\BanUserChanges;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installstep1()
	{
		$sm = $this->schemaManager();

		$this->alterTable('xf_user_ban', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('thread_id', 'int')->setDefault(0);
		});
	}

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		$this->schemaManager()->alterTable('xf_user_ban', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['thread_id']);
		});
	}
}
