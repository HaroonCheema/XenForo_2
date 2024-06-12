<?php

namespace FS\ChangeAttachmentsFilename;

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
	}

	public function uninstallStep1()
	{
	}

	public function postInstall(array &$stateChanges)
	{
		$app = \XF::app();

		$jobID = 'change_attachments_filename_' . time();

		$app->jobManager()->enqueueUnique($jobID, 'FS\ChangeAttachmentsFilename:ChangeAttachmentName', [], false);
		// $app->jobManager()->runUnique($jobID, 120);
	}
}
