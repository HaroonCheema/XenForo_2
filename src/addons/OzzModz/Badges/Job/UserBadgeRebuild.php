<?php

namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF\Job\AbstractJob;

class UserBadgeRebuild extends AbstractJob
{
	protected $defaultData = [
		'steps' => 0,
		'start' => 0,
		'batch' => 10,
		'start_badge_id' => 0
	];

	public function run($maxRunTime)
	{
		$startTime = microtime(true);

		$app = $this->app;
		$jobManager = $app->jobManager();

		// Cancel auto update job to avoid race condition
		$jobManager->cancelUniqueJob('userBadgeUpdate');

		$this->data['steps']++;

		/** @var \XF\Finder\User $userFinder */
		$userFinder = $app->finder('XF:User');
		$userFinder->where('user_id', '>', $this->data['start'])
			->with(['Profile', 'Option'])
			->order('user_id')
			->limit($this->data['batch']);

		$users = $userFinder->fetch();
		if (!$users->count())
		{
			return $this->complete();
		}

		$done = 0;

		$badgesBatch = $app->options()->ozzmodz_badges_updateBatchSize ?: 100;
		$badges = $app->finder(Addon::shortName('Badge'))
			->order('badge_id')
			->where('badge_id', '>', $this->data['start_badge_id'])
			->fetch($badgesBatch);

		// Start next user only if all badges processed
		if (!$badges->count())
		{
			/** @var \OzzModz\Badges\XF\Entity\User $lastUser */
			$lastUser = $users->last();

			$this->data['start'] = $lastUser->user_id;
			$this->data['start_badge_id'] = 0;
			return $this->resume();
		}

		/** @var \OzzModz\Badges\XF\Entity\User $user */
		foreach ($users as $user)
		{
			/** @var \OzzModz\Badges\Repository\UserBadge $userBadgeRepo */
			$userBadgeRepo = $app->repository(Addon::shortName('UserBadge'));
			$userBadges = $userBadgeRepo->findUserBadges($user->user_id)->useDisplayOrder()->fetch();

			/** @var \OzzModz\Badges\Entity\Badge $badge */
			foreach ($badges as $badge)
			{
				$this->data['start_badge_id'] = $badge->badge_id;

				$userBadgeRepo->updateBadgeForUser($user, $badge, $userBadges);

				if (microtime(true) - $startTime >= $maxRunTime)
				{
					break;
				}
			}

			$done++;

			if (microtime(true) - $startTime >= $maxRunTime)
			{
				break;
			}
		}

		$this->data['batch'] = $this->calculateOptimalBatch($this->data['batch'], $done, $startTime, $maxRunTime, 1000);

		return $this->resume();
	}

	public function getStatusMessage()
	{
		$actionPhrase = Addon::phrase('rebuild_user_badges');
		return sprintf('%s...  (%s)', $actionPhrase, $this->data['start']);
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return true;
	}
}