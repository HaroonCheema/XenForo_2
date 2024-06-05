<?php

namespace FS\GenerateLink;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

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
		$this->alterTable('xf_navigation', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('forum_ids', 'varbinary', 255)->setDefault('');
			$table->addColumn('route', 'varchar', 100)->setDefault('');
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_navigation', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['forum_ids']);
			$table->dropColumns(['route']);
		});
	}
}
