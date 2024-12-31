<?php

namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF\Job\AbstractJob;

class DeleteUserBadges extends AbstractJob
{
	protected $defaultData = [
		'start' => 0,
		'batch' => 100,
		'badge_id' => null,
		'user_badge_ids' => null,
		'user_id' => null
	];

	public function run($maxRunTime)
	{
		if (empty($this->data['badge_id']) && empty($this->data['user_id']) && empty($this->data['user_badge_ids']))
		{
			throw new \InvalidArgumentException('Cannot remove badges without a user_id, badge_id or user_badge_ids.');
		}

		$startTime = microtime(true);

		$userBadgeFinder = $this->app->finder(Addon::shortName('UserBadge'));

		$badgeId = $this->data['badge_id'];
		if ($badgeId)
		{
			$userBadgeFinder->where('badge_id', $badgeId);
		}

		$userId = $this->data['user_id'];
		if ($userId)
		{
			$userBadgeFinder->where('user_id', '=', $userId);
		}

		$userBadgeId = $this->data['user_badge_ids'];
		if ($userBadgeId)
		{
			$userBadgeFinder->where('user_badge_id', $userBadgeId);
		}

		$userBadges = $userBadgeFinder
			->where('user_badge_id', '>', $this->data['start'])
			->limit($this->data['batch'])
			->fetch();

		if (!$userBadges->count())
		{
			return $this->complete();
		}

		$done = 0;

		/** @var \OzzModz\Badges\Entity\UserBadge $userBadge */
		foreach ($userBadges as $userBadge)
		{
			$this->data['start'] = $userBadge->user_badge_id;

			$userBadge->delete();

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
		return Addon::phrase('deleting_user_badges');
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