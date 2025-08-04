<?php

namespace FS\SendMailFromTable;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use FS\SendMailFromTable\Install\Data\MySql;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################ INSTALLATION ######################

	public function installstep1()
	{
		$sm = $this->schemaManager();

		foreach ($this->getTables() as $tableName => $callback) {
			$sm->createTable($tableName, $callback);
		}
	}

	// ############################### UPGRADE ###########################

	public function upgrade1000200Step1(array $stepParams)
	{
		$this->schemaManager()->alterTable('fs_cron_emails_log', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['from']);
		});

		$this->alterTable('fs_cron_emails_log', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('email_ids', 'mediumblob');
		});

		$this->alterTable('fs_mid_night_emails', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('phone_no', 'varchar', 20)->setDefault('');
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName) {
			$sm->dropTable($tableName);
		}
	}

	protected function getTables()
	{
		$data = new MySql();
		return $data->getTables();
	}
}
