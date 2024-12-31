<?php

namespace OzzModz\Badges;


use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

/**
 * Class Setup
 *
 * @package OzzModz\Badges
 */
class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################## INSTALL ###########################################

	public function installStep1()
	{
		$sm = $this->schemaManager();

		foreach ($this->getTables() as $tableName => $callback)
		{
			$sm->createTable($tableName, $callback);
		}
	}

	public function installStep2()
	{
		$sm = $this->schemaManager();
		foreach ($this->getAlters() as $table => $schema)
		{
			if ($sm->tableExists($table))
			{
				$sm->alterTable($table, $schema);
			}
		}
	}

	public function postInstall(array &$stateChanges)
	{
		if ($this->applyDefaultPermissions())
		{
			$this->app->jobManager()->enqueueUnique(
				'permissionRebuild',
				'XF:PermissionRebuild',
				[],
				false
			);
		}
	}

	// ################################## UNINSTALL ###########################################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName)
		{
			$sm->dropTable($tableName);
		}
	}

	public function uninstallStep2()
	{
		$sm = $this->schemaManager();
		foreach ($this->getReverseAlters() as $table => $schema)
		{
			if ($sm->tableExists($table))
			{
				$sm->alterTable($table, $schema);
			}
		}
	}

	public function uninstallStep3()
	{
		$phrases = $this->app->finder('XF:Phrase')->where(['title', 'LIKE', '%' . Addon::PREFIX . '%'])->fetch();

		foreach ($phrases as $phrase)
		{
			$phrase->delete(false);
		}
	}

	public function uninstallStep4()
	{
		$this->uninstallContentTypeData(['ozzmodz_badges_badge']);
	}

	public function uninstallStep5()
	{
		$fs = $this->app->fs();
		$fs->deleteDir('data://assets/ozzmodz_badges_badge');
		$fs->deleteDir('data://assets/ozzmodz_badges_badge_category');
	}

	public function uninstallStep6()
	{
		$jobManager = $this->app->jobManager();
		$jobManager->cancelUniqueJob('userBadgeUpdateQueue');
		$jobManager->cancelUniqueJob('userBadgeUpdate');
	}

	// ################################## DATA ###########################################

	protected function getTables(): array
	{
		$tables = [];

		$tables[Addon::table('badge')] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('badge_id', 'int')->autoIncrement();
			$table->addColumn('user_criteria', 'mediumblob');
			$table->addColumn('badge_category_id', 'int')->setDefault(0);
			$table->addColumn('badge_tier_id', 'int')->setDefault(0);
			$table->addColumn('icon_type', 'enum')->values(['fa', 'mdi', 'image', 'asset', 'html']);
			$table->addColumn('fa_icon', 'varchar', 256)->setDefault('');
			$table->addColumn('mdi_icon', 'varchar', 256)->setDefault('');
			$table->addColumn('html_icon', 'text')->nullable(true)->setDefault(null);
			$table->addColumn('image_url', 'varchar', 512)->setDefault('');
			$table->addColumn('image_url_2x', 'varchar', 512)->setDefault('');
			$table->addColumn('image_url_3x', 'varchar', 512)->setDefault('');
			$table->addColumn('image_url_4x', 'varchar', 512)->setDefault('');
			$table->addColumn('class', 'varchar', 256)->setDefault('');
			$table->addColumn('badge_link', 'varchar', 255)->setDefault('');
			$table->addColumn('badge_link_attributes', 'blob', 255)->nullable();
			$table->addColumn('awarded_number', 'int')->setDefault(0);
			$table->addColumn('is_repetitive', 'tinyint')->setDefault(0);
			$table->addColumn('repeat_delay', 'int')->setDefault(0);
			$table->addColumn('is_revoked', 'tinyint')->setDefault(0);
			$table->addColumn('is_manually_awarded', 'tinyint')->setDefault(1);
			$table->addColumn('stacking_badge_id', 'int')->setDefault(0);
			$table->addColumn('display_order', 'int')->setDefault(10);
			$table->addColumn('active', 'tinyint')->setDefault(1);

			$table->addKey('badge_category_id');
			$table->addKey('is_repetitive');
			$table->addKey('display_order');
		};

		$tables[Addon::table('badge_category')] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('badge_category_id', 'int')->autoIncrement();
			$table->addColumn('icon_type', 'enum')->values(['', 'fa', 'mdi', 'image', 'asset'])->setDefault('');
			$table->addColumn('fa_icon', 'varchar', 256)->setDefault('');
			$table->addColumn('mdi_icon', 'varchar', 256)->setDefault('');
			$table->addColumn('image_url', 'varchar', 512)->setDefault('');
			$table->addColumn('image_url_2x', 'varchar', 512)->setDefault('');
			$table->addColumn('image_url_3x', 'varchar', 512)->setDefault('');
			$table->addColumn('image_url_4x', 'varchar', 512)->setDefault('');
			$table->addColumn('class', 'varchar', 256)->setDefault('');
			$table->addColumn('display_order', 'int')->setDefault(10);

			$table->addKey('display_order');
		};

		$tables[Addon::table('badge_tier')] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('badge_tier_id', 'int')->autoIncrement();
			$table->addColumn('color', 'varchar', 255);
			$table->addColumn('css', 'text');
			$table->addColumn('display_order', 'int')->setDefault(0);

			$table->addKey('display_order');
		};

		$tables[Addon::table('user_badge')] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('user_badge_id', 'int')->autoIncrement();
			$table->addColumn('user_id', 'int');
			$table->addColumn('awarding_user_id', 'int')->setDefault(0);
			$table->addColumn('is_manually_awarded', 'tinyint')->setDefault(0);

			$table->addColumn('badge_id', 'int');
			$table->addColumn('award_date', 'int');
			$table->addColumn('reason', 'text');
			$table->addColumn('featured', 'tinyint', 3)->setDefault(0);

			$table->addKey('badge_id');
			$table->addKey('user_id');
			$table->addKey('awarding_user_id');
			$table->addKey('is_manually_awarded');
			$table->addKey(['user_id', 'badge_id']);
		};

		$tables[Addon::table('user_badge_update')] = function (Create $table) {
			$table->engine('MEMORY');

			$table->addColumn('user_id', 'int');
			$table->addColumn('queue_date', 'int');

			$table->addPrimaryKey('user_id');
			$table->addKey('queue_date');
		};

		return $tables;
	}

	protected function getAlters()
	{
		$alters = [];

		$alters['xf_user'] = function (Alter $table) {
			$table->addColumn('ozzmodz_badges_badge_count', 'int')->setDefault(0);
			$table->addColumn('ozzmodz_badges_tier_counts', 'blob')->nullable();
			$table->addColumn('ozzmodz_badges_cache', 'blob')->nullable();
			$table->addColumn('ozzmodz_badges_received_badge_ids', 'blob')->nullable();
			$table->addColumn('ozzmodz_badges_last_award_date', 'int')->setDefault(0);
		};

		$alters['xf_user_option'] = function (Alter $table) {
			$table->addColumn('ozzmodz_badges_email_on_award', 'tinyint', 3)->setDefault(1);
		};

		return $alters;
	}

	/**
	 * @return array
	 */
	protected function getReverseAlters()
	{
		$alters = [];

		$alters['xf_user'] = function (Alter $table) {
			$table->dropColumns([
				'ozzmodz_badges_badge_count',
				'ozzmodz_badges_tier_counts',
				'ozzmodz_badges_cache',
				'ozzmodz_badges_received_badge_ids',
				'ozzmodz_badges_last_award_date'
			]);
		};

		$alters['xf_user_option'] = function (Alter $table) {
			$table->dropColumns([
				'ozzmodz_badges_email_on_award'
			]);
		};

		return $alters;
	}

	private function applyDefaultPermissions()
	{
		$registeredPermissions = [
			'manageFeatured'
		];

		$moderatorPermissions = [
			'award',
			'takeAway'
		];

		foreach ($registeredPermissions as $permission)
		{
			$this->applyGlobalPermission(Addon::PREFIX, $permission, 'forum', 'editOwnPost');
		}

		foreach ($moderatorPermissions as $permission)
		{
			$this->applyGlobalPermission(Addon::PREFIX, $permission, 'general', 'editBasicProfile');
		}

		$this->applyGlobalPermissionInt(Addon::PREFIX, 'featuredNumber', 4, 'forum', 'editOwnPost');

		return true;
	}

	// ################################## UPGRADE ###########################################

	public function upgrade2000074Step1()
	{
		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = $this->app->repository(Addon::shortName('Badge'));
		$badgeRepo->rebuildBadgesCache();
	}

	public function upgrade2010000Step1()
	{
		$sm = $this->schemaManager();

		$userBadgeTable = Addon::table('user_badge');

		$sm->alterTable($userBadgeTable, function (Alter $table) {
			$table->dropIndexes('PRIMARY');
			$table->addColumn('user_badge_id', 'int')->autoIncrement();

			$table->addKey('badge_id');
			$table->addKey('user_id');
		});

		$this->db()->query("
			ALTER TABLE `{$userBadgeTable}` CHANGE
			`user_badge_id` `user_badge_id` INT(10) UNSIGNED NOT NULL auto_increment FIRST
		");
	}

	public function upgrade2010000Step2()
	{
		$this->app->jobManager()->enqueueUnique(
			Addon::prefix('user_badge'),
			Addon::shortName('UserBadgeCacheRebuild'),
			[],
			false
		);
	}

	public function upgrade2010000Step3()
	{
		$sm = $this->schemaManager();

		$sm->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->changeColumn('icon_type', 'enum')->values(['fa', 'image', 'asset']);
			$table->addColumn('awarded_number', 'int')->setDefault(0)->after('class');
			$table->addColumn('is_repetitive', 'tinyint')->setDefault(0)->after('class');
			$table->addKey('is_repetitive');
		});

		$sm->alterTable(Addon::table('badge_category'), function (Alter $table) {
			$table->changeColumn('icon_type', 'enum')->values(['', 'fa', 'image', 'asset'])->setDefault('');
		});
	}

	public function upgrade2010000Step4()
	{
		$this->app->jobManager()->enqueueUnique(
			Addon::prefix('badge_awarded_number'),
			Addon::shortName('BadgeAwardedNumberRebuild'),
			[],
			false
		);
	}

	public function upgrade2010000Step5()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_user', function (Alter $table) {
			$table->addColumn(Addon::column('last_award_date'), 'int')->setDefault(0);
		});
	}

	public function upgrade2010000Step6()
	{
		$this->app->jobManager()->enqueueUnique(
			Addon::prefix('user_badge_count'),
			Addon::shortName('UserBadgeCountRebuild'),
			[],
			false
		);
	}

	// 2.2.0

	public function upgrade2020000Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->addColumn('is_revoked', 'tinyint')->setDefault(0);
		});
	}

	// 2.2.1

	public function upgrade2020191Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable(Addon::table('badge_category'), function (Alter $table) {
			$table->addColumn('mdi_icon', 'varchar', 256)->setDefault('')->after('fa_icon');
			$table->changeColumn('icon_type', 'ENUM')->addValues('mdi');
		});

		$sm->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->addColumn('mdi_icon', 'varchar', 256)->setDefault('')->after('fa_icon');
			$table->changeColumn('icon_type', 'ENUM')->addValues('mdi');
		});
	}

	// 2.2.3

	public function upgrade2020300Step1()
	{
		$sm = $this->schemaManager();
		$sm->createTable(Addon::table('badge_tier'), function (Create $table) {

			$table->addColumn('badge_tier_id', 'int')->autoIncrement();
			$table->addColumn('color', 'varchar', 255);
			$table->addColumn('css', 'text');
			$table->addColumn('display_order', 'int')->setDefault(0);

			$table->addKey('display_order');
		});

		$sm->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->addColumn('badge_tier_id', 'int')->setDefault(0)->after('badge_category_id');
		});

		$sm->alterTable('xf_user', function (Alter $table) {
			$table->addColumn(Addon::column('tier_counts'), 'blob')->nullable()->after(Addon::column('badge_count'));
		});
	}

	// 2.3.0 Beta 4

	public function upgrade2030034Step1()
	{
		$this->alterTable(Addon::table('user_badge'), function (Alter $table) {
			$table->addColumn('awarding_user_id', 'int')->setDefault(0)->after('user_id');
			$table->addKey('awarding_user_id');
		});
	}

	// 2.3.0 Beta 6

	public function upgrade2020306Step1()
	{
		$sm = $this->schemaManager();
		$sm->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->addColumn('stacking_badge_id', 'int')->setDefault(0)->after('is_revoked');
		});
	}

	// 2.3.0 Beta 8

	public function upgrade2030038Step1()
	{
		$sm = $this->schemaManager();
		$sm->alterTable(Addon::table('badge_tier'), function (Alter $table) {
			$table->addColumn('color', 'varchar', 255)->after('badge_tier_id');
		});
	}

	// 2.3.0 RC 1

	public function upgrade2030051Step1()
	{
		$this->alterTable(Addon::table('user_badge'), function (Alter $table) {
			$table->addColumn('is_manually_awarded', 'tinyint')->setDefault(0)->after('awarding_user_id');
			$table->addKey('is_manually_awarded');
			$table->addKey(['user_id', 'badge_id']);
		});

		$this->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->addColumn('is_manually_awarded', 'tinyint')->setDefault(1)->after('is_revoked');
			$table->addColumn('repeat_delay', 'int')->setDefault(0)->after('is_repetitive');
			$table->addColumn('active', 'tinyint')->setDefault(1);
		});
	}

	// 2.3.1

	public function upgrade2030202Step1()
	{
		$this->alterTable('xf_user', function (Alter $table) {
			$table->addColumn('ozzmodz_badges_received_badge_ids', 'blob')->nullable()->after('ozzmodz_badges_cache');
		});
	}

	public function upgrade2030202Step2()
	{
		$this->app->jobManager()->enqueueUnique(
			Addon::prefix('user_badge_ids'),
			Addon::shortName('UserBadgeIdsRebuild'),
			[],
			false
		);
	}

	// 2.3.4

	public function upgrade2030471Step1()
	{
		$this->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->changeColumn('icon_type')->addValues(['html']);
			$table->addColumn('html_icon', 'text')->nullable(true)->setDefault(null)->after('mdi_icon');
		});
	}

	// 2.3.5

	public function upgrade2030591Step1()
	{
		$this->alterTable(Addon::table('badge'), function (Alter $table) {
			$table->addColumn('badge_link', 'varchar', 255)->setDefault('')->after('class');
			$table->addColumn('badge_link_attributes', 'blob', 255)->nullable()->after('badge_link');
		});
	}

	// 2.3.6

	public function upgrade2030600Step1()
	{
		$this->createTable(Addon::table('user_badge_update'), function (Create $table) {
			$table->engine('MEMORY');

			$table->addColumn('user_id', 'int');
			$table->addColumn('queue_date', 'int');

			$table->addPrimaryKey('user_id');
			$table->addKey('queue_date');
		});
	}

	public function postUpgrade($previousVersion, array &$stateChanges)
	{
		// 2.2.3
		if ($previousVersion < 2020300)
		{
			/** @var \XF\Repository\Option $optionRepo */
			$optionRepo = $this->app->repository('XF:Option');
			$oldSortOption = $this->app->options()->ozzmodz_badges_featuredBadgesSort;

			if ($oldSortOption == 'asc' || $oldSortOption == 'desc')
			{
				$optionRepo->updateOption(
					'ozzmodz_badges_featuredDefaultDirection',
					$oldSortOption
				);
			}
		}
	}

	// ################################## HELPERS ###########################################

	public function checkRequirements(&$errors = [], &$warnings = [])
	{
		if (\XF::isAddOnActive('CMTV/Badges'))
		{
			$warnings[] = 'You must disable the "CMTV/Badges" before installing this add-on';
		}
	}
}