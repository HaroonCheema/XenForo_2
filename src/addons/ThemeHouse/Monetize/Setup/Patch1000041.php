<?php

namespace ThemeHouse\Monetize\Setup;

use ThemeHouse\Monetize\Repository\Keyword;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Db\SchemaManager;

/**
 * Trait Patch1000041
 * @package ThemeHouse\Monetize\Setup
 *
 * @method SchemaManager schemaManager
 */
trait Patch1000041
{

    /**
     *
     */
    public function upgrade1000011Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->createTable('xf_th_monetize_keyword', function (Create $table) {
            $table->addColumn('keyword_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar(250)');
            $table->addColumn('keyword', 'varchar(250)');
            $table->addColumn('replace_type', 'enum')
                ->values(['url', 'html']);
            $table->addColumn('replacement', 'blob');
            $table->addColumn('limit', 'int');
            $table->addColumn('active', 'boolean')->setDefault(1);
            $table->addColumn('user_criteria', 'mediumblob');
        });
    }

    /**
     *
     */
    public function upgrade1000012Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->createTable('xf_th_monetize_sponsor', function (Create $table) {
            $table->addColumn('th_sponsor_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar(250)');
            $table->addColumn('active', 'boolean')->setDefault(1);
            $table->addColumn('url', 'varchar(250)')->setDefault('');
            $table->addColumn('image', 'varchar(250)')->setDefault('');
            $table->addColumn('width', 'int')->setDefault(0);
            $table->addColumn('height', 'int')->setDefault(0);
        });
    }

    /**
     *
     */
    public function upgrade1000012Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->renameTable('xf_thmonetize_affiliate_link', 'xf_th_monetize_affiliate_link');
    }

    /**
     *
     */
    public function upgrade1000012Step3()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_node', function (Alter $table) {
            $table->addColumn('th_sponsor_id', 'int')->setDefault(0);
        });
    }

    /**
     *
     */
    public function upgrade1000013Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user', function (Alter $table) {
            $table->changeColumn('user_state')->addValues(['thmonetize_upgrade']);
        });
    }

    /**
     *
     */
    public function upgrade1000032Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->createTable('xf_th_monetize_upgrade_page', function (Create $table) {
            $table->addColumn('upgrade_page_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar(250)');
            $table->addColumn('active', 'boolean')->setDefault(1);
        });
    }

    /**
     *
     */
    public function upgrade1000033Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->createTable('xf_th_monetize_upgrade_page_relation', function (Create $table) {
            $table->addColumn('upgrade_page_id', 'int');
            $table->addColumn('user_upgrade_id', 'int');
            $table->addColumn('display_order', 'int');
            $table->addColumn('featured', 'boolean')->setDefault(0);
            $table->addUniqueKey(['upgrade_page_id', 'user_upgrade_id']);
        });
    }

    // ############################# FINAL UPGRADE ACTIONS #############################

    /**
     *
     */
    public function upgrade1000033Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_upgrade_page', function (Alter $table) {
            $table->addColumn('display_order', 'int');
            $table->addColumn('user_criteria', 'mediumblob');
        });
    }

    // ############################# UNINSTALL #############################

    /**
     *
     */
    public function upgrade1000033Step3()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_upgrade', function (Alter $table) {
            $table->addColumn('thmonetize_features', 'mediumblob')->nullable();
        });
    }

    /**
     *
     */
    public function upgrade1000035Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_upgrade_page', function (Alter $table) {
            $table->addColumn('show_all', 'boolean')->setDefault(1);
            $table->addColumn('page_criteria', 'mediumblob');
            $table->dropColumns(['title']);
        });
    }

    /**
     *
     */
    public function upgrade1000035Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_sponsor', function (Alter $table) {
            $table->addColumn('directory', 'boolean')->setDefault(1);
        });
    }

    /**
     *
     */
    public function upgrade1000036Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_upgrade_page', function (Alter $table) {
            $table->addColumn('overlay', 'boolean')->setDefault(0);
            $table->addColumn('overlay_dismissible', 'boolean')->setDefault(0);
        });
    }

    /**
     *
     */
    public function upgrade1000036Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_upgrade', function (Alter $table) {
            $table->addColumn('thmonetize_style_properties', 'mediumblob')->nullable();
        });
    }

    /**
     *
     */
    public function upgrade1000037Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_upgrade_page', function (Alter $table) {
            $table->addColumn('page_criteria_overlay_only', 'boolean')->setDefault(1);
            $table->addColumn('accounts_page', 'boolean')->setDefault(0);
            $table->addColumn('error_message', 'boolean')->setDefault(0);
            $table->addColumn('upgrade_page_links', 'blob');
            $table->addColumn('accounts_page_link', 'boolean')->setDefault(1);
        });
    }

    // ############################# TABLE / DATA DEFINITIONS #############################

    /**
     *
     */
    public function upgrade1000038Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->createTable('xf_th_monetize_alert', function (Create $table) {
            $table->addColumn('alert_id', 'int')->autoIncrement();
            $table->addColumn('send_rules', 'blob');
            $table->addColumn('title', 'varchar(250)');
            $table->addColumn('user_id', 'int');
            $table->addColumn('link_url', 'varchar(250)');
            $table->addColumn('link_title', 'varchar(250)');
            $table->addColumn('body', 'mediumblob');
            $table->addColumn('active', 'boolean')->setDefault(1);
            $table->addColumn('user_criteria', 'mediumblob');
            $table->addColumn('next_send', 'int');
        });

        $schemaManager->createTable('xf_th_monetize_email', function (Create $table) {
            $table->addColumn('email_id', 'int')->autoIncrement();
            $table->addColumn('send_rules', 'blob');
            $table->addColumn('from_name', 'varchar(250)');
            $table->addColumn('from_email', 'varchar(250)');
            $table->addColumn('title', 'varchar(250)');
            $table->addColumn('format', 'enum')->values(['', 'html']);
            $table->addColumn('body', 'mediumblob');
            $table->addColumn('active', 'boolean')->setDefault(1);
            $table->addColumn('wrapped', 'boolean')->setDefault(1);
            $table->addColumn('unsub', 'boolean')->setDefault(1);
            $table->addColumn('receive_admin_email_only', 'boolean')->setDefault(1);
            $table->addColumn('user_criteria', 'mediumblob');
            $table->addColumn('next_send', 'int');
        });

        $schemaManager->createTable('xf_th_monetize_message', function (Create $table) {
            $table->addColumn('message_id', 'int')->autoIncrement();
            $table->addColumn('send_rules', 'blob');
            $table->addColumn('title', 'varchar(250)');
            $table->addColumn('user_id', 'int');
            $table->addColumn('body', 'mediumblob');
            $table->addColumn('active', 'boolean')->setDefault(1);
            $table->addColumn('open_invite', 'boolean')->setDefault(1);
            $table->addColumn('conversation_locked', 'boolean')->setDefault(1);
            $table->addColumn('delete_type', 'enum')->values(['', 'deleted', 'deleted_ignored']);
            $table->addColumn('user_criteria', 'mediumblob');
            $table->addColumn('next_send', 'int');
        });
    }

    /**
     *
     */
    public function upgrade1000038Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_profile', function (Alter $table) {
            $table->addColumn('thmonetize_active_upgrades', 'mediumblob')->nullable();
        });
    }

    /**
     *
     */
    public function upgrade1000040Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->createTable('xf_th_monetize_alert_log', function (Create $table) {
            $table->addColumn('alert_log_id', 'int')->autoIncrement();
            $table->addColumn('log_date', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('alert_id', 'int');
            $table->addKey('log_date');
            $table->addKey('user_id');
            $table->addKey(['user_id', 'log_date']);
            $table->addKey(['user_id', 'alert_id']);
        });

        $schemaManager->createTable('xf_th_monetize_email_log', function (Create $table) {
            $table->addColumn('email_log_id', 'int')->autoIncrement();
            $table->addColumn('log_date', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('email_id', 'int');
            $table->addKey('log_date');
            $table->addKey('user_id');
            $table->addKey(['user_id', 'log_date']);
            $table->addKey(['user_id', 'email_id']);
        });

        $schemaManager->createTable('xf_th_monetize_message_log', function (Create $table) {
            $table->addColumn('message_log_id', 'int')->autoIncrement();
            $table->addColumn('log_date', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('message_id', 'int');
            $table->addKey('log_date');
            $table->addKey('user_id');
            $table->addKey(['user_id', 'log_date']);
            $table->addKey(['user_id', 'message_id']);
        });
    }

    /**
     *
     */
    public function upgrade1000040Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_alert', function (Alter $table) {
            $table->addColumn('limit_alerts', 'int')->setDefault(0);
            $table->addColumn('limit_days', 'int')->setDefault(0);
        });

        $schemaManager->alterTable('xf_th_monetize_email', function (Alter $table) {
            $table->addColumn('limit_emails', 'int')->setDefault(0);
            $table->addColumn('limit_days', 'int')->setDefault(0);
        });

        $schemaManager->alterTable('xf_th_monetize_message', function (Alter $table) {
            $table->addColumn('limit_messages', 'int')->setDefault(0);
            $table->addColumn('limit_days', 'int')->setDefault(0);
        });
    }

    /**
     *
     */
    public function upgrade1000041Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_alert', function (Alter $table) {
            $table->addColumn('user_upgrade_criteria', 'mediumblob');
        });

        $schemaManager->alterTable('xf_th_monetize_email', function (Alter $table) {
            $table->addColumn('user_upgrade_criteria', 'mediumblob');
        });

        $schemaManager->alterTable('xf_th_monetize_message', function (Alter $table) {
            $table->addColumn('user_upgrade_criteria', 'mediumblob');
        });
    }

    /**
     *
     */
    public function upgrade1000041Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_profile', function (Alter $table) {
            $table->addColumn('thmonetize_expired_upgrades', 'mediumblob')->nullable();
        });
    }

    /**
     *
     */
    public function upgrade1000131Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_upgrade', function (Alter $table) {
            $table->addColumn('thmonetize_custom_amount', 'boolean')->setDefault(0);
        });
    }

    /**
     */
    public function upgrade1000231Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_upgrade', function (Alter $table) {
            $table->addColumn('thmonetize_allow_multiple', 'boolean')->setDefault(0);
        });
    }

    public function upgrade1000237Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_upgrade_active', function (Alter $table) {
            $table->addColumn('thmonetize_updated', 'int')->setDefault(0);
        });
    }

    public function upgrade1000237Step2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_user_upgrade_expired', function (Alter $table) {
            $table->addColumn('thmonetize_updated', 'int')->setDefault(0);
        });
    }

    public function upgrade1000240Step1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_th_monetize_keyword', function (Alter $table) {
            $table->addColumn('keyword_options', 'blob');
        });

        /** @var Keyword $keywordRepo */
        $keywordRepo = \XF::repository('ThemeHouse\Monetize:Keyword');
        $keywordRepo->rebuildKeywordCache();
    }

}