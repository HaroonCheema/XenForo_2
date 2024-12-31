<?php

namespace OzzModz\Badges\Api\Controller;

use OzzModz\Badges\Addon;

class BadgeCategories extends \XF\Api\Controller\AbstractController
{
	/**
	 * @api-desc Gets the API list of badge categories.
	 *
	 * @api-out OzzModz_Badges_BadgeCategory[]
	 *
	 * @return \XF\Api\Mvc\Reply\ApiResult
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionGet()
	{
		$this->assertApiScope('badge_category:read');

		$badgeCategoryFinder = $this->setupBadgeCategoryFinder();
		$badges = $badgeCategoryFinder->fetch();
		$badgeResults = $badges->toApiResults();

		return $this->apiResult($badgeResults);
	}

	protected function setupBadgeCategoryFinder()
	{
		$finder = $this->finder(Addon::shortName('BadgeCategory'));
		$finder->order('display_order', 'DESC');

		return $finder;
	}
}