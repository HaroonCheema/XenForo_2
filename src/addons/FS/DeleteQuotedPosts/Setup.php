<?php

namespace FS\DeleteQuotedPosts;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
	{
		$this->schemaManager()->alterTable('xf_post', function(Alter $table)
		{
			$table->addColumn('is_deleted_quoted_post', 'tinyint')->setDefault(0);
		});
	}
	
	public function postInstall(array &$stateChanges){
		\XF::app()->jobManager()
		->enqueue(
			'FS\DeleteQuotedPosts:DeleteQuotedPosts', 
			[]
		);
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_post', function(Alter $table)
		{
			$table->dropColumns('is_deleted_quoted_post');
		});
	}


}