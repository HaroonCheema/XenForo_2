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
		});
	}

	// ############################### POST INSTALL ###########################

	public function postInstall(array &$stateChanges)
	{
		$app = \XF::app();

		$jobID = "thread_starter_points" . time();

		$app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ThreadStarter', [], false);

		$jobID = "thread_reply_points" . time();

		$app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ReplyPoints', [], false);

		$jobID = "thread_solution_points" . time();

		$app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:SolutionPoints', [], false);
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName) {
			$sm->dropTable($tableName);
		}

		$this->schemaManager()->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['points_collected']);
		});
	}

	protected function getTables()
	{
		$data = new MySql();
		return $data->getTables();
	}
}
