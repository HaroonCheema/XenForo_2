<?php

namespace NF\GiftUpgrades;

use NF\GiftUpgrades\Job\RebuildContentGiftCount;
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
 * @package NF\GiftUpgrades
 */
class Setup extends AbstractSetup
{
    // from https://github.com/Xon/XenForo2-StandardLib
    use InstallerHelper;
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

    public function installStep1(): void
    {
        $sm = $this->schemaManager();

        foreach ($this->getTables() as $tableName => $callback)
        {
            $sm->createTable($tableName, $callback);
            $sm->alterTable($tableName, $callback);
        }

        foreach ($this->getAlterTables() as $tableName => $callback)
        {
            if ($sm->tableExists($tableName))
            {
                $sm->alterTable($tableName, $callback);
            }
        }
    }

    public function installStep2(): void
    {
        foreach ($this->getDefaultWidgetSetup() AS $widget)
        {
            [$widgetKey, $widgetFn] = $widget;
            $widgetFn($widgetKey);
        }
    }

    public function installStep3(): void
    {
	    $this->applyGlobalPermissionForGroup('general', 'nf_gift', \XF\Entity\User::GROUP_REG);
	    $this->applyGlobalPermissionForGroup('forum', 'nf_gift', \XF\Entity\User::GROUP_REG);
	    $this->applyGlobalPermissionForGroup('profilePost', 'nf_gift', \XF\Entity\User::GROUP_REG);
    }

    public function upgrade2010070Step3(): void
    {
        $map = [
            'nixfifty_giftupgrades_*' => 'nf_giftupgrades_*',
        ];
        $this->renamePhrases($map);
    }

    public function upgrade2030070Step1(): void
    {
        $this->installStep1();
    }

    public function upgrade2040370Step1(): void
    {
        $this->installStep2();
    }

