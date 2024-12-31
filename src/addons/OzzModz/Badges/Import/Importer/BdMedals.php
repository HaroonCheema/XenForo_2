<?php


namespace OzzModz\Badges\Import\Importer;


use League\Flysystem\FileExistsException;
use OzzModz\Badges\Addon;
use XF\Import\StepState;
use XF\Timer;

class BdMedals extends \XF\Import\Importer\AbstractAddOnImporter
{
	public static function getListInfo()
	{
		$listInfo = [];

		$listInfo['target'] = '[OzzModz] Badges';
		$listInfo['source'] = '[bd] Medals';
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
			'badges' => [
				'only_large_icons' => false
			],
			'users' => [],
		];
	}

	public function renderStepConfigOptions(array $vars)
	{
		$vars['stepConfig'] = $this->getStepConfigDefault();
		return $this->app->templater()->renderTemplate('admin:ozzmodz_badges_bdmedal_import_step_config', $vars);
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
			SELECT MAX(category_id) 
			FROM xf_bdmedal_category
			WHERE category_id > 0
		") ?: 0;
	}

	public function stepCategories(StepState $state, array $stepConfig, $maxTime)
	{
		$timer = new Timer($maxTime);
		$onStage = 50;

		$categories = $this->sourceDb->fetchAll("
			SELECT *
			FROM xf_bdmedal_category
			WHERE category_id > ? AND category_id <= ?
			LIMIT $onStage
		", [$state->startAfter, $state->end]);

		if (!$categories)
		{
			return $state->complete();
		}

		foreach ($categories as $category)
		{
			$state->startAfter = $oldId = $category['category_id'];

			/** @var \OzzModz\Badges\Import\Data\BdMedalCategory $newCategory */
			$newCategory = $this->newHandler(Addon::shortName('BdMedalCategory'));

			$newCategory->bulkSet($this->mapXfKeys($category, [
				'display_order',
			]));

			$newCategory->setTitle($category['name']);

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
			SELECT MAX(medal_id) 
			FROM xf_bdmedal_medal
			WHERE medal_id > 0
		") ?: 0;
	}

	public function stepBadges(StepState $state, array $stepConfig, $maxTime)
	{
		$timer = new Timer($maxTime);
		$onStage = 50;

		$medals = $this->sourceDb->fetchAll("
			SELECT *
			FROM xf_bdmedal_medal
			WHERE medal_id > ? AND medal_id <= ?
			LIMIT $onStage
		", [$state->startAfter, $state->end]);

		if (!$medals)
		{
			return $state->complete();
		}

		foreach ($medals as $medal)
		{
			$state->startAfter = $oldId = $medal['medal_id'];

			/** @var \OzzModz\Badges\Import\Data\BdMedal $newBadge */
			$newBadge = $this->newHandler(Addon::shortName('BdMedal'));

			$newBadge->bulkSet($this->mapXfKeys($medal, [
				'display_order',
			]));

			$newBadge->set('badge_category_id', $medal['category_id']);
			$newBadge->set('awarded_number', $medal['user_count']);

			if ($medal['image_date'])
			{
				$newBadge->set('icon_type', 'asset');

				$fs = $this->app->fs();

				if ($medal['is_svg'])
				{
					$oldAbstractedPath = "data://medal/{$medal['medal_id']}_{$medal['image_date']}.svg";
					if ($fs->has($oldAbstractedPath))
					{
						$newAbstractedPath = "data://assets/ozzmodz_badges_badge/{$medal['medal_id']}_{$medal['image_date']}.svg";
						try
						{
							$fs->copy($oldAbstractedPath, $newAbstractedPath);
						}
						catch (FileExistsException $e)
						{
						}

						$externalPath = str_replace('data://', '', $newAbstractedPath);
						$externalDataUrl = $this->app->config('externalDataUrl');
						if ($externalDataUrl instanceof \Closure)
						{
							$url = $externalDataUrl($externalPath, 'nopath');
						}
						else
						{
							$url = "/$externalDataUrl/$externalPath";
						}

						$newBadge->set('image_url', $url);
					}
				}
				else
				{
					$imageSizeMap = ['l', 't', 'm', 's'];
					$existingImageSizeMap = [];

					$i = 0;
					foreach ($imageSizeMap as $sizeKey)
					{
						$onlyLargeIcons = $stepConfig['only_large_icons'];
						if ($onlyLargeIcons && $sizeKey != 'l')
						{
							continue;
						}

						$oldAbstractedPath = "data://medal/{$medal['medal_id']}_{$medal['image_date']}$sizeKey.jpg";
						if ($fs->has($oldAbstractedPath))
						{
							$newAbstractedPath = "data://assets/ozzmodz_badges_badge/{$medal['medal_id']}_{$medal['image_date']}$sizeKey.jpg";
							try
							{
								$fs->copy($oldAbstractedPath, $newAbstractedPath);
							}
							catch (FileExistsException $e)
							{
							}

							if ($i > 3)
							{
								$i = 0;
							}

							$externalPath = str_replace('data://', '', $newAbstractedPath);
							$externalDataUrl = $this->app->config('externalDataUrl');
							if ($externalDataUrl instanceof \Closure)
							{
								$url = $externalDataUrl($externalPath, 'nopath');
							}
							else
							{
								$url = "/$externalDataUrl/$externalPath";
							}

							$existingImageSizeMap[$i] = $url;

							$i++;
						}
					}

					$existingImageCount = count($existingImageSizeMap);

					if ($existingImageCount == 4)
					{
						$newBadge->bulkSet([
							'image_url_4x' => $existingImageSizeMap[0],
							'image_url_3x' => $existingImageSizeMap[1],
							'image_url_2x' => $existingImageSizeMap[2],
							'image_url' => $existingImageSizeMap[3]
						]);
					}
					elseif ($existingImageCount == 3)
					{
						$newBadge->bulkSet([
							'image_url_3x' => $existingImageSizeMap[0],
							'image_url_2x' => $existingImageSizeMap[1],
							'image_url' => $existingImageSizeMap[2]
						]);
					}
					elseif ($existingImageCount == 2)
					{
						$newBadge->bulkSet([
							'image_url_2x' => $existingImageSizeMap[0],
							'image_url' => $existingImageSizeMap[1]
						]);
					}
					elseif ($existingImageCount)
					{
						$newBadge->set('image_url', $existingImageSizeMap[0]);
					}
				}
			}

			$newBadge->setTitle($medal['name']);
			$newBadge->setDescription($medal['description']);

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
			SELECT MAX(awarded_id) 
			FROM xf_bdmedal_awarded
			WHERE awarded_id > 0
		") ?: 0;
	}

	public function stepUsers(StepState $state, array $stepConfig, $maxTime)
	{
		$timer = new Timer($maxTime);
		$onStage = 50;

		$userMedals = $this->sourceDb->fetchAll("
			SELECT *
			FROM xf_bdmedal_awarded
			WHERE awarded_id  > ? AND awarded_id  <= ?
			ORDER BY awarded_id
			LIMIT $onStage
		", [$state->startAfter, $state->end]);

		if (!$userMedals)
		{
			return $state->complete();
		}

		foreach ($userMedals as $userMedal)
		{
			$state->startAfter = $oldId = $userMedal['awarded_id'];

			$badgeId = $this->lookupId('badge', $userMedal['medal_id']);
			if (!$badgeId)
			{
				continue;
			}

			/** @var \OzzModz\Badges\Import\Data\BdMedalAwarded $newBadge */
			$newBadge = $this->newHandler(Addon::shortName('BdMedalAwarded'));
			$newBadge->set('badge_id', $badgeId);

			$newBadge->bulkSet($this->mapXfKeys($userMedal, [
				'user_id',
				'award_date'
			]));

			$newBadge->set('reason', $userMedal['award_reason']);

			if ($newBadge->save($oldId))
			{
				$state->imported++;
			}

			if ($timer->limitExceeded()) break;
		}

		return $state->resumeIfNeeded();
	}
}