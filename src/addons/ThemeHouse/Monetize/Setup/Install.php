<?php

namespace ThemeHouse\Monetize\Setup;

use ThemeHouse\Monetize\XF\Repository\UserUpgrade;
use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;
use XF\Db\SchemaManager;

/**
 * Trait Install
 * @package ThemeHouse\Monetize\Setup
 * @package ThemeHouse\Monetize\Setup
 *
 * @property \XF\App app
 *
 * @method SchemaManager schemaManager
 */
trait Install
{
    public function installStep1()
    {
        $this->schemaManager()->createTable('xf_th_monetize_affiliate_link', function (Create $table) {
            $table->addColumn('affiliate_link_id', 'int')->nullable()->autoIncrement();
            $table->addColumn('title', 'varchar', 150);
            $table->addColumn('reference_link_prefix', 'text');
            $table->addColumn('reference_link_suffix', 'text');
            $table->addColumn('reference_link_parser', 'blob');
            $table->addColumn('active', 'tinyint')->setDefault(1);
            $table->addColumn('url_cloaking', 'tinyint')->setDefault(0);
            $table->addColumn('url_encoding', 'tinyint')->setDefault(0);
            $table->addColumn('link_criteria', 'blob');
            $table->addColumn('user_criteria', 'blob');
        });
    }

    public function installStep2()
    {
        $this->schemaManager()->createTable('xf_th_monetize_communication', function (Create $table) {
            $table->addColumn('communication_id', 'int')->nullable()->autoIncrement();
            $table->addColumn('send_rules', 'blob');
            $table->addColumn('title', 'varchar', 150);
            $table->addColumn('body', 'text');
            $table->addColumn('active', 'tinyint')->setDefault(1);
            $table->addColumn('user_upgrade_criteria', 'blob');
            $table->addColumn('user_criteria', 'blob');
            $table->addColumn('next_send', 'int')->setDefault(0);
            $table->addColumn('limit_days', 'int')->setDefault(0);
            $table->addColumn('limit', 'int')->setDefault(0);
            $table->addColumn('user_id', 'int')->nullable();
            $table->addColumn('type_options', 'blob');
            $table->addColumn('type', 'enum')->values(['email', 'alert', 'message']);
        });
    }

    public function installStep3()
    {
        $this->schemaManager()->createTable('xf_th_monetize_communication_log', function (Create $table) {
            $table->addColumn('communication_log_id', 'int')->nullable()->autoIncrement();
            $table->addColumn('communication_id', 'int');
            $table->addColumn('log_date', 'int')->setDefault(0);
            $table->addColumn('user_id', 'int');

            $table->addKey(['user_id', 'log_date']);
            $table->addKey(['user_id', 'communication_id']);
        });
    }

    public function installStep4()
    {
        $this->schemaManager()->createTable('xf_th_monetize_keyword', function (Create $table) {
            $table->addColumn('keyword_id', 'int')->nullable()->autoIncrement();
            $table->addColumn('title', 'varchar', 150);
            $table->addColumn('keyword', 'varchar', 150);
            $table->addColumn('keyword_options', 'blob');
            $table->addColumn('replace_type', 'enum')->values(['url', 'html']);
            $table->addColumn('replacement', 'text');
            $table->addColumn('limit', 'int')->setDefault(0);
            $table->addColumn('active', 'tinyint')->setDefault(1);
            $table->addColumn('user_criteria', 'blob');
        });
    }

    public function installStep5()
    {
        $this->schemaManager()->createTable('xf_th_monetize_sponsor', function (Create $table) {
            $table->addColumn('th_sponsor_id', 'int')->nullable()->autoIncrement();
            $table->addColumn('title', 'varchar', 150);
            $table->addColumn('active', 'tinyint')->setDefault(1);
            $table->addColumn('featured', 'tinyint')->setDefault(0);
            $table->addColumn('url', 'text');
            $table->addColumn('image', 'text');
            $table->addColumn('width', 'int')->setDefault(0);
            $table->addColumn('height', 'int')->setDefault(0);
            $table->addColumn('directory', 'tinyint')->setDefault(1);
            $table->addColumn('notes', 'text')->nullable();
        });
    }

    public function installStep6()
    {
        $this->schemaManager()->createTable('xf_th_monetize_upgrade_page', function (Create $table) {
            $table->addColumn('upgrade_page_id', 'int')->nullable()->autoIncrement();
            $table->addColumn('active', 'tinyint')->setDefault(1);
            $table->addColumn('display_order', 'int')->setDefault(1);
            $table->addColumn('user_criteria', 'blob');
            $table->addColumn('page_criteria', 'blob');
            $table->addColumn('page_criteria_overlay_only', 'tinyint')->setDefault(1);
            $table->addColumn('show_all', 'tinyint')->setDefault(1);
            $table->addColumn('overlay', 'tinyint')->setDefault(0);
            $table->addColumn('overlay_dismissible', 'tinyint')->setDefault(0);
            $table->addColumn('accounts_page', 'tinyint')->setDefault(1);
            $table->addColumn('error_message', 'tinyint')->setDefault(1);
            $table->addColumn('upgrade_page_links', 'blob');
            $table->addColumn('accounts_page_link', 'tinyint')->setDefault(1);
        });
    }

