<?php

namespace FS\CancelMultipleSubscriptions;

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
		$this->alterTable('xf_purchase_request', function (\XF\Db\Schema\Alter $table) {
			$table->addColumn('is_canceled', 'int')->setDefault(0);
		});
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_purchase_request', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['is_canceled']);
		});
	}
}
