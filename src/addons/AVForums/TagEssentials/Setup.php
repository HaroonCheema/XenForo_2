<?php

namespace AVForums\TagEssentials;

use SV\StandardLib\InstallerHelper;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

/**
 * Class Setup
 *
 * @package AVForums\TagEssentials
 */
class Setup extends AbstractSetup
{
    use InstallerHelper;
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function installStep1()
    {
        $this->migrateTables();

        $sm = $this->schemaManager();

        foreach ($this->getTables() as $tableName => $callback)
        {
            $sm->createTable($tableName, $callback);
            $sm->alterTable($tableName, $callback);
        }
    }

    public function installStep2()
    {
        $sm = $this->schemaManager();

        foreach ($this->getAlterTables() as $tableName => $callback)
        {
            $sm->alterTable($tableName, $callback);
        }
    }

    public function migrateTables()
    {
        $this->migrateTable('tagess_synonym', 'xf_tagess_synonym');
        $this->migrateTable('tagess_blacklist', 'xf_tagess_blacklist');
        $this->migrateTable('tagess_category', 'xf_tagess_category');
        $this->migrateTable('tagess_tag_watch', 'xf_tagess_tag_watch');
    }


    public function upgrade2000004Step1()
    {
        $this->migrateTables();
    }

    public function upgrade2000004Step2()
    {
        $this->installStep1();
    }

    public function upgrade2000004Step3()
    {
        $this->installStep2();
    }

