<?php

namespace FS\AvatarGallery;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{

    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    // ################################ INSTALLATION ######################

    public function installStep1()
    {
        $sm = $this->schemaManager();

        $sm->createTable('fs_avatar_gallery', function (Create $table) {
            $table->addColumn('img_id', 'int')->autoIncrement();
            $table->addColumn('img_path', 'varchar', 255);
            $table->addPrimaryKey('img_id');
        });

        $this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {

            $table->addColumn('random_avatar_limit', 'int')->setDefault(0);
        });
    }

    // ############################### UPGRADE ###########################

    public function upgrade1000700Step1(array $stepParams)
    {
        $this->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {

            $table->addColumn('random_avatar_limit', 'int')->setDefault(0);
        });
    }

    // ############################### UNINSTALL ###########################

    public function uninstallStep1(array $stepParams = [])
    {
        $sm = $this->schemaManager();
        $sm->dropTable('fs_avatar_gallery');

        $this->schemaManager()->alterTable('xf_user', function (\XF\Db\Schema\Alter $table) {
            $table->dropColumns(['random_avatar_limit']);
        });
    }
}
