<?php

namespace AddonFlare\ForumStats;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

    // install
    public function installStep1()
    {
        $this->schemaManager()->createTable('xf_af_forumstats_stat_definition', function(Create $table)
        {
            $table->addColumn('definition_id', 'varbinary', 25);
            $table->addColumn('definition_class', 'varchar', 300);

            $table->addPrimaryKey('definition_id');
        });

        $this->schemaManager()->createTable('xf_af_forumstats_stat', function(Create $table)
        {
            $table->addColumn('stat_id', 'int')->autoIncrement();
            $table->addColumn('definition_id', 'varbinary', 25);
            $table->addColumn('position', 'varchar', 30);
            $table->addColumn('display_order', 'int');
            $table->addColumn('options', 'blob');
            $table->addColumn('active', 'tinyint', 3);
        });

        // default data

        $data = [];

        $data['xf_af_forumstats_stat_definition'] = "
            INSERT INTO `xf_af_forumstats_stat_definition` (`definition_id`, `definition_class`)
            VALUES
                ('hottest_threads','AddonFlare\\\\ForumStats:HottestThreads'),
                ('latest_forum_news','AddonFlare\\\\ForumStats:LatestForumNews'),
                ('most_liked_threads','AddonFlare\\\\ForumStats:MostLikedThreads'),
                ('most_liked_users','AddonFlare\\\\ForumStats:MostLikedUsers'),
                ('most_popular_forums','AddonFlare\\\\ForumStats:MostPopularForums'),
                ('most_viewed_threads','AddonFlare\\\\ForumStats:MostViewedThreads'),
                ('new_members','AddonFlare\\\\ForumStats:NewMembers'),
                ('new_posts','AddonFlare\\\\ForumStats:NewPosts'),
                ('new_threads','AddonFlare\\\\ForumStats:NewThreads'),
                ('top_thread_starters','AddonFlare\\\\ForumStats:TopThreadStarters')
        ";

        $data['xf_af_forumstats_stat'] = "
            INSERT INTO `xf_af_forumstats_stat` (`definition_id`, `position`, `display_order`, `options`, `active`)
            VALUES
                ('new_posts','main',5,'[]',1),
                ('new_threads','main',10,'[]',1),
                ('new_members','left',5,'[]',1),
                ('hottest_threads','main',15,'[]',1),
                ('latest_forum_news','main',25,'[]',1),
                ('most_liked_threads','left',20,'[]',1),
                ('most_liked_users','left',10,'[]',1),
                ('most_popular_forums','left',25,'[]',1),
                ('most_viewed_threads','main',20,'[]',1),
                ('top_thread_starters','left',15,'[]',1)
        ";

        $db = $this->db();

        foreach ($data AS $dataQuery)
        {
            $db->query($dataQuery);
        }
    }

    public function installStep2()
    {
        $data = [];

        $data['xf_af_forumstats_stat_definition'] = "
            INSERT INTO `xf_af_forumstats_stat_definition` (`definition_id`, `definition_class`)
            VALUES
                ('new_resources', 'AddonFlare\\\\ForumStats:NewResources'),
                ('top_resources', 'AddonFlare\\\\ForumStats:TopResources')
        ";

        $db = $this->db();

        foreach ($data AS $dataQuery)
        {
            $db->query($dataQuery);
        }
    }

    public function installStep3()
    {
        $this->schemaManager()->alterTable('xf_af_forumstats_stat', function(Alter $alter)
        {
            $alter->addColumn('custom_title', 'varchar', 50)->nullable();
        });
    }

    public function installStep4()
    {
        $data = [];

        // insert new XF 2.1 defintions
        $data['xf_af_forumstats_stat_definition'] = "
            INSERT INTO `xf_af_forumstats_stat_definition` (`definition_id`, `definition_class`)
            VALUES
                ('most_reacted_users', 'AddonFlare\\\\ForumStats:MostReactedUsers'),
                ('most_reacted_threads', 'AddonFlare\\\\ForumStats:MostReactedThreads')
        ";

        $db = $this->db();

        foreach ($data AS $dataQuery)
        {
            $db->query($dataQuery);
        }

        // delete unsupported definitions
        $db->delete('xf_af_forumstats_stat_definition',
            "definition_id IN ('most_liked_users', 'most_liked_threads')"
        );

        // rename definitions to new ones for 2.1+
        $db->update('xf_af_forumstats_stat',
            ['definition_id' => 'most_reacted_users'],
            'definition_id = ?', 'most_liked_users'
        );
        $db->update('xf_af_forumstats_stat',
            ['definition_id' => 'most_reacted_threads'],
            'definition_id = ?', 'most_liked_threads'
        );
    }

    public function postInstall(array &$stateChanges)
    {
        // rebuild stats cache
        \XF::repository('AddonFlare\ForumStats:ForumStat')->rebuildForumStatDefinitionCache();
    }

    // upgrade
    public function upgrade1010070Step1()
    {
        $this->installStep2();
    }

    public function upgrade1030070Step1()
    {
        $this->installStep3();
    }

    public function upgrade1050070Step1()
    {
        $this->installStep4();
    }

    // uninstall
    public function uninstallStep1()
    {
        $this->schemaManager()->dropTable('xf_af_forumstats_stat_definition');
        $this->schemaManager()->dropTable('xf_af_forumstats_stat');
    }
}
