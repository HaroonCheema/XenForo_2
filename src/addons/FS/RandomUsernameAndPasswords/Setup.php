<?php

namespace FS\RandomUsernameAndPasswords;

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

		$sm = $this->schemaManager();

		$sm->alterTable('xf_user', function (Alter $table) {
			$table->addColumn('is_renamed', 'int', 10)->setDefault(0);
		});

	}

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_user', function (Alter $table) {
			$table->dropColumns(['is_renamed']);
		});
	}
}
