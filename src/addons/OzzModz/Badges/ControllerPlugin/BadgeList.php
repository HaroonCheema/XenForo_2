<?php

namespace OzzModz\Badges\ControllerPlugin;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Repository;

class BadgeList extends \XF\ControllerPlugin\AbstractPlugin
{
	public function getBadgeListData($onlyActive = true)
	{
		$badgeRepo = $this->getBadgeRepo();
		$badgeFinder = $badgeRepo->findBadgesForList();
		if ($onlyActive)
		{
			$badgeFinder->onlyActive();
		}

		$badges = $badgeFinder->fetch();
		$badgeCategories = $this->getBadgeCategoryRepo()->getBadgeCategoriesForList(true);

		return $this->getBadgeListDataParams($badges, $badgeCategories);
	}

	public function getBadgeListDataParams(\XF\Mvc\Entity\AbstractCollection $badges, \XF\Mvc\Entity\AbstractCollection $badgeCategories)
	{
		return [
			'badgeCategories' => $badgeCategories,
			'badges' => $badges->groupBy('badge_category_id')
		];
	}

	/**
	 * @return \XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\Badge
	 */
	protected function getBadgeRepo()
	{
		return $this->repository(Addon::shortName('Badge'));
	}

	/**
	 * @return Repository|\OzzModz\Badges\Repository\BadgeCategory
	 */
	protected function getBadgeCategoryRepo()
	{
		return $this->repository(Addon::shortName('BadgeCategory'));
	}
}