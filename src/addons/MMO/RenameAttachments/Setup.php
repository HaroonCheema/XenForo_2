<?php

namespace MMO\RenameAttachments;

use MMO\RenameAttachments\Install\InstallerHelper;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    use InstallerHelper;

    public function upgrade2010270Step1()
    {
        $this->renameOption('mra_download_file_prefix', 'mraDownloadFileName');
    }
}