    public function upgrade2040370Step2(): void
    {
        $db = $this->db();

        $gifts = $db->fetchAllColumn('
            SELECT gift.gift_id
            FROM xf_purchase_request AS purchaseRequest
            LEFT JOIN xf_user_upgrade_active AS upgradeActive ON (upgradeActive.purchase_request_key = purchaseRequest.request_key)
            LEFT JOIN xf_user_upgrade_expired AS upgradeExpired ON (upgradeExpired.purchase_request_key = purchaseRequest.request_key)
            JOIN xf_nf_gifted_content AS gift ON (
                gift.user_upgrade_record_id = upgradeActive.user_upgrade_record_id OR 
                gift.user_upgrade_record_id = upgradeExpired.user_upgrade_record_id 
                )
            WHERE purchaseRequest.extra_data LIKE \'%"is_anonymous":true%\' AND gift.is_anonymous = 0
        ');

        if ($gifts)
        {
            $db->update('xf_nf_gifted_content', [
                'is_anonymous' => 1,
            ], 'gift_id in (' . $db->quote($gifts) . ')');
        }
    }

    public function postUpgrade($previousVersion, array &$stateChanges)
    {
        if ($previousVersion <= 2010070)
        {
            $this->app->jobManager()->enqueueUnique(
                'RebuildContentGiftCount.post',
                RebuildContentGiftCount::class, [
                    'content_type' => 'post',
                    'upgrade'      => true,
                ]
            );

            $this->app->jobManager()->enqueueUnique(
                'RebuildContentGiftCount.profile_post',
                RebuildContentGiftCount::class, [
                    'content_type' => 'profile_post',
                    'upgrade'      => true,
                ]
            );

            $this->app->jobManager()->enqueueUnique(
                'RebuildContentGiftCount.profile_post_comment',
                RebuildContentGiftCount::class, [
                    'content_type' => 'profile_post_comment',
                    'upgrade'      => true,
                ]
            );
        }
    }

    public function uninstallStep1(): void
    {
        $sm = $this->schemaManager();

        foreach ($this->getTables() as $tableName => $callback)
        {
            $sm->dropTable($tableName);
        }
    }

    public function uninstallStep2(): void
    {
        $sm = $this->schemaManager();

        foreach ($this->getRemoveAlterTables() as $tableName => $callback)
        {
            $sm->alterTable($tableName, $callback);
        }
    }

    public function uninstallStep3(): void
    {
        foreach ($this->getDefaultWidgetSetup() AS $widget)
        {
            /** @noinspection PhpUnusedLocalVariableInspection */
            [$widgetKey, $widgetFn] = $widget;
            $this->deleteWidget($widgetKey);
        }
    }

    protected function getDefaultWidgetSetup(): array
    {
        return [
            ['nfGiftUpgrades_recent_gifted_posts', function($key, array $options = [])
            {
                $xfOptions = \XF::options();

                /** @noinspection MissingIssetImplementationInspection */
                $options = array_replace([
                    'limit' => $xfOptions->nf_forumListNewGiftPosts ?? 5,
                    'dateLimit' => $xfOptions->readMarkingDataLifetime ?? 90,
                    'snippetLength' => $xfOptions->nf_giftSnippetLength ?? 50,
                    'skipLockedThreads' => $xfOptions->nf_giftWidgetSkipLockedThreads ?? false,
                    'skipWarnedPosts' => true,
                    'skipPrefixes' => $xfOptions->nf_giftWidgetSkipPrefix ?? [],
                    'cacheTime' => $xfOptions->nf_giftListCacheTime ?? 300,
                ], $options);

                $this->createWidget(
                    $key,
                    'nfRecentGiftUpgrades',
                    [
                        'positions' => ['forum_list_sidebar' => 35],
                        'options' => $options
                    ]
                );
            }],
        ];
    }

    protected function getTables(): array
    {
        $tables = [];

        $tables['xf_nf_gifted_content'] = function ($table) {
            /** @var Create|Alter $table */
            $this->addOrChangeColumn($table, 'gift_id', 'int')->autoIncrement();
            $this->addOrChangeColumn($table, 'user_upgrade_record_id', 'int');
            $this->addOrChangeColumn($table, 'content_type', 'varbinary', 25);
            $this->addOrChangeColumn($table, 'content_id', 'int');
            $this->addOrChangeColumn($table, 'gift_user_id', 'int');
            $this->addOrChangeColumn($table, 'is_anonymous', 'tinyint')->setDefault(0);
            $this->addOrChangeColumn($table, 'gift_date', 'int');
            $this->addOrChangeColumn($table, 'content_user_id', 'int');
            $this->addOrChangeColumn($table, 'gifted_for_free', 'tinyint', 3)->setDefault(0);

            $table->addKey(['content_type', 'content_id'], 'content_type_content_id');
            $table->addKey(['gift_date'], 'gift_date');
            $table->addKey('gift_user_id');
            $table->addKey('content_user_id');
            // do *not* add a unique key constraint touching either gift_user_id/content_user_id
            // as we need to track if after a user merge a user has gifted themselves without data-loss
        };

        $tables['xf_nixfifty_gift_upgrade_statistics'] = function ($table) {
            /** @var Create|Alter $table */
            $this->addOrChangeColumn($table, 'stat_id', 'int')->autoIncrement();
            $this->addOrChangeColumn($table, 'gift_upgrade_id', 'int');
            $this->addOrChangeColumn($table, 'stat_date', 'int');
        };

        return $tables;
    }

    protected function getAlterTables(): array
    {
        $tables = [];

        $tables['xf_user_upgrade'] = function (Alter $table)
        {
            $this->addOrChangeColumn($table, 'can_gift', 'tinyint', 3)->setDefault(1);
        };

        $tables['xf_user_upgrade_active'] = function (Alter $table)
        {
            $this->addOrChangeColumn($table, 'is_gift', 'tinyint', 3)->setDefault(0);
            $this->addOrChangeColumn($table, 'pay_user_id', 'int')->setDefault(0);
            $this->addOrChangeColumn($table, 'nf_was_gifted_for_free', 'tinyint', 3)->setDefault(0);
            $table->addKey('purchase_request_key');
        };

        $tables['xf_user_upgrade_expired'] = function (Alter $table)
        {
            $this->addOrChangeColumn($table, 'is_gift', 'tinyint', 3)->setDefault(0);
            $this->addOrChangeColumn($table, 'pay_user_id', 'int')->setDefault(0);
            $this->addOrChangeColumn($table, 'nf_was_gifted_for_free', 'tinyint', 3)->setDefault(0);
            $table->addKey('purchase_request_key');
        };

        return $tables;
    }

    protected function getRemoveAlterTables(): array
    {
        $tables = [];

        $tables['xf_user_upgrade'] = function (Alter $table) {
            $table->dropColumns(['can_gift']);
        };

        $tables['xf_user_upgrade_active'] = function (Alter $table) {
            $table->dropColumns(['is_gift', 'pay_user_id']);
        };

        $tables['xf_user_upgrade_expired'] = function (Alter $table) {
            $table->dropColumns(['is_gift', 'pay_user_id']);
        };

        return $tables;
    }
}