<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\XF\Pub\Controller;

use OzzModz\Badges\Addon;
use XF;
use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
	//
	// ACTIONS
	//

	public function actionBadges(ParameterBag $params)
	{
		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $this->assertViewableUser($params->user_id);

		/** @var \OzzModz\Badges\XF\Entity\User $visitor */
		$visitor = XF::visitor();
		if (!$visitor->canViewBadgesTab($user))
		{
			return $this->noPermission();
		}

		$userBadgeRepo = $this->getUserBadgeRepo();
		$userBadges = $userBadgeRepo->findUserBadges($user->user_id)
			->with('full')
			->useDisplayOrder()
			->fetch();

		$userBadgeRepo->refineFeaturedUserBadges($user, $userBadges);

		if ($this->options()->ozzmodz_badges_stackBadgesMemberTab)
		{
			$userBadges = $userBadgeRepo->mergeStackedBadgesIntoUserBadges($userBadges);
		}

		$userBadgesData = $userBadgeRepo->getUserBadgesListData($userBadges);

		if ($user->user_id == $visitor->user_id)
		{
			/** @var \XF\Repository\UserAlert $userAlertRepo */
			$userAlertRepo = $this->repository('XF:UserAlert');
			$userAlertRepo->markUserAlertsReadForContent('ozzmodz_badges_badge', $userBadgesData['badgeIds']);
		}

		$viewParams = [
			'user' => $user,
			'badgeCategories' => $userBadgesData['badgeCategories'],
			'userBadges' => $userBadgesData['userBadges'],
			'totalCategories' => $userBadgesData['totalCategories'],
			'totalBadges' => $userBadgesData['totalBadges']
		];

		return $this->view(
			'XF:Member\Badges\Listing',
			Addon::prefix('member_badges'),
			$viewParams
		);
	}

	public function actionAwardBadge(ParameterBag $params)
	{
		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $this->assertViewableUser($params->user_id);

		if (!$user->canAwardWithBadge())
		{
			return $this->noPermission();
		}

		if ($this->isPost())
		{
			$badgeId = $this->filter('badge_id', 'uint');

			/** @var \OzzModz\Badges\Entity\Badge $badge */
			$badge = $this->em()->find(Addon::shortName('Badge'), $badgeId);
			if (!$badge)
			{
				return $this->notFound();
			}

			$awardService = $this->setupUserBadgeAwardService($user, $badge);
			if (!$awardService->validate($errors))
			{
				return $this->error($errors);
			}

			$awardService->save();
			$this->finalizeUserBadgeAward($awardService);

			return $this->redirectPermanently($this->buildLink('members', $user) . '#badges');
		}

		$badgeRepo = $this->getBadgeRepo();
		$badges = $badgeRepo->findBadgesForList()->onlyActive()->fetch();

		$badges = $badges->filter(function (\OzzModz\Badges\Entity\Badge $badge) use ($user) {
			/** @var \OzzModz\Badges\XF\Entity\User $visitor */
			$visitor = \XF::visitor();
			if ($user && !$visitor->canAwardWithBadge($user, $badge))
			{
				return false;
			}

			return true;
		});

		/** @var \OzzModz\Badges\Repository\BadgeCategory $badgeCategoryRepo */
		$badgeCategoryRepo = $this->repository(Addon::shortName('BadgeCategory'));
		$badgeCategories = $badgeCategoryRepo->getBadgeCategoriesForList(true);

		/** @var \OzzModz\Badges\ControllerPlugin\BadgeList $badgeListPlugin */
		$badgeListPlugin = $this->plugin(Addon::shortName('BadgeList'));
		$badgeData = $badgeListPlugin->getBadgeListDataParams($badges, $badgeCategories);

		if (empty($badgeData['badges']))
		{
			return $this->error(Addon::phrase('no_rewardable_badges_for_this_user'));
		}

		$viewParams = [
			'user' => $user,
			'badgeData' => $badgeData
		];

		return $this->view(
			'XF:Member\Badges\Award',
			Addon::prefix('award_with_badge'),
			$viewParams
		);
	}

	protected function finalizeUserBadgeAward(\OzzModz\Badges\Service\Award $awardService)
	{
	}

	protected function setupUserBadgeAwardService(\XF\Entity\User $user, \OzzModz\Badges\Entity\Badge $badge)
	{
		/** @var \OzzModz\Badges\Service\Award $awardService */
		$awardService = \XF::service(Addon::shortName('Award'), $user, $badge);
		$awardService->setReason($this->filter('reason', 'str'));

		return $awardService;
	}

	public function actionTakeAwayBadge(ParameterBag $params)
	{
		/** @var \OzzModz\Badges\XF\Entity\User $user */
		$user = $this->assertViewableUser($params->user_id);

		if (!$user->canTakeAwayBadges($error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			$userBadgeIds = $this->filter('user_badge_ids', 'array-uint');
			if (!$userBadgeIds)
			{
				return $this->error(Addon::phrase('please_select_at_least_one_badge'));
			}

			$this->app()->jobManager()->enqueueAutoBlocking(
				Addon::shortName('DeleteUserBadges'),
				[
					'user_id' => $user->user_id,
					'user_badge_ids' => $userBadgeIds
				]
			);

			return $this->redirectPermanently($this->buildLink('members', $user) . '#badges');
		}

		$viewParams = [
			'user' => $user,
			'userBadges' => $this->getUserBadgeRepo()->findUserBadges($user->user_id)
		];

		return $this->view(
			'XF:Member\Badges\TakeAway',
			Addon::prefix('take_away_badge'),
			$viewParams
		);
	}

	/**
	 * @param \OzzModz\Badges\XF\Entity\User|XF\Entity\User $user
	 * @return XF\Mvc\FormAction
	 */
	protected function userBanSaveProcess(\XF\Entity\User $user)
	{
		$form = parent::userBanSaveProcess($user);

		if ($user->canTakeAwayBadges() && $this->filter('ozzmodz_badges_unaward', 'bool'))
		{
			$form->complete(function () use ($user) {
				$this->app()->jobManager()->enqueueAutoBlocking(
					Addon::shortName('DeleteUserBadges'),
					['user_id' => $user->user_id]
				);
			});
		}

		return $form;
	}

	//
	// UTIL
	//

	/**
	 * @return XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\UserBadge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	protected function getUserBadgeRepo()
	{
		return $this->repository(Addon::shortName('UserBadge'));
	}

	/**
	 * @return XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\Badge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	protected function getBadgeRepo()
	{
		return $this->repository(Addon::shortName('Badge'));
	}

	/**
	 * @param $id
	 * @param null $with
	 * @return XF\Mvc\Entity\Entity|\OzzModz\Badges\Entity\UserBadge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 * @throws XF\Mvc\Reply\Exception
	 */
	public function assertUserBadgeExists($id, $with = null)
	{
		return $this->assertRecordExists(Addon::shortName('UserBadge'), $id, $with);
	}
}