<?php

namespace OzzModz\Badges;


use XF\Mvc\Entity\Entity;

/**
 * Class Listener
 *
 * @package OzzModz\Badges
 */
class Listener
{
	/**
	 * Fired inside the importers container in the Import sub-container. Add-ons can use this to add
	 * additional importer classes to the importer list. The class names can be fully qualified or the
	 * short class version e.g. AddOn:ClassName.
	 *
	 * @param \XF\SubContainer\Import $container Import sub-container object.
	 * @param \XF\Container $parentContainer Global App object.
	 * @param array $importers Array of importers.
	 */
	public static function importImporterClasses(\XF\SubContainer\Import $container, \XF\Container $parentContainer, array &$importers)
	{
		$importers[] = Addon::shortName('VersoBitBadges');
		$importers[] = Addon::shortName('BdMedals');
	}

	/**
	 * Called after the global \XF\App object has been setup. This will fire regardless of the
	 * application type.
	 *
	 * @param \XF\App $app Global App object.
	 */
	public static function appSetup(\XF\App $app)
	{
		$container = $app->container();

		$container['ozzmodz_badges.badges'] = $app->fromRegistry('ozzmodz_badges_badge', function (\XF\Container $c) {
			/** @var \OzzModz\Badges\Repository\Badge $serverRepo */
			$serverRepo = $c['em']->getRepository(Addon::shortName('Badge'));
			return $serverRepo->rebuildBadgesCache();
		});

		$container['ozzmodz_badges.tiers'] = $app->fromRegistry('ozzmodz_badges_tiers', function (\XF\Container $c) {
			/** @var \OzzModz\Badges\Repository\BadgeTier $repo */
			$repo = $c['em']->getRepository(Addon::shortName('BadgeTier'));
			return $repo->rebuildBadgeTiersCache();
		});
	}

	/**
	 * Called before rendering the helper_criteria template to allow adding additional view params to
	 * the criteria form.
	 *
	 * @param array $templateData The array of data passed to the helper_criteria_template.
	 */
	public static function criteriaTemplateData(array &$templateData)
	{
		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = \XF::repository('OzzModz\Badges:Badge');
		$templateData['ozzModzBadges'] = $badgeRepo->getBadgesOptionsData(false);
	}


	/**
	 * Called while testing a user against user criteria in \XF\Criteria\User::isMatch() for trophies,
	 * notices etc.
	 *
	 * @param string $rule Text identifying the criteria that should be
	 *                                     checked.
	 * @param array $data Data defining the conditions of the criteria.
	 * @param \XF\Entity\User $user User entity object to be used in the criteria
	 *                                     checks.
	 * @param bool $returnValue The event code should set this to true if a criteria
	 *                                     check matches.
	 */
	public static function criteriaUser(string $rule, array $data, \XF\Entity\User $user, bool &$returnValue)
	{
		/** @var \OzzModz\Badges\XF\Entity\User $user */

		switch ($rule)
		{
			case Addon::prefix('badge_count'):
				$returnValue = $user->ozzmodz_badges_badge_count && $user->ozzmodz_badges_badge_count >= $data['badges'];
				break;
			case Addon::prefix('badge_count_max'):
				$returnValue = $user->ozzmodz_badges_badge_count && $user->ozzmodz_badges_badge_count <= $data['badges'];
				break;
			case Addon::prefix('has_badge'):
				$returnValue = false;

				if (isset($data['badge_ids']))
				{
					if (is_array($data['badge_ids']))
					{
						$badgeIds = $data['badge_ids'];
					}
					else // Legacy format
					{
						$badgeIds = explode(',', $data['badge_ids']);
					}

					$returnValue = $user->hasOzzModzBadges($badgeIds);
				}

				break;
			case Addon::prefix('has_no_badge'):
				$returnValue = true;
				if (isset($data['badge_ids']) && is_array($data['badge_ids']))
				{
					$returnValue = !$user->hasOzzModzBadges($data['badge_ids']);
				}

				break;
			case Addon::prefix('not_awarded_days'):
				if (!$user->user_id || !$user->ozzmodz_badges_last_award_date)
				{
					$returnValue = false;
				}

				$daysInactive = floor((time() - $user->ozzmodz_badges_last_award_date) / 86400);
				if ($daysInactive < $data['days'])
				{
					$returnValue = false;
				}

				$returnValue = true;
				break;
		}
	}

