<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Help;

use OzzModz\Badges\Addon;
use XF\Mvc\Controller;
use XF\Mvc\Reply\View;

class Badges
{
	public static function renderBadges(Controller $controller, View &$reply)
	{
		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = $controller->repository(Addon::shortName('Badge'));

		/** @var \OzzModz\Badges\Repository\BadgeCategory $badgeCategoryRepo */
		$badgeCategoryRepo = $controller->repository(Addon::shortName('BadgeCategory'));

		$badges = $badgeRepo->findBadgesForList()->onlyActive()->fetch();
		$badgeCategories = $badgeCategoryRepo->getBadgeCategoriesForList(true);

		/** @var \OzzModz\Badges\ControllerPlugin\BadgeList $badgeListPlugin */
		$badgeListPlugin = $controller->plugin(Addon::shortName('BadgeList'));
		$badgeData = $badgeListPlugin->getBadgeListDataParams($badges, $badgeCategories);

		$reply->setParam('badgeData', $badgeData);
	}
}
