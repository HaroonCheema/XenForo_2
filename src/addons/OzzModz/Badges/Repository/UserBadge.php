<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Repository;

use OzzModz\Badges\Addon;
use XF;
use XF\Entity\User;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Repository;


class UserBadge extends Repository
{
	/**
	 * @param $userId
	 * @return \OzzModz\Badges\Finder\UserBadge|\XF\Mvc\Entity\Finder
	 */
	public function findUserBadges($userId = null)
	{
		/** @var \OzzModz\Badges\Finder\UserBadge $userBadgeFinder */
		$userBadgeFinder = $this->finder(Addon::shortName('UserBadge'));
		if ($userId !== null)
		{
			$userBadgeFinder->where('user_id', $userId);
		}

		return $userBadgeFinder->setDefaultOrder('award_date', 'DESC');
	}

	/**
	 * @param \OzzModz\Badges\XF\Entity\User $user
	 * @return XF\Mvc\Entity\AbstractCollection
	 */
	public function getRecentUserBadges(User $user)
	{
		$sortColumn = $this->options()->ozzmodz_badges_featuredDefaultOrder;
		$sortDirection = $this->options()->ozzmodz_badges_featuredDefaultDirection;

		if ($sortColumn == 'Badge.display_order')
		{
			$sortColumn = ['Badge.Category.display_order', 'Badge.display_order'];
		}

		$finder = $this->findUserBadges($user->user_id)
			->with('full')
			->order($sortColumn, $sortDirection);

		$userBadges = $finder->fetch();
		$userBadges = $this->mergeStackedBadgesIntoUserBadges($userBadges);

		$allowedFeatured = $user->getAllowedFeaturedBadges();
		if ($allowedFeatured && $allowedFeatured != -1)
		{
			$userBadges = $userBadges->slice(0, $allowedFeatured);
		}

		return $userBadges;
	}

	/**
	 * @param \OzzModz\Badges\XF\Entity\User $user
	 * @return XF\Mvc\Entity\AbstractCollection|ArrayCollection
	 */
	public function getFeaturedUserBadges(User $user)
	{
		$allowedFeatured = $user->getAllowedFeaturedBadges();
		if ($allowedFeatured === 0)
		{
			return new ArrayCollection([]);
		}

		$sortColumn = $this->options()->ozzmodz_badges_featuredDefaultOrder;
		$sortDirection = $this->options()->ozzmodz_badges_featuredDefaultDirection;

		if ($sortColumn == 'Badge.display_order')
		{
			$sortColumn = ['Badge.Category.display_order', 'Badge.display_order'];
		}

		$finder = $this->findUserBadges($user->user_id);

		if ($this->options()->ozzmodz_badges_stackingForceFeature)
		{
			$finder->whereOr(
				['featured', '=', 1],
				[['Badge.stacking_badge_id', '=', 0], ['featured', '=', 1]],
				[['Badge.stacking_badge_id', '!=', 0], ['featured', '=', 0]],
			);
		}
		else
		{
			$finder->where('featured', '=', 1);
		}

		$finder->with('full')->order($sortColumn, $sortDirection);

		$userBadges = $finder->fetch();

		$userBadges = $this->mergeStackedBadgesIntoUserBadges($userBadges);

		if ($this->options()->ozzmodz_badges_stackingForceFeature)
		{
			$userBadges = $userBadges->filter(function (\OzzModz\Badges\Entity\UserBadge $userBadge) use (&$allowedFeatured) {

				$stackedUserBadges = $userBadge->StackedUserBadges;
				foreach ($stackedUserBadges as $stackedUserBadge)
				{
					if ($stackedUserBadge->featured)
					{
						if ($allowedFeatured > -1)
						{
							$allowedFeatured++;
						}

						$userBadge->setOption('force_as_featured', true);
						return true;
					}
				}

				return $userBadge->featured || empty($stackedUserBadges);
			});
		}

		if ($allowedFeatured != -1)
		{
			$userBadges = $userBadges->slice(0, $allowedFeatured);
		}

		return $userBadges;
	}

