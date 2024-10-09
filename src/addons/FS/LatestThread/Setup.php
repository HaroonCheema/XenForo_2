<?php

namespace FS\LatestThread;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################ INSTALLATION ######################

	public function installstep1()
	{
		$sm = $this->schemaManager();

		$this->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('is_featured', 'tinyint', 3)->setDefault(0);
		});
	}

	// ############################### UPGRADE ###########################

	public function upgrade1000100Step1(array $stepParams)
	{
		$this->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('is_featured', 'tinyint', 3)->setDefault(0);
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		$this->schemaManager()->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['is_featured']);
		});
	}
}
