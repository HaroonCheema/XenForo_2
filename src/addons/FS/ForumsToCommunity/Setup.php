<?php

namespace FS\ForumsToCommunity;

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
		$finder = \XF::finder('XF:Navigation')->where('navigation_id', 'forums')->fetchOne();

		$finder->MasterTitle->bulkSet([
			'phrase_text' => "Community",
		]);
		$finder->MasterTitle->save();
	}

	public function uninstallStep1()
	{
		$finder = \XF::finder('XF:Navigation')->where('navigation_id', 'forums')->fetchOne();

		$finder->MasterTitle->bulkSet([
			'phrase_text' => "Forums",
		]);
		$finder->MasterTitle->save();
	}
}