	public function getAwardedBadgeIds(int $userId)
	{
		return $this->db()->fetchAllColumn("
			SELECT DISTINCT `badge_id` 
			FROM xf_ozzmodz_badges_user_badge
			WHERE `user_id` = ?
		", $userId);
	}

	public function getAwardedNonRepetitiveBadgeIds(int $userId)
	{
		return $this->db()->fetchAllColumn("
			SELECT DISTINCT ub.`badge_id` FROM xf_ozzmodz_badges_user_badge AS ub
			INNER JOIN xf_ozzmodz_badges_badge AS b
				ON ub.`badge_id` = b.`badge_id`
			WHERE ub.`user_id` = ? AND b.`is_repetitive` = 0
		", $userId);
	}

	public function getUserBadgesListData(AbstractCollection $userBadges)
	{
		$badgeCategories = [];
		$userBadgesOut = [];
		$badgeIds = [];

		/** @var \OzzModz\Badges\Entity\UserBadge $userBadge */
		foreach ($userBadges as $userBadge)
		{
			$badge = $userBadge->Badge;
			if (!$badge || !$badge->canView())
			{
				continue;
			}

			$badgeIds[] = $badge->badge_id;

			$category = $badge->Category;
			$catId = $category ? $category->badge_category_id : 0;
			$userBadgeId = $userBadge->getEntityId();

			if (!array_key_exists($catId, $userBadgesOut))
			{
				$badgeCategories[$catId] = $category ?: $this->getBadgeCategoryRepo()->getDefaultCategory();
				$userBadgesOut[$catId] = [];
			}

			$userBadgesOut[$catId][$userBadgeId] = $userBadge;
		}

		uasort($badgeCategories, function ($a, $b) {
			return $a->display_order <=> $b->display_order;
		});

		return [
			'badgeCategories' => $badgeCategories,
			'userBadges' => $userBadgesOut,
			'totalCategories' => count($badgeCategories),
			'totalBadges' => count($userBadges),
			'badgeIds' => $badgeIds
		];
	}

	public function mergeStackedBadgesIntoUserBadges(AbstractCollection $userBadges)
	{
		$badgeCache = $this->app()->container('ozzmodz_badges.badges');

		$stackedUserBadgeMap = []; // ['parent_badge_id' => ['child_user_badge_ids']]

		$userBadgesArray = $userBadges->toArray();
		if ($this->options()->ozzmodz_badges_stackingSortDisplayOrder)
		{
			usort($userBadgesArray, function ($item1, $item2) {

				if (empty($item1['Badge']) || empty($item2['Badge']))
				{
					return 0;
				}

				return $item1['Badge']['display_order'] <=> $item2['Badge']['display_order'];
			});
		}

		foreach ($userBadgesArray as $userBadgeArray)
		{
			// Collect all children
			if (isset($badgeCache[$userBadgeArray['badge_id']]))
			{
				$stackingBadgeId = $badgeCache[$userBadgeArray['badge_id']]['stacking_badge_id'] ?? 0;
				if ($stackingBadgeId)
				{
					$stackedUserBadgeMap[$stackingBadgeId][$userBadgeArray['user_badge_id']] = $userBadgeArray;
				}
			}
		}

		$userBadgesToRemove = [];

		/** @var \OzzModz\Badges\Entity\UserBadge $userBadge */
		foreach ($userBadges as $userBadge)
		{
			if (!$userBadge->Badge)
			{
				continue;
			}

			// Add all stacked badges to the last badge
			$children = $stackedUserBadgeMap[$userBadge->Badge->stacking_badge_id] ?? null;
			if ($children)
			{
				/** @var \OzzModz\Badges\Entity\UserBadge $lastStackedBadge */
				$lastStackedBadge = end($children);

				unset($children[$lastStackedBadge->user_badge_id]);

				if ($userBadge->user_badge_id == $lastStackedBadge->user_badge_id)
				{
					$stackedBadges = new ArrayCollection($children);
					$userBadge->setStackedUserBadges($stackedBadges);
					continue;
				}

				// Remove except last stacked badge
				$userBadgesToRemove = array_merge($userBadgesToRemove, array_keys($children));
			}
		}

		return $userBadges->filter(function (\OzzModz\Badges\Entity\UserBadge $userBadge) use ($userBadgesToRemove) {

			return !in_array($userBadge->user_badge_id, $userBadgesToRemove);
		});
	}

	public function getUserBadgeCount(int $userId, bool $featured = false)
	{
		$finder = $this->findUserBadges($userId);

		if ($featured)
		{
			$finder->where('featured', 1);
		}

		return $finder->total();
	}

	public function queueUserBadgeUpdateAndRunUpdateJob(User $user)
	{
		$this->db()->insert(
			'xf_ozzmodz_badges_user_badge_update',
			['user_id' => $user->user_id, 'queue_date' => \XF::$time],
			false,
			false,
			'IGNORE'
		);

		$this->app()->jobManager()->enqueueUnique(
			'userBadgeUpdateQueue',
			'OzzModz\Badges:UserBadgeUpdateQueue',
			[],
			false
		);
	}

	/**
	 * @param \OzzModz\Badges\XF\Entity\User $user
	 * @param $userBadges
	 * @param $badges
	 * @return void
	 * @throws XF\PrintableException|XF\Db\Exception
	 */
	public function updateBadgesForUser(User $user, $userBadges = null, $badges = null)
	{
		if ($userBadges === null)
		{
			$userBadges = $this->findUserBadges($user->user_id)->useDisplayOrder()->fetch();
		}

		if ($badges === null)
		{
			/** @var Badge $badgeRepo */
			$badgeRepo = $this->repository(Addon::shortName('Badge'));
			$badges = $badgeRepo->findBadgesForList()->fetch();
		}

		/** @var \OzzModz\Badges\Entity\Badge $badge */
		foreach ($badges as $badge)
		{
			$this->updateBadgeForUser($user, $badge, $userBadges);
		}

		$this->refineFeaturedUserBadges($user, $userBadges);
	}

	/**
	 * @param \OzzModz\Badges\XF\Entity\User $user
	 * @param \OzzModz\Badges\Entity\Badge $badge
	 * @param \OzzModz\Badges\Entity\Badge[]|AbstractCollection $userBadges
	 * @return bool
	 * @throws XF\PrintableException
	 */
	public function updateBadgeForUser(User $user, \OzzModz\Badges\Entity\Badge $badge, AbstractCollection $userBadges)
	{
		if ($this->options()->ozzmodz_badges_debug)
		{
			$startTime = microtime(true);
		}

		$awarded = false;
		$deletedUserBadgeIds = [];

		/** @var \OzzModz\Badges\Entity\Badge[]|ArrayCollection $userBadges */
		if (!$badge->active)
		{
			return false;
		}

		$userCriteria = $this->app()->criteria('XF:User', $badge->user_criteria);
		$userCriteria->setMatchOnEmpty(false);

		$groupedUserBadges = $userBadges->groupBy('badge_id');

		if ($userCriteria->isMatched($user))
		{
			$canAward = true;

			if (!$badge->is_repetitive && isset($groupedUserBadges[$badge->badge_id]))
			{
				$canAward = false;
			}

			// Avoid race condition
			$existingUserBadgeAwardDate = $this->db()->fetchOne("
				SELECT award_date
				FROM xf_ozzmodz_badges_user_badge
				WHERE badge_id = ? AND user_id = ?
				ORDER BY award_date DESC
			", [$badge->badge_id, $user->user_id]);

			if ($existingUserBadgeAwardDate)
			{
				if (!$badge->is_repetitive)
				{
					$canAward = false;
				}
				elseif ($badge->repeat_delay)
				{
					$nextAwardTime = $existingUserBadgeAwardDate + $badge->repeat_delay * 3600;
					if ($nextAwardTime > \XF::$time)
					{
						$canAward = false;
					}
				}
			}

			if ($canAward)
			{
				/** @var \OzzModz\Badges\Service\Award $awardService */
				$awardService = $this->app()->service(Addon::shortName('Award'), $user, $badge);
				$awardService->setIsAutomated();

				if ($awardService->validate())
				{
					$awardService->save();
					$awarded = true;
				}
			}
		}
		elseif (!empty($badge->user_criteria) && $badge->is_revoked && isset($groupedUserBadges[$badge->badge_id]))
		{
			/** @var \OzzModz\Badges\Entity\UserBadge $badgeToDelete */
			foreach ($groupedUserBadges[$badge->badge_id] as $badgeToDelete)
			{
				if (!$badgeToDelete->is_manually_awarded)
				{
					$deletedUserBadgeIds[] = $badgeToDelete->user_badge_id;
					$badgeToDelete->delete();
				}
			}
		}

		if ($this->options()->ozzmodz_badges_debug)
		{
			/** @noinspection PhpUndefinedVariableInspection */
			$time = microtime(true) - $startTime;

			\XF::logError(sprintf(
				'Updating badge %s for %s. Awarded: %s. Revoked: %s. Time: %ss',
				$badge->badge_id,
				$user->username,
				$awarded ? 'yes' : 'no',
				count($deletedUserBadgeIds),
				number_format($time, 4)
			));
		}

		return $awarded;
	}

	/**
	 * @param \OzzModz\Badges\XF\Entity\User $user
	 * @param AbstractCollection $userBadges
	 * @return void
	 * @throws XF\Db\Exception
	 */
	public function refineFeaturedUserBadges(User $user, AbstractCollection $userBadges)
	{
		$featuredBadges = $user->getFeaturedBadges();
		if (!$featuredBadges->count())
		{
			return;
		}

		$featuredUserBadgeKeys = $featuredBadges->keys();
		$toUnfeature = $userBadges->filter(function (\OzzModz\Badges\Entity\UserBadge $userBadge) use ($featuredUserBadgeKeys) {
			return $userBadge->featured && !in_array($userBadge->user_badge_id, $featuredUserBadgeKeys);
		});

		if ($toUnfeature->count())
		{
			$this->fastUnfeatureUserBadges($user, $toUnfeature->keys());
		}
	}

	/**
	 * @param \OzzModz\Badges\XF\Entity\User $user
	 * @param array $userBadgeIds
	 * @return void
	 * @throws XF\Db\Exception
	 */
	public function fastUnfeatureUserBadges(User $user, array $userBadgeIds = [])
	{
		$db = $this->db();
		$quotedUserBadgeIds = $db->quote($userBadgeIds);

		$db->query('
			UPDATE xf_ozzmodz_badges_user_badge AS userBadge
			INNER JOIN xf_ozzmodz_badges_badge AS badge
				ON userBadge.badge_id = badge.badge_id
			SET userBadge.featured = 0
			WHERE userBadge.user_id = ?
			 	AND userBadge.user_badge_id IN (' . $quotedUserBadgeIds . ')
				AND badge.stacking_badge_id = 0
		', [
			$user->user_id
		]);

		$user->rebuildBadgeCache();
	}

	//
	// UTIL
	//

	/**
	 * @return Repository|BadgeCategory
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	protected function getBadgeCategoryRepo()
	{
		return $this->repository(Addon::shortName('BadgeCategory'));
	}
}