<?php

namespace OzzModz\Badges\Api\Controller;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Entity;


class UserBadges extends \XF\Api\Controller\AbstractController
{
	/**
	 * @api-desc Gets the API list of user badges.
	 *
	 * @api-in int $page
	 * @api-in int $user_id Only gets specified user badges
	 * @api-in int $badge_id Only gets specified badge id
	 * @api-in int $badge_category_id Only gets badges from category if specified
	 * @api-in int $badge_tier_id Only gets badges with tier if specified
	 *
	 * @api-out OzzModz_Badges_UserBadge[] $userBadges
	 * @api-out pagination $pagination
	 *
	 * @return \XF\Api\Mvc\Reply\ApiResult
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionGet()
	{
		$this->assertApiScope('user_badges:read');

		$page = $this->filterPage();
		$perPage = 20;

		$userId = $this->filter('user_id', 'uint');
		if ($userId && \XF::isApiCheckingPermissions())
		{
			$this->assertViewableUser($userId);
		}

		$badgeFinder = $this->setupUserBadgeFinder();
		$badgeFinder->limitByPage($page, $perPage);

		$userBadges = $badgeFinder->fetch();
		$totalUserBadges = $badgeFinder->total();

		$this->assertValidApiPage($page, $perPage, $totalUserBadges);

		$userBadgeResults = $userBadges->toApiResults();

		return $this->apiResult([
			'userBadges' => $userBadgeResults,
			'pagination' => $this->getPaginationData($userBadgeResults, $page, $perPage, $totalUserBadges)
		]);
	}

	/**
	 * @return \OzzModz\Badges\Finder\UserBadge
	 */
	protected function setupUserBadgeFinder()
	{
		/** @var \OzzModz\Badges\Finder\UserBadge $finder */
		$finder = $this->finder(Addon::shortName('UserBadge'));

		$userId = $this->filter('user_id', 'uint');
		if ($userId)
		{
			$finder->forUser($userId);
		}

		$badgeId = $this->filter('badge_id', 'uint');
		if ($badgeId)
		{
			$finder->where('badge_id', $badgeId);
		}

		$badgeCategoryId = $this->filter('badge_category_id', 'uint');
		if ($badgeCategoryId)
		{
			$finder->where('badge_category_id', $badgeCategoryId);
		}

		$badgeTierId = $this->filter('badge_tier_id', 'uint');
		if ($badgeTierId)
		{
			$finder->where('badge_category_id', $badgeTierId);
		}

		$finder->order('award_date', 'DESC');

		return $finder;
	}

	/**
	 * @api-desc Awards user with badge.
	 *
	 * @api-in int $badge_id <req>
	 * @api-in int $user_id <req>
	 *
	 * @api-see \OzzModz\Badges\Api\ControllerPlugin\Badge::actionAward()
	 *
	 * @return \XF\Api\Mvc\Reply\ApiResult|\XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Error
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionPost()
	{
		$this->assertRequiredApiInput(['badge_id', 'user_id']);

		$this->assertApiScope('user_badges:write');

		$userId = $this->filter('user_id', 'uint');

		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $this->assertViewableUser($userId, 'api');

		$badgeId = $this->filter('badge_id', 'uint');
		$badge = $this->assertBadgeExists($badgeId);

		/** @var \OzzModz\Badges\Api\ControllerPlugin\Badge $badgePlugin */
		$badgePlugin = $this->plugin(Addon::shortName('Api:Badge'));
		return $badgePlugin->actionAward($user, $badge);
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
}