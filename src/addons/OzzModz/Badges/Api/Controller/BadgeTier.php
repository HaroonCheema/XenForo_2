<?php

namespace OzzModz\Badges\Api\Controller;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

class BadgeTier extends \XF\Api\Controller\AbstractController
{
	/**
	 * @api-desc Deletes the specified badge tier.

	 * @api-out true $success
	 *
	 * @param ParameterBag $params
	 * @return \XF\Api\Mvc\Reply\ApiResult|\XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Error
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
	public function actionDelete(ParameterBag $params)
	{
		$this->assertApiScope('badge_tier:delete');
		$badge = $this->assertBadgeTierExists($params->badge_tier_id);
		if (!$badge->preDelete())
		{
			return $this->error($badge->getErrors());
		}

		$badge->delete();

		return $this->apiSuccess();
	}

	/**
	 * @param $badgeTierId
	 * @param null $with
	 * @return Entity|\OzzModz\Badges\Entity\BadgeTier
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertBadgeTierExists($badgeTierId, $with = null)
	{
		return $this->assertRecordExists(
			Addon::shortName('BadgeTier'),
			$badgeTierId,
			$with,
			Addon::phrase('requested_badge_tier_not_found')
		);
	}
}