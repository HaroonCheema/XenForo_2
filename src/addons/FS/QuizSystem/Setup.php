<?php

namespace FS\QuizSystem;

use DateTime;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

use FS\QuizSystem\Install\Data\MySql;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installstep1()
	{
		$sm = $this->schemaManager();

		foreach ($this->getTables() as $tableName => $callback) {
			$sm->createTable($tableName, $callback);
		}

		$this->insertDefaultData();
	}

	public function installStep2()
	{
		$this->schemaManager()->createTable('fs_quiz', function (Create $table) {
			$table->addColumn('quiz_id', 'int')->autoIncrement();
			$table->addColumn('quiz_name', 'varchar', 100);
			$table->addColumn('quiz_des', 'varchar', 1000);
			$table->addColumn('quiz_state', 'varchar', 100);
			$table->addColumn('quiz_end_date', 'int', 20);
			$table->addColumn('quiz_start_date', 'int', 20);
			$table->addColumn('category_id', 'int', 20)->setDefault(0);
			$table->addColumn('time_per_question', 'int', 100)->setDefault(0);
			$table->addColumn('user_group', 'blob')->nullable(true);
			$table->addColumn('created_at', 'int')->setDefault(0);
			$table->addColumn('updated_at', 'int')->setDefault(0);
			$table->addColumn('quiz_questions', 'blob')->nullable(true);
			$table->addColumn('question_ids', 'blob')->nullable(true);
			$table->addKey('category_id', 'category_id');
			$table->addPrimaryKey('quiz_id');
		});
	}

	public function upgrade1020200Step1(array $stepParams)
	{
		$this->alterTable('fs_quiz', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('question_ids', 'blob')->nullable(true);
		});

		$this->schemaManager()->createTable('fs_quiz_question_answers', function (Create $table) {

			$table->addColumn('id', 'int')->autoIncrement();

			$table->addColumn('question_id', 'int')->setDefault(0);
			$table->addColumn('quiz_id', 'int')->setDefault(0);
			$table->addColumn('user_id', 'int')->setDefault(0);
			$table->addColumn('at_index', 'int')->setDefault(0);
			$table->addColumn('created_at', 'int')->setDefault(0);
			$table->addColumn('correct', 'bool')->setDefault(1);
			$table->addColumn('answer', 'varchar', 1000)->setDefault('');

			$table->addPrimaryKey('id');
		});
	}

	public function installStep3()
	{
		$this->schemaManager()->createTable('fs_quiz_question', function (Create $table) {
			$table->addColumn('question_id', 'int')->autoIncrement();
			$table->addColumn('question_type', 'varchar', 100);
			$table->addColumn('question_title', 'varchar', 100);
			$table->addColumn('question_correct_answer', 'varchar', 1000)->setDefault('');
			$table->addColumn('created_at', 'int')->setDefault(0);
			$table->addColumn('updated_at', 'int')->setDefault(0);
			$table->addColumn('options', 'blob')->nullable(true);
			$table->addColumn('correct', 'blob')->nullable(true);
			$table->addPrimaryKey('question_id');
		});
	}

	public function installStep4()
	{
		$this->schemaManager()->createTable('fs_quiz_question_answers', function (Create $table) {

			$table->addColumn('id', 'int')->autoIncrement();

			$table->addColumn('question_id', 'int')->setDefault(0);
			$table->addColumn('quiz_id', 'int')->setDefault(0);
			$table->addColumn('user_id', 'int')->setDefault(0);
			$table->addColumn('at_index', 'int')->setDefault(0);
			$table->addColumn('created_at', 'int')->setDefault(0);
			$table->addColumn('correct', 'bool')->setDefault(1);
			$table->addColumn('answer', 'varchar', 1000)->setDefault('');

			$table->addPrimaryKey('id');
		});
	}

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName) {
			$sm->dropTable($tableName);
		}
	}

	public function insertDefaultData()
	{
		if (!$this->addOn->isInstalled()) {
			$db = $this->app->db();
			$data = $this->getData();
			foreach ($data as $dataQuery) {
				$db->query($dataQuery);
			}

			return count($data);
		}
	}

	protected function getTables()
	{
		$data = new MySql();
		return $data->getTables();
	}

	protected function getData()
	{
		$data = new MySql();
		return $data->getData();
	}
}
