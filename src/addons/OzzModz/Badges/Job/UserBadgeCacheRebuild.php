<?php

namespace OzzModz\Badges\Job;

use XF;
use XF\Job\AbstractRebuildJob;

class UserBadgeCacheRebuild extends AbstractRebuildJob
{
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		return $db->fetchAllColumn(
			$db->limit("
				SELECT `user_id` FROM `xf_user` WHERE `user_id` > ? AND `ozzmodz_badges_badge_count` > 0 ORDER BY `user_id`
			", $batch),
			$start
		);
	}

	protected function rebuildById($id)
	{
		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $this->app->finder('XF:User')->whereId($id)->fetchOne();

		if ($user)
		{
			$user->rebuildBadgeCache(false);
			$user->rebuildReceivedBadgeIds(false);
			$user->rebuildBadgeTierCounts(false);

			$user->saveIfChanged();
		}
	}

	protected function getStatusType()
	{
		return XF::phrase('users');
	}
}