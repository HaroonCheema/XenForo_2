<?php

namespace FS\ThreadScoringSystem;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use FS\ThreadScoringSystem\Install\Data\MySql;

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

		$this->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('points_collected', 'tinyint', 3)->setDefault(0);
			$table->addColumn('last_cron_run', 'int')->setDefault(0);
			$table->addColumn('last_thread_update', 'int')->setDefault(0);
		});
	}

	// ############################### POST INSTALL ###########################

	// public function postInstall(array &$stateChanges)
	// {

	// }

	// ############################### UPGRADE ###########################

	public function upgrade1010200Step1(array $stepParams)
	{

		$this->schemaManager()->createTable('fs_thread_total_scoring_custom', function (\XF\Db\Schema\Create $table) {
			$table->addColumn('id', 'int')->autoIncrement();
			$table->addColumn('user_id', 'int');
			$table->addColumn('threads_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
			$table->addColumn('reply_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
			$table->addColumn('worlds_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
			$table->addColumn('reactions_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
			$table->addColumn('solutions_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
			$table->addColumn('total_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);

			$table->addPrimaryKey('id');
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName) {
			$sm->dropTable($tableName);
		}

		$this->schemaManager()->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['points_collected', 'last_cron_run', 'last_thread_update']);
		});
	}

	protected function getTables()
	{
		$data = new MySql();
		return $data->getTables();
	}
}
