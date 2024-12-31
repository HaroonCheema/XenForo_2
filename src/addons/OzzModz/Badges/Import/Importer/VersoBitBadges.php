<?php


namespace OzzModz\Badges\Import\Importer;


use OzzModz\Badges\Addon;
use XF\Import\StepState;
use XF\Timer;

class VersoBitBadges extends \XF\Import\Importer\AbstractAddOnImporter
{
	public static function getListInfo()
	{
		$listInfo = [];

		$listInfo['target'] = '[OzzModz] Badges';
		$listInfo['source'] = '[VersoBit] Badges';
		$listInfo['beta'] = true;

		return $listInfo;
	}

	/**
	 * @inheritDoc
	 */
	protected function isForumType($importType)
	{
		return false;
	}

	protected function getBaseConfigDefault()
	{
		return [];
	}

	public function renderBaseConfigOptions(array $vars)
	{
		return null;
	}

	public function validateBaseConfig(array &$baseConfig, array &$errors)
	{
		return true;
	}

	protected function getStepConfigDefault()
	{
		return [
			'categories' => [],
			'badges' => [],
			'users' => [],
		];
	}

	public function renderStepConfigOptions(array $vars)
	{
		return null;
	}

	public function validateStepConfig(array $steps, array &$stepConfig, array &$errors)
	{
		return !$errors;
	}

	public function canRetainIds()
	{
		return true;
	}

	public function resetDataForRetainIds()
	{
		$db = $this->app->db();
		$tables = [
			'xf_ozzmodz_badges_badge_category',
			'xf_ozzmodz_badges_badge',
			'xf_ozzmodz_badges_user_badge'
		];

		foreach ($tables as $table)
		{
			$db->query("TRUNCATE TABLE $table");
		}

		$db->update('xf_user',
			[
				Addon::column('badge_count') => 0,
				Addon::column('cache') => NULL
			],
			Addon::column('badge_count') . ' > 0'
		);

		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = $this->app->repository(Addon::shortName('Badge'));
		$badgeRepo->purgePhrases();
		$badgeRepo->rebuildBadgesCache();

		/** @var \OzzModz\Badges\Repository\BadgeCategory $badgeCatRepo */
		$badgeCatRepo = $this->app->repository(Addon::shortName('BadgeCategory'));
		$badgeCatRepo->purgePhrases();
	}

	public function getSteps()
	{
		return [
			'categories' => [
				'title' => \XF::phrase('ozzmodz_badges_badge_category')
			],
			'badges' => [
				'title' => \XF::phrase('ozzmodz_badges_badge')
			],
			'users' => [
				'title' => \XF::phrase('ozzmodz_badges_awarded_users')
			],
		];
	}

	protected function doInitializeSource()
	{
		$this->sourceDb = $this->db();
	}

	public function getFinalizeJobs(array $stepsRun)
	{
		return [
			Addon::shortName('BadgeCacheRebuild'),
			Addon::shortName('UserBadgeCountRebuild'),
			Addon::shortName('UserBadgeCacheRebuild')
		];
	}

	// ################################## CATEGORIES ###########################################

