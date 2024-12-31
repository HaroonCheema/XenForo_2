<?php

namespace OzzModz\Badges\Api\Controller;

use OzzModz\Badges\Addon;


class Badges extends \XF\Api\Controller\AbstractController
{
	/**
	 * @api-desc Gets the API list of badges.
	 *
	 * @api-out OzzModz_Badges_Badge[]
	 *
	 * @return \XF\Api\Mvc\Reply\ApiResult
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionGet()
	{
		$this->assertApiScope('badges:read');

		$badgeFinder = $this->setupBadgeFinder();
		$badges = $badgeFinder->fetch();
		$badgeResults = $badges->toApiResults();

		return $this->apiResult($badgeResults);
	}

	/**
	 * @return \OzzModz\Badges\Finder\Badge
	 */
	protected function setupBadgeFinder()
	{
		/** @var \OzzModz\Badges\Finder\Badge $finder */
		$finder = $this->finder(Addon::shortName('Badge'));
		$finder->order('badge_id', 'DESC');

		return $finder;
	}
}