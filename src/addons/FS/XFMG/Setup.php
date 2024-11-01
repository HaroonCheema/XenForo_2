<?php

namespace FS\XFMG;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installstep1()
	{
		$this->alterTable('xf_mg_album', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('media_id', 'int')->setDefault(0);
		});
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_mg_album', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['media_id']);
		});
	}
 
}