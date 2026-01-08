<?php

namespace FS\IframeVideoChanges;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################ INSTALLATION ######################

	public function installStep1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_iframe', function (Alter $table) {

			// $table->addColumn('for_days', 'int')->setDefault(1);
			$table->changeColumn('display_day', 'varbinary', 255);
		});
	}

	// ############################### UPGRADE ###########################

	public function upgrade1000500Step1(array $stepParams)
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_iframe', function (Alter $table) {
			$table->changeColumn('display_day', 'varbinary', 255);
		});

		$sm->alterTable('xf_iframe', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['for_days']);
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_iframe', function (Alter $table) {
			$table->changeColumn('display_day', 'int')->setDefault(7);
		});

		// $this->schemaManager()->alterTable('xf_iframe', function (\XF\Db\Schema\Alter $table) {
		// 	$table->dropColumns(['for_days']);
		// });
	}
}
