<?php

namespace XenBulletin\AvatarGallery;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Create;
use XF\Db\SchemaManager;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;
        
        
    public function installStep1()
    {
        $sm = $this->schemaManager();

        $sm->createTable('xb_avatar_gallery', function (Create $table)
        {
            $table->addColumn('img_id', 'int')->autoIncrement();
            $table->addColumn('img_path', 'varchar', 255);
            $table->addPrimaryKey('img_id');
        });
    }

    public function uninstallStep1(array $stepParams = [])
    {
        $sm = $this->schemaManager();
        $sm->dropTable('xb_avatar_gallery');
    }
}