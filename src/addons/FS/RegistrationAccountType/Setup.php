<?php

namespace FS\RegistrationAccountType;

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
		$this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('reg_account_type', 'enum')->values(['doner', 'donee'])->setDefault('doner');
		});
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['reg_account_type']);
		});
	}
}
