<?php

namespace FS\UserCarDetails;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use FS\UserCarDetails\Install\Data\MySql;

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

		$this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('model_id', 'int')->setDefault(0);
			$table->addColumn('car_colour', 'mediumtext')->nullable()->setDefault(null);
			$table->addColumn('car_trim', 'mediumtext')->nullable()->setDefault(null);
			$table->addColumn('car_location', 'mediumtext')->nullable()->setDefault(null);
			$table->addColumn('car_plaque_number', 'mediumtext')->nullable()->setDefault(null);
			$table->addColumn('car_reg_number', 'mediumtext')->nullable()->setDefault(null);
			$table->addColumn('car_reg_date', 'int')->setDefault(0);
			$table->addColumn('car_forum_name', 'mediumtext')->nullable()->setDefault(null);
			$table->addColumn('car_unique_information', 'mediumtext')->nullable()->setDefault(null);
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName) {
			$sm->dropTable($tableName);
		}

		$this->schemaManager()->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['model_id', 'car_colour', 'car_trim', 'car_location', 'car_plaque_number', 'car_reg_number', 'car_reg_date', 'car_forum_name', 'car_unique_information']);
		});
	}

	protected function getTables()
	{
		$data = new MySql();
		return $data->getTables();
	}
}
