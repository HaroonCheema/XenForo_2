<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Job;


use OzzModz\Badges\Addon;
use XF;
use XF\Job\AbstractRebuildJob;

class UserBadgeCountRebuild extends AbstractRebuildJob
{
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		return $db->fetchAllColumn(
			$db->limit("SELECT `user_id` FROM `xf_user` WHERE `user_id` > ? ORDER BY `user_id`", $batch),
			$start
		);
	}

	protected function rebuildById($id)
	{
		$app = $this->app;

		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $this->app->em()->find('XF:User', $id);
		if (!$user)
		{
			return;
		}

		$userBadgeFinder = $app->finder(Addon::shortName('UserBadge'))
			->where('user_id', $user->user_id)
			->order('award_date', 'DESC');

		$userBadgeCount = $userBadgeFinder->total();
		$user->ozzmodz_badges_badge_count = $userBadgeCount;

		if ($userBadgeCount)
		{
			/** @var \OzzModz\Badges\Entity\UserBadge $lastUserBadge */
			$lastUserBadge = $userBadgeFinder->fetchOne();
			$user->ozzmodz_badges_last_award_date = $lastUserBadge->award_date;
		}
		else
		{
			$user->ozzmodz_badges_last_award_date = 0;
		}

		$user->saveIfChanged();
	}

	protected function getStatusType()
	{
		return XF::phrase('users');
	}
}