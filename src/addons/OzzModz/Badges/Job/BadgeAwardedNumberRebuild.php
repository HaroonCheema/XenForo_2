<?php


namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF\Job\AbstractRebuildJob;

class BadgeAwardedNumberRebuild extends AbstractRebuildJob
{
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		return $db->fetchAllColumn($db->limit("
			SELECT b.`badge_id`
			FROM `xf_ozzmodz_badges_badge` AS b
			INNER JOIN `xf_ozzmodz_badges_user_badge` AS ub
				ON b.badge_id = ub.badge_id
			WHERE b.`badge_id` > ? ORDER BY b.`badge_id`
		", $batch), $start);
	}

	protected function rebuildById($id)
	{
		/** @var \OzzModz\Badges\Entity\Badge $badge */
		$badge = $this->app->em()->find(Addon::shortName('Badge'), $id);
		if ($badge)
		{
			$badge->rebuildAwardedNumber();
		}
	}

	protected function getStatusType()
	{
		return Addon::phrase('badges');
	}
}