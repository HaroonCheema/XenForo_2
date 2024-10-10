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

		$this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('tile_layout', 'enum')->values(['grid', 'girdLg', 'list'])->setDefault('grid');
			$table->addColumn('new_tab', 'enum')->values(['yes', 'no'])->setDefault('yes');
			$table->addColumn('filter_sidebar', 'enum')->values(['normal', 'sticky'])->setDefault('normal');
			$table->addColumn('version_style', 'enum')->values(['small', 'large'])->setDefault('small');
		});

		$this->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('is_featured', 'tinyint', 3)->setDefault(0);
		});
	}

	// ############################### UPGRADE ###########################

	public function upgrade1000100Step1(array $stepParams)
	{
		$this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('tile_layout', 'enum')->values(['grid', 'girdLg', 'list'])->setDefault('grid');
			$table->addColumn('new_tab', 'enum')->values(['yes', 'no'])->setDefault('yes');
			$table->addColumn('filter_sidebar', 'enum')->values(['normal', 'sticky'])->setDefault('normal');
			$table->addColumn('version_style', 'enum')->values(['small', 'large'])->setDefault('small');
		});

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

		$this->schemaManager()->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['tile_layout', 'new_tab', 'filter_sidebar', 'version_style']);
		});
	}
}
