<?php

namespace OzzModz\Badges\Api\Controller;

use OzzModz\Badges\Addon;

class BadgeTiers extends \XF\Api\Controller\AbstractController
{
	/**
	 * @api-desc Gets the API list of badge tiers.
	 *
	 * @api-out OzzModz_Badges_BadgeTier[]
	 *
	 * @return \XF\Api\Mvc\Reply\ApiResult
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionGet()
	{
		$this->assertApiScope('badge_tier:read');

		$badgeTierFinder = $this->setupBadgeTierFinder();
		$badgeTiers = $badgeTierFinder->fetch();
		$badgeTierResults = $badgeTiers->toApiResults();

		return $this->apiResult($badgeTierResults);
	}

	protected function setupBadgeTierFinder()
	{
		$finder = $this->finder(Addon::shortName('BadgeTier'));
		$finder->order('display_order', 'DESC');

		return $finder;
	}
}