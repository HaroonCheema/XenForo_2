<?php

namespace OzzModz\Badges\Api\Controller;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

class UserBadge extends \XF\Api\Controller\AbstractController
{
	/**
	 * @api-desc Edits reason for user badge
	 *
	 * @api-in str $reason <req>
	 *
	 * @api-out OzzModz_Badges_UserBadge[]
	 *
	 * @param ParameterBag $params
	 * @return \XF\Api\Mvc\Reply\ApiResult|\XF\Mvc\Reply\AbstractReply
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionPostEdit(ParameterBag $params)
	{
		$userBadge = $this->assertUserBadgeExists($params->user_badge_id);
		$this->assertRequiredApiInput('reason');

		if (\XF::isApiCheckingPermissions() && !$userBadge->canEdit($error))
		{
			return $this->noPermission($error);
		}

		$reason = $this->filter('reason', 'str');
		$userBadge->reason = $reason;

		$userBadge->saveIfChanged();

		return $this->apiResult($userBadge);
	}

	/**
	 * @api-desc Toggles featured state the specified user badge.
	 *
	 * @api-out OzzModz_Badges_UserBadge[]
	 *
	 * @param ParameterBag $params
	 * @return \XF\Api\Mvc\Reply\ApiResult|\XF\Mvc\Reply\AbstractReply
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
	public function actionPostFeature(ParameterBag $params)
	{
		$userBadge = $this->assertUserBadgeExists($params->user_badge_id);

		if (\XF::isApiCheckingPermissions() && !$userBadge->canManageFeatured($error))
		{
			return $this->noPermission($error);
		}

		if ($userBadge->featured)
		{
			$userBadge->featured = false;
		}
		else
		{
			if (!$userBadge->canAddFeatured($error))
			{
				return $this->noPermission($error);
			}

			$userBadge->featured = true;
		}

		$userBadge->save();

		return $this->apiResult($userBadge);
	}

	/**
	 * @api-desc Deletes the specified user badge.
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
		$this->assertApiScope('user_badges:delete');
		$userBadge = $this->assertUserBadgeExists($params->user_badge_id);

		if (\XF::isApiCheckingPermissions() && !$userBadge->canDelete($errors))
		{
			return $this->noPermission($errors);
		}

		if (!$userBadge->preDelete())
		{
			return $this->error($userBadge->getErrors());
		}

		$userBadge->delete();

		return $this->apiSuccess();
	}

	/**
	 * @param $userBadgeId
	 * @param null $with
	 * @return Entity|\OzzModz\Badges\Entity\UserBadge
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertUserBadgeExists($userBadgeId, $with = null)
	{
		return $this->assertRecordExists(Addon::shortName('UserBadge'), $userBadgeId, $with, Addon::phrase('requested_user_badge_not_found'));
	}
}