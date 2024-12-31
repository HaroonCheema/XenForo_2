<?php

namespace OzzModz\Badges\Api\Controller;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

class Badge extends \XF\Api\Controller\AbstractController
{
	/**
	 * @api-desc Awards user with badge.
	 *
	 * @api-see \OzzModz\Badges\Api\ControllerPlugin\Badge::actionAward()
	 *
	 * @param ParameterBag $params
	 * @return \XF\Api\Mvc\Reply\ApiResult|\XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Error
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionPostAward(ParameterBag $params)
	{
		$badge = $this->assertBadgeExists($params->badge_id);

		$this->assertRequiredApiInput('user_id');
		$this->assertApiScope('user_badges:write');

		$userId = $this->filter('user_id', 'uint');

		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $this->assertViewableUser($userId, 'api', true);

		/** @var \OzzModz\Badges\Api\ControllerPlugin\Badge $badgePlugin */
		$badgePlugin = $this->plugin(Addon::shortName('Api:Badge'));
		return $badgePlugin->actionAward($user, $badge);
	}

	/**
	 * @api-desc Deletes the specified badge.
	 *
	 * @api-out true $success
	 *
	 * @param ParameterBag $params
	 * @return \XF\Api\Mvc\Reply\ApiResult|\XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Error
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
	public function actionDelete(ParameterBag $params)
	{
		$this->assertApiScope('badges:delete');
		$badge = $this->assertBadgeExists($params->badge_id);
		if (!$badge->preDelete())
		{
			return $this->error($badge->getErrors());
		}

		$badge->delete();

		return $this->apiSuccess();
	}

	/**
	 * @param int $id
	 * @param mixed $with
	 * @param bool $basicProfileOnly
	 *
	 * @return \XF\Entity\User
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertViewableUser($id, $with = 'api', $basicProfileOnly = true)
	{
		/** @var \XF\Entity\User $user */
		$user = $this->assertRecordExists('XF:User', $id, $with);

		if (\XF::isApiCheckingPermissions())
		{
			$canView = $basicProfileOnly ? $user->canViewBasicProfile($error) : $user->canViewFullProfile($error);
			if (!$canView)
			{
				throw $this->exception($this->noPermission($error));
			}
		}

		return $user;
	}

	/**
	 * @param $badgeId
	 * @param null $with
	 * @return Entity|\OzzModz\Badges\Entity\Badge
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertBadgeExists($badgeId, $with = null)
	{
		return $this->assertRecordExists(Addon::shortName('Badge'), $badgeId, $with, Addon::phrase('requested_badge_not_found'));
	}
}