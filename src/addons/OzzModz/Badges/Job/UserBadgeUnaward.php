<?php

namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF\Entity\User;

class UserBadgeUnaward extends \XF\Job\AbstractUserCriteriaJob
{
	protected function setupData(array $data)
	{
		if (empty($data['criteria']['ozzmodz_badges_badge_ids']))
		{
			throw new \LogicException("Cannot run without ozzmodz_badges_badge_ids criteria");
		}

		return parent::setupData($data);
	}

	protected function executeAction(User $user)
	{
		$badgeIds = $this->data['criteria']['ozzmodz_badges_badge_ids'] ?? [];
		if (!$badgeIds)
		{
			return;
		}

		$userBadgeFinder = $this->app->finder(Addon::shortName('UserBadge'))
			->where('user_id', '=', $user->user_id)
			->where('badge_id', $badgeIds);

		$userBadges = $userBadgeFinder->fetch();

		foreach ($userBadges as $userBadge)
		{
			$userBadge->delete();
		}
	}

	protected function getActionDescription()
	{
		$actionPhrase = Addon::phrase('unawarding');
		$typePhrase = \XF::phrase('users');

		return sprintf('%s... %s', $actionPhrase, $typePhrase);
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}