    public function installStep7()
    {
        $this->schemaManager()->createTable('xf_th_monetize_upgrade_page_relation',
            function (Create $table) {
                $table->addColumn('upgrade_page_id', 'int');
                $table->addColumn('user_upgrade_id', 'int');
                $table->addColumn('display_order', 'int')->setDefault(1);
                $table->addColumn('featured', 'tinyint')->setDefault(0);
                $table->addPrimaryKey(['upgrade_page_id', 'user_upgrade_id']);
            });
    }

    /**
     *
     */
    public function installStep8()
    {
        $this->schemaManager()->alterTable('xf_node', function (Alter $table) {
            $table->addColumn('th_sponsor_id', 'int')->setDefault(0);
        });
    }

    /**
     *
     */
    public function installStep9()
    {
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->changeColumn('user_state')->addValues(['thmonetize_upgrade']);
        });
    }

    /**
     *
     */
    public function installStep10()
    {
        $this->schemaManager()->alterTable('xf_user_upgrade', function (Alter $table) {
            $table->addColumn('thmonetize_features', 'mediumblob')->nullable();
            $table->addColumn('thmonetize_style_properties', 'mediumblob')->nullable();
            $table->addColumn('thmonetize_custom_amount', 'boolean')->setDefault(0);
            $table->addColumn('thmonetize_allow_multiple', 'boolean')->setDefault(0);
            $table->addColumn('thmonetize_redirect_url', 'text')->nullable();
            $table->addColumn('user_criteria', 'mediumblob')->nullable();
        });
    }

    /**
     *
     */
    public function installStep11()
    {
        $this->schemaManager()->alterTable('xf_user_profile', function (Alter $table) {
            $table->addColumn('thmonetize_active_upgrades', 'mediumblob')->nullable();
            $table->addColumn('thmonetize_expired_upgrades', 'mediumblob')->nullable();
        });
    }

    public function installStep12()
    {
        $this->schemaManager()->alterTable('xf_user_upgrade_active', function (Alter $table) {
            $table->addColumn('thmonetize_updated', 'int')->setDefault(0);
        });
    }

    public function installStep13()
    {
        $this->schemaManager()->alterTable('xf_user_upgrade_expired', function (Alter $table) {
            $table->addColumn('thmonetize_updated', 'int')->setDefault(0);
        });
    }

    public function installStep14()
    {
        $this->schemaManager()->createTable('xf_th_monetize_coupon', function (Create $table) {
            $table->addColumn('coupon_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 150);
            $table->addColumn('code', 'varchar', 150);
            $table->addColumn('type', 'enum')->values(['amount', 'percent']);
            $table->addColumn('value', 'int');
            $table->addColumn('active', 'tinyint')->setDefault(1);
            $table->addColumn('user_criteria', 'mediumblob')->nullable();
        });
    }

    /**
     * @param null $previousVersion
     * @return bool
     */
    protected function applyDefaultPermissions($previousVersion = null)
    {
        $applied = false;

        if (!$previousVersion || $previousVersion < 1000037) {
            $this->applyGlobalPermission('forum', 'thMonetize_viewPost', 'forum', 'viewContent');
            $this->applyContentPermission('forum', 'thMonetize_viewPost', 'forum', 'viewContent');

            $applied = true;
        }

        return $applied;
    }

    /**
     * @param array $stateChanges
     * @throws \XF\PrintableException
     */
    public function postInstall(array &$stateChanges)
    {
        if ($this->applyDefaultPermissions()) {
            // since we're running this after data imports, we need to trigger a permission rebuild
            // if we changed anything
            $this->app->jobManager()->enqueueUnique(
                'permissionRebuild',
                'XF:PermissionRebuild',
                [],
                false
            );
        }

        $this->setupDefaults();

        $upgrades = \XF::db()->fetchAll('select * from xf_user_upgrade');

        foreach ($upgrades as $upgrade) {
            $this->db()->update('xf_user_upgrade', [
                'user_criteria' => json_encode([]),
            ], 'user_upgrade_id = ?', [$upgrade['user_upgrade_id']]);
        }

        /** @var UserUpgrade $userUpgradeRepo */
        $userUpgradeRepo = \XF::repository('XF:UserUpgrade');
        $userUpgradeRepo->generateCssForThMonetizeUserUpgrades();
    }
}