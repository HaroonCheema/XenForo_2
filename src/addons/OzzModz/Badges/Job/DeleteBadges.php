<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF;
use XF\Job\AbstractRebuildJob;

class DeleteBadges extends AbstractRebuildJob
{
	protected function getNextIds($start, $batch)
	{
		$db = $this->app->db();

		$table = Addon::table('badge');
		$categoryId = $this->data['category_id'];

		return $db->fetchAllColumn(
			$db->limit("SELECT `badge_id` FROM `{$table}` WHERE `badge_category_id` = {$categoryId}",
				$this->data['batch'],
				$this->data['start']
			)
		);
	}

	protected function rebuildById($id)
	{
		$badge = $this->app->finder(Addon::shortName('Badge'))->whereId($id)->fetchOne();
		if ($badge)
		{
			$badge->delete();
		}
	}

	protected function getStatusType()
	{
		return Addon::phrase('deleting_badges_in_category');
	}
}