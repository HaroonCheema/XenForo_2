<?php

namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF\Job\AbstractJob;

class UserBadgeUpdate extends AbstractJob
{
	protected $defaultData = [
		'start' => 0,
		'batch' => 100,
		'user_id' => null
	];

	public function run($maxRunTime)
	{
		if (!\XF::isAddOnActive('OzzModz/Badges'))
		{
			return $this->complete();
		}
		
		$startTime = microtime(true);

		$app = $this->app;
		$em = $app->em();

		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $em->find('XF:User', $this->data['user_id']);
		if (!$user)
		{
			return $this->complete();
		}

		$batch = $app->options()->ozzmodz_badges_updateBatchSize ?: 100;
		if ($batch)
		{
			$this->data['batch'] = $batch;
		}

		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = $app->repository(Addon::shortName('Badge'));

		$badges = $badgeRepo->findBadgesForList()
			->where('badge_id', '>', $this->data['start'])
			->limit($this->data['batch'])
			->order('badge_id')
			->fetch();

		if (!$badges->count())
		{
			return $this->complete();
		}

		/** @var \OzzModz\Badges\Repository\UserBadge $userBadgeRepo */
		$userBadgeRepo = $app->repository(Addon::shortName('UserBadge'));
		$userBadges = $userBadgeRepo->findUserBadges($user->user_id)->useDisplayOrder()->fetch();

		/** @var \OzzModz\Badges\Entity\Badge $badge */
		foreach ($badges as $badge)
		{
			$this->data['start'] = $badge->badge_id;

			$userBadgeRepo->updateBadgeForUser($user, $badge, $userBadges);

			if (microtime(true) - $startTime >= $maxRunTime)
			{
				break;
			}
		}

		$userBadgeRepo->refineFeaturedUserBadges($user, $userBadges);

		return $this->resume();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('rebuilding');
		$typePhrase = Addon::phrase('badges');
		return sprintf('%s... %s (%s)', $actionPhrase, $typePhrase, $this->data['start']);
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