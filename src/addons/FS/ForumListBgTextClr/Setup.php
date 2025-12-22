<?php

namespace FS\ForumListBgTextClr;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ############################### INSTALL ###########################

	public function installstep1()
	{
		$this->alterTable('xf_node', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('txt_clr', 'varbinary', 50)->setDefault('');
			$table->addColumn('bg_clr', 'varbinary', 50)->setDefault('');
			$table->addColumn('only_title', 'tinyint', 3)->setDefault(1);
		});
	}

	// ############################### UPGRADE ###########################

	public function upgrade1000100Step1(array $stepParams)
	{
		$this->alterTable('xf_node', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('only_title', 'tinyint', 3)->setDefault(1);
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_node', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['txt_clr', 'bg_clr', 'only_title']);
		});
	}
}
