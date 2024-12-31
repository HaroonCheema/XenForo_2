<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\XF\Entity;

use OzzModz\Badges\Addon;
use OzzModz\Badges\Entity\Badge;
use XF;
use XF\Mvc\Entity\AbstractCollection;

/**
 * COLUMNS
 * @property int $ozzmodz_badges_badge_count
 * @property array $ozzmodz_badges_tier_counts
 * @property array $ozzmodz_badges_cache
 * @property array $ozzmodz_badges_received_badge_ids
 * @property int $ozzmodz_badges_last_award_date
 *
 * GETTERS
 * @property int $badge_count
 * @property array $cached_badges
 * @property array $cached_featured_badges
 * @property AbstractCollection|Badge[] $featured_badges
 * @property AbstractCollection|Badge[] $recent_badges
 *
 * RELATIONS
 * @property AbstractCollection|Badge[] $Badges
 */
class User extends XFCP_User
{
	//
	// GETTERS
	//

	public function hasOzzModzBadges($badgeIds, $requireAll = false)
	{
		if ($badgeIds instanceof Badge)
		{
			$badgeIds = [$badgeIds->badge_id];
		}

		if (!$badgeIds)
		{
			return false;
		}

		if (!$this->ozzmodz_badges_received_badge_ids)
		{
			return false;
		}

		$returnValue = false;
		foreach ($badgeIds as $badgeId)
		{
			if (in_array($badgeId, $this->ozzmodz_badges_received_badge_ids))
			{
				$returnValue = true;
				if (!$requireAll)
				{
					break;
				}
			}
			else
			{
				$returnValue = false;
			}
		}

		return $returnValue;
	}


	public function getCachedBadges()
	{
		$userBadgeCache = $this->ozzmodz_badges_cache;
		if (!$userBadgeCache)
		{
			return [];
		}

		$app = $this->app();
		if ($app->offsetExists('ozzmodz_badges.badges'))
		{
			$badgeCache = $app->container('ozzmodz_badges.badges');
		}
		else
		{
			$badgeCache = [];
		}

		$userBadges = [];
		foreach ($userBadgeCache as $badgeData)
		{
			$userBadges[] = $badgeData + [
					'Badge' => $badgeCache[$badgeData['badge_id']]
				];
		}

		return $userBadges;
	}

	public function getCachedFeaturedBadges()
	{
		$userBadgeCache = $this->getCachedBadges();
		if (!$userBadgeCache)
		{
			return [];
		}

		return array_filter($userBadgeCache, function ($userBadge) {
			return $userBadge['featured'] == true;
		});
	}

	public function getCachedBadgeTiers()
	{
		$tierCounts = $this->ozzmodz_badges_tier_counts;
		if (!$tierCounts)
		{
			return [];
		}

		$app = $this->app();
		if ($app->offsetExists('ozzmodz_badges.tiers'))
		{
			$tierCache = $app->container('ozzmodz_badges.tiers');
		}
		else
		{
			$tierCache = [];
		}

		$userTiers = [];
		foreach ($tierCounts as $tierId => $tierCount)
		{
			if (!isset($tierCache[$tierId]))
			{
				continue;
			}

			$userTiers[] = [
				'count' => $tierCount,
				'Tier' => $tierCache[$tierId]
			];
		}

		return $userTiers;
	}

	public function getBadgeCount()
	{
		return $this->finder(Addon::shortName('UserBadge'))->where('user_id', $this->user_id)->total();
	}

	public function getFeaturedBadges()
	{
		return $this->getOzzModzBadgesUserBadgeRepo()->getFeaturedUserBadges($this);
	}

	public function getRecentBadges()
	{
		return $this->getOzzModzBadgesUserBadgeRepo()->getRecentUserBadges($this);
	}