    public function upgrade2000014Step1()
    {
        $sm = $this->schemaManager();
        if ($sm->tableExists('xf_tagess_blacklist__conflict'))
        {
            /** @noinspection SqlResolve */
            $this->db()->query('
                insert ignore into xf_tagess_blacklist (blacklist_id,tag,regex,user_id,blacklisted_date)
                select blacklist_id,tag,regex,user_id,blacklisted_date
                from xf_tagess_blacklist__conflict
            ');
            //$sm->dropTable('xf_tagess_blacklist__conflict');
        }
    }

    public function upgrade2000700Step1()
    {
        $db = $this->db();
        $db->query('delete from xf_tagess_tag_watch where not exists (select tag_id from xf_tag where xf_tag.tag_id = xf_tagess_tag_watch.tag_id)');
        $db->query('delete from xf_tagess_synonym where not exists (select tag_id from xf_tag where xf_tag.tag_id = xf_tagess_synonym.tag_id)');
        $db->query('delete from xf_tagess_synonym where not exists (select tag_id from xf_tag where xf_tag.tag_id = xf_tagess_synonym.parent_tag_id)');
    }


    public function uninstallStep1()
    {
        $sm = $this->schemaManager();

        foreach ($this->getTables() as $tableName => $callback)
        {
            $sm->dropTable($tableName);
        }
    }

    public function uninstallStep2()
    {
        $sm = $this->schemaManager();

        foreach ($this->getRemoveAlterTables() as $tableName => $callback)
        {
            $sm->alterTable($tableName, $callback);
        }
    }

    /**
     * @return array
     */
    protected function getTables()
    {
        $tables = [];

        $tables['xf_tagess_synonym'] = function ($table) {
            /** @var Create|Alter $table */
            $this->addOrChangeColumn($table, 'tag_id', 'int')->primaryKey();
            $this->addOrChangeColumn($table, 'parent_tag_id', 'int');
            $table->addKey('parent_tag_id');
        };

        $tables['xf_tagess_blacklist'] = function ($table) {
            /** @var Create|Alter $table */
            $this->addOrChangeColumn($table, 'blacklist_id', 'int')->autoIncrement()->primaryKey();
            $this->addOrChangeColumn($table, 'tag', 'varchar', 255);
            $this->addOrChangeColumn($table, 'regex', 'tinyint', 1)->setDefault(0);
            $this->addOrChangeColumn($table, 'user_id', 'int');
            // must be nullable for XF1 upgrades
            $this->addOrChangeColumn($table, 'blacklisted_date', 'int')->nullable(true)->setDefault(null);

            // https://xenforo.com/community/threads/index-conflict-resolution-with-partial-indexes-is-broken.154873/ assume fixed in 2.0.11 or later
            if (\XF::$versionId > 2001170 ||
                $table instanceof Create || !$table->getIndexDefinition('tag'))
            {
                $table->addKey(['regex', ['tag', 191]], 'tag');
            }
        };

        $tables['xf_tagess_category'] = function ($table) {
            /** @var Create|Alter $table */
            $this->addOrChangeColumn($table, 'category_id', 'varchar', 25)->primaryKey();
            $this->addOrChangeColumn($table, 'title', 'varchar', 50);
        };

        $tables['xf_tagess_tag_watch'] = function ($table) {
            /** @var Create|Alter $table */
            $this->addOrChangeColumn($table, 'user_id', 'int');
            $this->addOrChangeColumn($table, 'tag_id', 'int');
            $this->addOrChangeColumn($table, 'send_alert', 'tinyint', 1)->setDefault(1);
            $this->addOrChangeColumn($table, 'send_email', 'tinyint', 1)->setDefault(0);
            $table->addPrimaryKey(['user_id','tag_id']);
        };

        return $tables;
    }

    /**
     * @return array
     */
    protected function getAlterTables()
    {
        $tables = [];

        $tables['xf_tag'] = function (Alter $table) {
            $this->addOrChangeColumn($table, 'tagess_wiki_last_edit_date', 'int')->setDefault(0);
            $this->addOrChangeColumn($table, 'tagess_wiki_last_edit_user_id', 'int')->setDefault(0);
            $this->addOrChangeColumn($table, 'tagess_wiki_last_edit_count', 'int')->setDefault(0);
            $this->addOrChangeColumn($table, 'tagess_wiki_tagline', 'varchar', 200)->nullable(true)->setDefault(null);
            $this->addOrChangeColumn($table, 'tagess_wiki_description', 'text')->nullable(true)->setDefault(null);

            $this->addOrChangeColumn($table, 'allowed_node_ids', 'mediumblob')->nullable(true)->setDefault(null);
            $this->addOrChangeColumn($table, 'tagess_category_id', 'varchar', 25)->setDefault('');

            $table->addKey(['tagess_category_id'], 'tagess_category_id');
        };

        $tables['xf_feed'] = function (Alter $table) {
            $this->addOrChangeColumn($table, 'tagess_tags', 'BLOB')->nullable(true)->setDefault(null);
        };

        $tables['xf_forum'] = function (Alter $table) {
            $this->addOrChangeColumn($table, 'tagess_tags', 'BLOB')->nullable(true)->setDefault(null);
        };

        $tables['xf_thread_prefix'] = function (Alter $table) {
            $this->addOrChangeColumn($table, 'tagess_tags', 'BLOB')->nullable(true)->setDefault(null);
        };

        //$tables['xengallery_album'] = function (Alter $table) {
        //    $table->dropColumns(['tagess_tags']);
        //};

        return $tables;
    }

    /**
     * @return array
     */
    protected function getRemoveAlterTables()
    {
        $tables = [];

        $tables['xf_tag'] = function (Alter $table) {
            $table->dropColumns(['tagess_wiki_last_edit_date', 'tagess_wiki_last_edit_user_id', 'tagess_wiki_last_edit_count', 'tagess_wiki_tagline', 'tagess_wiki_description', 'tagess_category_id', 'allowed_node_ids', 'tagess_category_id']);
            $table->dropIndexes(['tagess_category_id']);
        };

        $tables['xf_feed'] = function (Alter $table) {
            $table->dropColumns(['tagess_tags']);
        };

        $tables['xf_forum'] = function (Alter $table) {
            $table->dropColumns(['tagess_tags']);
        };

        $tables['xf_thread_prefix'] = function (Alter $table) {
            $table->dropColumns(['tagess_tags']);
        };

        //$tables['xengallery_album'] = function (Alter $table) {
        //    $table->dropColumns(['tagess_tags']);
        //};

        return $tables;
    }
}