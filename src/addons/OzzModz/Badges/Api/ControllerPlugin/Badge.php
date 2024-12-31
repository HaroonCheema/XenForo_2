<?php

namespace OzzModz\Badges\Api\ControllerPlugin;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

class Badge extends \XF\Api\ControllerPlugin\AbstractPlugin
{
	/**
	 * @api-desc Awards user with badge.
	 *
	 * @api-out OzzModz_Badges_UserBadge[]
	 *
	 * @param ParameterBag $params
	 * @return \XF\Api\Mvc\Reply\ApiResult|\XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Error
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionAward(\XF\Entity\User $user, \OzzModz\Badges\Entity\Badge $badge)
	{
		$this->assertApiScope('user_badges:write');

		/** @var \OzzModz\Badges\XF\Entity\User $user */
		if (\XF::isApiCheckingPermissions() && !$user->canAwardWithBadge())
		{
			return $this->noPermission();
		}

		$awarder = $this->setupUserBadgeAward($user, $badge);
		if (!$awarder->validate($errors))
		{
			return $this->error($errors);
		}

		/** @var \OzzModz\Badges\Entity\UserBadge $userBadge */
		$userBadge = $awarder->save();
		$this->finalizeUserBadgeAward($awarder);

		return $this->apiSuccess([
			'userBadge' => $userBadge->toApiResult(Entity::VERBOSITY_VERBOSE)
		]);
	}

	protected function setupUserBadgeAward(\OzzModz\Badges\XF\Entity\User $user, \OzzModz\Badges\Entity\Badge $badge)
	{
		/** @var \OzzModz\Badges\Service\Award $awardService */
		$awardService = \XF::service(Addon::shortName('Award'), $user, $badge);
		$awardService->setReason($this->filter('reason', 'str'));

		return $awardService;
	}

	protected function finalizeUserBadgeAward(\OzzModz\Badges\Service\Award $awardService)
	{
	}

}