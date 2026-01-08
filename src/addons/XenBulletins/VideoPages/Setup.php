<?php

namespace XenBulletins\VideoPages;

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

    public function installStep1()
    {
        $this->schemaManager()->createTable('xf_videopages', function (Create $table) {
            $table->addColumn('video_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('video_link', 'text');
            $table->addColumn('video_feature', 'varchar', 255)->setDefault('');
            $table->addColumn('thumbnail', 'varchar', 255);
            $table->addColumn('video_logo', 'varchar', 555);
            $table->addColumn('video_intro', 'text');
            $table->addColumn('video_desc', 'text');
            $table->addColumn('video_sideimg', 'varchar', 555);
            $table->addColumn('video_img', 'varchar', 555);
            $table->addColumn('intro_ph_id', 'int');
            $table->addColumn('desc_ph_id', 'int');
            $table->addColumn('feature_embed', 'varchar', 255);
        });

        $this->schemaManager()->createTable('xf_iframe', function (Create $table) {
            $table->addColumn('iframe_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('iframe_title', 'varchar', 255);
            $table->addColumn('iframe_URL', 'text');
            $table->addColumn('thumbNail', 'varchar', 255);
            $table->addColumn('video_id', 'varchar', 255);
            $table->addColumn('video', 'varchar', 255)->nullable();
            $table->addColumn('provider', 'varchar', 255)->nullable();
            $table->addColumn('rons', 'varchar', 255);
            $table->addColumn('date', 'int');
            $table->addColumn('feature', 'int');
            $table->addColumn('rons_featured', 'int')->setDefault(0);
            $table->addColumn('for_days', 'int')->setDefault(1);
            $table->addColumn(
                'feature_embed',
                'varchar',
                255
            );
            $table->addColumn('display_day', 'int')->setDefault(7);
        });
    }

    public function upgrade1020000Step1()
    {

        $sm = $this->schemaManager();

        $sm->alterTable('xf_iframe', function (Alter $table) {

            $table->addColumn('rons_featured', 'int')->setDefault(0);
        });
    }

    public function upgrade1060000Step1()
    {

        $sm = $this->schemaManager();

        $sm->alterTable('xf_iframe', function (Alter $table) {

            $table->addColumn('display_day', 'int')->setDefault(7);
        });
    }

    public function upgrade1080100Step1()
    {

        $sm = $this->schemaManager();
    }

    public function uninstallStep1(array $stepParams = [])
    {
        $this->db()->query("delete from xf_phrase_compiled where title like '%intro' OR title LIKE '%des'");
        $this->db()->query("delete from xf_phrase where title like '%intro' OR title LIKE '%des'");

        $this->schemaManager()->dropTable('xf_videopages');
        $this->schemaManager()->dropTable('xf_iframe');
    }
}
