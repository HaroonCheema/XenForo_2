<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Cron;


use OzzModz\Badges\Addon;
use OzzModz\Badges\XF\Entity\User;
use XF;

class Badge
{
	public static function runBadgeCheck()
	{
		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = XF::repository(Addon::shortName('Badge'));
		$badges = $badgeRepo->findBadgesForList()->fetch();

		if (!$badges)
		{
			return;
		}

		/** @var \XF\Finder\User $userFinder */
		$userFinder = XF::finder('XF:User');
		$cronInterval = XF::options()->ozzmodz_badges_cronInterval;

		if ($cronInterval <= 0)
		{
			$cronInterval = 1;
		}

		$users = $userFinder
			->where('last_activity', '>=', time() - $cronInterval * 3600)
			->isValidUser()
			->fetch();

		/** @var \OzzModz\Badges\Repository\UserBadge $userBadgeRepo */
		$userBadgeRepo = XF::repository(Addon::shortName('UserBadge'));

		/** @var User $user */
		foreach ($users as $user)
		{
			$userBadgeRepo->queueUserBadgeUpdateAndRunUpdateJob($user);
		}
	}

	/**
	 * @return XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\UserBadge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	protected function getUserBadgeRepo()
	{
		return XF::repository(Addon::shortName('UserBadge'));
	}
}