	public function getStepEndCategories()
	{
		return $this->sourceDb->fetchOne("
			SELECT MAX(badge_category_id) 
			FROM xf_cmtv_badges_badge_category
			WHERE badge_category_id > 0
		") ?: 0;
	}

	public function stepCategories(StepState $state, array $stepConfig, $maxTime)
	{
		$timer = new Timer($maxTime);
		$onStage = 50;

		$categories = $this->sourceDb->fetchAll("
			SELECT *
			FROM xf_cmtv_badges_badge_category
			WHERE badge_category_id > ? AND badge_category_id <= ?
			LIMIT $onStage
		", [$state->startAfter, $state->end]);

		if (!$categories)
		{
			return $state->complete();
		}

		foreach ($categories as $category)
		{
			$state->startAfter = $oldId = $category['badge_category_id'];

			/** @var \OzzModz\Badges\Import\Data\VersoBitBadgeCategory $newCategory */
			$newCategory = $this->newHandler(Addon::shortName('VersoBitBadgeCategory'));

			$newCategory->bulkSet($this->mapXfKeys($category, [
				'icon_type',
				'fa_icon',
				'class',
				'image_url',
				'display_order',
			]));

			$newCategory->setTitle(\XF::phrase('CMTV_Badges_badge_category_title.' . $oldId));

			if ($newCategory->save($oldId))
			{
				$state->imported++;
			}

			if ($timer->limitExceeded()) break;
		}

		return $state->resumeIfNeeded();
	}

	// ################################## BADGES ###########################################

	public function getStepEndBadges()
	{
		return $this->sourceDb->fetchOne("
			SELECT MAX(badge_id) 
			FROM xf_cmtv_badges_badge
			WHERE badge_id > 0
		") ?: 0;
	}

	public function stepBadges(StepState $state, array $stepConfig, $maxTime)
	{
		$timer = new Timer($maxTime);
		$onStage = 50;

		$badges = $this->sourceDb->fetchAll("
			SELECT *
			FROM xf_cmtv_badges_badge
			WHERE badge_id > ? AND badge_id <= ?
			LIMIT $onStage
		", [$state->startAfter, $state->end]);

		if (!$badges)
		{
			return $state->complete();
		}

		foreach ($badges as $badge)
		{
			$state->startAfter = $oldId = $badge['badge_id'];

			/** @var \OzzModz\Badges\Import\Data\VersoBitBadge $newBadge */
			$newBadge = $this->newHandler(Addon::shortName('VersoBitBadge'));

			$newBadge->bulkSet($this->mapXfKeys($badge, [
				'badge_category_id',
				'icon_type',
				'fa_icon',
				'image_url',
				'image_url_2x',
				'image_url_3x',
				'image_url_4x',
				'class',
				'display_order',
			]));

			$newBadge->set('user_criteria', json_decode($badge['user_criteria'], true));

			$newBadge->setTitle(\XF::phrase('CMTV_Badges_badge_title.' . $oldId));
			$newBadge->setDescription(\XF::phrase('CMTV_Badges_badge_description.' . $oldId));
			$newBadge->setAltDescription(\XF::phrase('CMTV_Badges_badge_alt_description.' . $oldId));

			if ($newBadge->save($oldId))
			{
				$state->imported++;
			}

			if ($timer->limitExceeded()) break;
		}

		return $state->resumeIfNeeded();
	}

	// ################################## USERS ###########################################

	public function getStepEndUsers()
	{
		return $this->sourceDb->fetchOne("
			SELECT MAX(user_id) 
			FROM xf_cmtv_badges_user_badge
			WHERE user_id > 0
		") ?: 0;
	}

	public function stepUsers(StepState $state, array $stepConfig, $maxTime)
	{
		$timer = new Timer($maxTime);

		$userId = $this->sourceDb->fetchOne("
			SELECT DISTINCT user_id
			FROM xf_cmtv_badges_user_badge
			WHERE user_id > ? AND user_id <= ?
			ORDER BY user_id
			LIMIT 1
		", [$state->startAfter, $state->end]);

		if (!$userId)
		{
			return $state->complete();
		}

		$state->startAfter = $userId;

		$userBadges = $this->sourceDb->fetchAll("
			SELECT *
			FROM xf_cmtv_badges_user_badge
			WHERE user_id = ?
		", $userId);

		foreach ($userBadges as $userBadge)
		{
			$badgeId = $this->lookupId('badge', $userBadge['badge_id']);
			if (!$badgeId)
			{
				continue;
			}

			/** @var \XF\Entity\User $badgeUser */
			$badgeUser = $this->em()->find('XF:User', $userBadge['user_id']);
			if (!$badgeUser)
			{
				continue;
			}

			/** @var \OzzModz\Badges\Entity\UserBadge $newBadge */
			$newBadge = $this->em()->create(Addon::shortName('UserBadge'));

			$newBadge->badge_id = $badgeId;

			$newBadge->bulkSet($this->mapXfKeys($userBadge, [
				'user_id',
				'award_date',
				'reason',
				'featured'
			]));

			try
			{
				if ($newBadge->save())
				{
					$state->imported++;
				}
			}
			catch (\Exception $e)
			{
				\XF::logException($e);
			}

			if ($timer->limitExceeded()) break;
		}

		return $state->resumeIfNeeded();
	}
}