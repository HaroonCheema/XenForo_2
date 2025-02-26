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

		$this->schemaManager()->createTable('fs_random_username_and_passwords', function (Create $table) {
			$table->addColumn('random_id', 'int')->autoIncrement();
			$table->addColumn('customer_id', 'varchar', 255)->setDefault('');
			$table->addColumn('first_name', 'varchar', 255)->setDefault('');
			$table->addColumn('last_name', 'varchar', 255)->setDefault('');
			$table->addColumn('company', 'varchar', 255)->setDefault('');
			$table->addColumn('city', 'varchar', 255)->setDefault('');
			$table->addColumn('country', 'varchar', 255)->setDefault('');
			$table->addColumn('phone_one', 'varchar', 255)->setDefault('');
			$table->addColumn('phone_two', 'varchar', 255)->setDefault('');
			$table->addColumn('email', 'varchar', 255)->setDefault('');
			$table->addColumn('subscription_date', 'varchar', 255)->setDefault('');
			$table->addColumn('website', 'varchar', 255)->setDefault('');
			$table->addPrimaryKey('random_id');
		});
	}
}
