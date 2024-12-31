<?php

namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF\Job\AbstractJob;

class UserBadgeUpdateQueue extends AbstractJob
{
	protected $defaultData = [
		'steps' => 0,
		'start' => 0,
		'start_badge_id' => 0
	];

	public function run($maxRunTime)
	{
		if (!\XF::isAddOnActive('OzzModz/Badges'))
		{
			return $this->complete();
		}

		$startTime = microtime(true);
		$app = $this->app;

		$this->data['steps']++;

		/** @var \OzzModz\Badges\Entity\UserBadgeUpdate $userBadgeUpdate */
		$userBadgeUpdate = $app->finder('OzzModz\Badges:UserBadgeUpdate')
			->where('user_id', '>', $this->data['start'])
			->with('User', true)
			->order('queue_date')
			->fetchOne();

		if (!$userBadgeUpdate)
		{
			$this->data['start'] = 0;

			$result = $this->resume();
			$result->continueDate = \XF::$time + 60;

			return $result;
		}

		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = $app->repository(Addon::shortName('Badge'));

		$badgesBatch = $app->options()->ozzmodz_badges_updateBatchSize ?: 100;
		$badges = $badgeRepo->findBadgesForAutoAward()
			->where('badge_id', '>', $this->data['start_badge_id'])
			->limit($badgesBatch)
			->fetch();

		if (!$badges->count())
		{
			$this->data['start_badge_id'] = -1;

			$userBadgeUpdate->delete();

			return $this->resume();
		}

		// Start next user only if all badges update finished
		if ($this->data['start_badge_id'] === -1)
		{
			$this->data['start'] = $userBadgeUpdate->user_id;
		}

		/** @var \OzzModz\Badges\Repository\UserBadge $userBadgeRepo */
		$userBadgeRepo = $app->repository(Addon::shortName('UserBadge'));
		$userBadges = $userBadgeRepo->findUserBadges($userBadgeUpdate->user_id)->useDisplayOrder()->fetch();

		/** @var \OzzModz\Badges\Entity\Badge $badge */
		foreach ($badges as $badge)
		{
			$this->data['start_badge_id'] = $badge->badge_id;

			$userBadgeRepo->updateBadgeForUser($userBadgeUpdate->User, $badge, $userBadges);

			if (microtime(true) - $startTime >= $maxRunTime)
			{
				break;
			}
		}

		return $this->resume();
	}

	public function getStatusMessage()
	{
		if ($this->data['start'])
		{
			$actionPhrase = Addon::phrase('user_badge_update_queue');
			return sprintf('%s...  (%s)', $actionPhrase, $this->data['start']);
		}
		else
		{
			return Addon::phrase('awaiting_new_queue_items');
		}
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