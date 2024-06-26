<?php

namespace FS\SearchOwnThread;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use FS\SearchOwnThread\Install\Data\MySql;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################ INSTALLATION ######################

	public function installstep1()
	{
		$sm = $this->schemaManager();

		// $this->alterTable('fs_user_upgrade_rating', function (\XF\Db\Schema\Alter $table) {
		// 	// $table->addColumn('author_response', 'mediumtext');
		// 	$table->addColumn('author_id', 'int');
		// });

		foreach ($this->getTables() as $tableName => $callback) {
			$sm->createTable($tableName, $callback);
		}
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