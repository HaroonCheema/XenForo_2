<?php

namespace FS\AttachmentsQueue;

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
		$sm = $this->schemaManager();

		$this->alterTable('xf_attachment', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('attachment_state', 'enum')->values(['approve', 'pending', 'rejected'])->setDefault('pending');
		});
	}

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		$this->schemaManager()->alterTable('xf_attachment', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['attachment_state']);
		});
	}
}