	/**
	 * Allows direct modification of the Entity structure.
	 *
	 * Event hint: Fully qualified name of the root class that was called.
	 *
	 * @param \XF\Mvc\Entity\Manager $em Entity Manager object.
	 * @param \XF\Mvc\Entity\Structure $structure Entity Structure object.
	 */
	public static function userEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
	{
		$structure->columns['ozzmodz_badges_badge_count'] = ['type' => Entity::UINT, 'default' => 0, 'changeLog' => false];
		$structure->columns['ozzmodz_badges_tier_counts'] = ['type' => Entity::JSON_ARRAY, 'default' => [], 'changeLog' => false, 'nullable' => true];
		$structure->columns['ozzmodz_badges_cache'] = ['type' => Entity::JSON_ARRAY, 'default' => [], 'changeLog' => false, 'nullable' => true];
		$structure->columns['ozzmodz_badges_received_badge_ids'] = ['type' => Entity::LIST_COMMA, 'default' => null, 'changeLog' => false, 'nullable' => true];
		$structure->columns['ozzmodz_badges_last_award_date'] = ['type' => Entity::UINT, 'default' => 0, 'changeLog' => false];

		$structure->getters += [
			'badge_count' => true,
			'cached_badges' => true,
			'cached_featured_badges' => true,
			'featured_badges' => true,
			'recent_badges' => true,
		];

		$structure->relations['Badges'] = [
			'entity' => Addon::shortName('UserBadge'),
			'type' => Entity::TO_MANY,
			'conditions' => [
				['user_id', '=', '$user_id']
			],
			'key' => 'user_badge_id'
		];

		// Key for finder
		$structure->relations['BadgesBadge'] = [
			'entity' => Addon::shortName('UserBadge'),
			'type' => Entity::TO_MANY,
			'conditions' => [
				['user_id', '=', '$user_id']
			],
			'key' => 'badge_id'
		];

		$structure->options['ozzmodzBadgesForceFeaturedStacking'] = false;
	}

	/**
	 * Event fires after the Entity specific _postDelete() method is called and after the post delete
	 * of any behaviors.
	 *
	 * Event hint: Fully qualified name of the root class that was called.
	 *
	 * @param Entity $entity Entity object.
	 */
	public static function userEntityPostDelete(Entity $entity)
	{
		$db = \XF::db();

		/** @var \XF\Entity\User $entity */
		$userId = $entity->user_id;

		$db->delete(Addon::table('user_badge'), 'user_id = ?', $userId);
	}

	/**
	 * Allows direct modification of the Entity structure.
	 *
	 * Event hint: Fully qualified name of the root class that was called.
	 *
	 * @param \XF\Mvc\Entity\Manager $em Entity Manager object.
	 * @param \XF\Mvc\Entity\Structure $structure Entity Structure object.
	 */
	public static function userOptionEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
	{
		$structure->columns['ozzmodz_badges_email_on_award'] = ['type' => Entity::BOOL, 'default' => true];
	}

	/**
	 * Called at the end of the the Public \XF\Pub\App object startup process.
	 *
	 * @param \XF\Pub\App $app Public App object.
	 */
	public static function appPubStartEnd(\XF\Pub\App $app)
	{
		/** @var \OzzModz\Badges\XF\Entity\User $visitor */
		$visitor = \XF::visitor();
		if ($visitor->user_id)
		{
			$updateInterval = $app->options()->ozzmodz_badges_badgeUpdateSessonInterval;

			if ($updateInterval)
			{
				$session = $app->session();
				if ($session->ozzmodzBadgesChecked + $updateInterval < \XF::$time)
				{
					$session->ozzmodzBadgesChecked = \XF::$time;

					/** @var \OzzModz\Badges\Repository\UserBadge $userBadgeRepo */
					$userBadgeRepo = $app->repository(Addon::shortName('UserBadge'));
					$userBadgeRepo->queueUserBadgeUpdateAndRunUpdateJob($visitor);
				}
			}
		}
	}
}