	public function rebuildBadgeCache($autoSave = true)
	{
		$this->setOption('ozzmodzBadgesForceFeaturedStacking', true);

		$userBadges = $this->getFeaturedBadges();
		if ($userBadges->count() <= 0)
		{
			$userBadges = $this->getRecentBadges();
		}

		if ($userBadges)
		{
			$options = $this->app()->options();
			$badgeCache = [];

			/** @var \OzzModz\Badges\Entity\UserBadge $userBadge */
			foreach ($userBadges as $userBadge)
			{
				$stackedBadges = $userBadge->StackedUserBadges;
				$stackedCount = $stackedBadges->count();

				$addBadgeData = function (\OzzModz\Badges\Entity\UserBadge $userBadge) use (
					$options,
					$stackedCount
				) {
					$badgeData = [
						'badge_id' => $userBadge->badge_id,
						'award_date' => $userBadge->award_date,
						'featured' => $userBadge->featured ?: $userBadge->getOption('force_as_featured')
					];
					if ($options->ozzmodz_badges_cacheAwardReason)
					{
						$badgeData['reason'] = $userBadge->reason;
					}

					if ($options->ozzmodz_badges_cacheStackedCount && $stackedCount)
					{
						$badgeData['stacked_count'] = $stackedCount;
					}

					return $badgeData;
				};

				$badgeData = $addBadgeData($userBadge);
				$badgeCache[$userBadge->user_badge_id] = $badgeData;
			}

			$this->ozzmodz_badges_cache = $badgeCache;
		}
		else
		{
			$this->ozzmodz_badges_cache = [];
		}

		if ($autoSave)
		{
			$this->saveIfChanged();
		}
	}

	public function rebuildReceivedBadgeIds($autoSave = true)
	{
		$this->ozzmodz_badges_received_badge_ids = $this->db()->fetchAllColumn("
			SELECT DISTINCT badge_id
			FROM xf_ozzmodz_badges_user_badge
			WHERE user_id = ?
		", $this->user_id);

		if ($autoSave)
		{
			$this->saveIfChanged();
		}
	}

	public function rebuildBadgeTierCounts($autoSave = true)
	{
		$tiers = $this->db()->fetchPairs("
			SELECT badge.badge_tier_id, COUNT(*)
			FROM `xf_ozzmodz_badges_user_badge` AS userBadge
			INNER JOIN `xf_ozzmodz_badges_badge` AS badge
				ON userBadge.badge_id = badge.badge_id
            INNER JOIN `xf_ozzmodz_badges_badge_tier` AS badgeTier
            	ON badge.badge_tier_id = badgeTier.badge_tier_id
			WHERE userBadge.user_id = ?
			GROUP BY badge.badge_tier_id;
		", $this->user_id);

		$cache = [];
		foreach ($tiers as $tier => $count)
		{
			$cache[$tier] = $count;
		}

		$this->ozzmodz_badges_tier_counts = $cache;

		if ($autoSave)
		{
			$this->saveIfChanged();
		}
	}

	//
	// PERMISSIONS
	//

	public function canViewBadgesTab(XF\Entity\User $user = null)
	{
		if (!$user)
		{
			$user = XF::visitor();
		}

		if ($this->user_id === $user->user_id)
		{
			return true;
		}

		return $this->hasPermission(Addon::prefix(), 'viewOthersTab');
	}

	public function canViewAwardedBadgesList()
	{
		return $this->hasPermission(Addon::prefix(), 'viewAwardedList');
	}

	public function getAllowedFeaturedBadges()
	{
		return $this->hasPermission(Addon::prefix(), 'featuredNumber');
	}

	/**
	 * @param User|XF\Entity\User|null $user
	 * @param Badge|null $badge
	 * @return false|mixed
	 */
	public function canAwardWithBadge(XF\Entity\User $user = null, Badge $badge = null)
	{
		$visitor = XF::visitor();

		if (!$this->user_id)
		{
			return false;
		}

		if ($user && $badge)
		{
			$awardedIds = $this->getOzzModzBadgesUserBadgeRepo()->getAwardedNonRepetitiveBadgeIds($user->user_id);
			if (!$badge->is_repetitive && in_array($badge->badge_id, $awardedIds))
			{
				return false;
			}

			if (!$badge->isAwardable())
			{
				return false;
			}
		}

		return $visitor->hasPermission(Addon::prefix(), 'award');
	}

	public function canTakeAwayBadges(&$error = null)
	{
		$visitor = XF::visitor();
		if (!$this->ozzmodz_badges_badge_count)
		{
			return false;
		}

		return $visitor->hasPermission(Addon::prefix(), 'takeAway');
	}

	//
	// UTIL
	//

	/**
	 * @return XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\UserBadge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	public function getOzzModzBadgesUserBadgeRepo()
	{
		return $this->repository(Addon::shortName('UserBadge'));
	}
}