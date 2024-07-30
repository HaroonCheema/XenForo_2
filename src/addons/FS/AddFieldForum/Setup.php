<?php

namespace FS\AddFieldForum;

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
		$this->alterTable('xf_forum', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('count_reactions', 'tinyint', 3)->setDefault(1);
		});
	}

	// ############################### UNINSTALL ###########################

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_forum', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['count_reactions']);
		});
	}
}
