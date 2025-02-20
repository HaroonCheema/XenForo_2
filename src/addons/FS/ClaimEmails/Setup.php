<?php

namespace FS\ClaimEmails;

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
		$this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('is_claimed', 'int')->setDefault(0);
			$table->addColumn('is_new', 'int')->setDefault(0);
		});
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['is_claimed', 'is_new']);
		});
	}
}
