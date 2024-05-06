<?php

namespace FS\DisableBbCodes;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use FS\DisableBbCodes\Install\Data\MySql;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

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

		$this->alterTable('xf_bb_code', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('usergroup_ids', 'varbinary', 255);
		});

		$this->insertBuiltInBbCodes();
	}

	// ############################### UPGRADE ###########################

	public function upgrade1000100Step1(array $stepParams)
	{
		$sm = $this->schemaManager();

		foreach ($this->getTables() as $tableName => $callback) {
			$sm->createTable($tableName, $callback);
		}

		$this->insertBuiltInBbCodes();
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName) {
			$sm->dropTable($tableName);
		}

		$this->schemaManager()->alterTable('xf_bb_code', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['usergroup_ids']);
		});
	}

	protected function getTables()
	{
		$data = new MySql();
		return $data->getTables();
	}

	protected function insertBuiltInBbCodes()
	{
		$builtInBbCodes = "B,I,U,S,COLOR,FONT,SIZE,URL,EMAIL,USER,IMG,MEDIA,LIST,LEFT,CENTER,RIGHT,QUOTE,SPOILER,ISPOILER,CODE,ICODE,INDENT,TABLE,HEADING,PLAIN,ATTACH,GALLERY";

		$builtInBbCodesArray = explode(",", $builtInBbCodes);

		foreach ($builtInBbCodesArray as $bb_code) {
			$insert = \XF::em()->create('FS\DisableBbCodes:DisableBbCodes');

			$insert->bb_code_id = $bb_code;
			$insert->save();
		}
	}
}
