<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Entity;

use OzzModz\Badges\Addon;
use XF;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $user_badge_id
 * @property int $user_id
 * @property int $awarding_user_id
 * @property bool $is_manually_awarded
 * @property int $badge_id
 * @property int $award_date
 * @property string $reason
 * @property bool $featured
 *
 * GETTERS
 * @property XF\Mvc\Entity\ArrayCollection|UserBadge[] $StackedUserBadges
 *
 * RELATIONS
 * @property \OzzModz\Badges\XF\Entity\User $User
 * @property \OzzModz\Badges\XF\Entity\User $AwardingUser
 * @property Badge $Badge
 */
class UserBadge extends Entity implements XF\Entity\LinkableInterface
{
	public function canEdit(&$error = null)
	{
		$visitor = XF::visitor();
		if (!$this->user_id)
		{
			return false;
		}

		return $visitor->hasPermission(Addon::prefix(), 'award');
	}

	public function canDelete(&$error = null)
	{
		/** @var \OzzModz\Badges\XF\Entity\User $visitor */
		$visitor = XF::visitor();
		return $visitor->hasPermission(Addon::prefix(), 'takeAway');
	}

	public function canManageFeatured(&$error = null)
	{
		if (!$this->User)
		{
			return false;
		}

		$visitor = XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		if ($this->user_id == $visitor->user_id)
		{
			if (!$this->User->hasPermission(Addon::prefix(), 'manageFeatured'))
			{
				$error = Addon::phrase('you_cant_feature_this_badge');
				return false;
			}
		}
		elseif (!$visitor->hasPermission(Addon::prefix(), 'manageAnyFeatured'))
		{
			$error = Addon::phrase('you_cant_feature_this_badge');
			return false;
		}

		return $this->User->getAllowedFeaturedBadges() != 0;
	}

	public function canAddFeatured(&$error = null)
	{
		if (!$this->canManageFeatured())
		{
			return false;
		}

		$user = $this->User;
		$featuredAllowed = $user->getAllowedFeaturedBadges();
		if ($featuredAllowed == -1)
		{
			return true;
		}

		$actualFeatured = $this->getUserBadgeRepo()->getUserBadgeCount($this->user_id, true);
		if ($actualFeatured > $featuredAllowed)
		{
			$error = Addon::phrase('you_cant_feature_more_than_x_badges', ['badgeCount' => $featuredAllowed]);
			return false;
		}

		return true;
	}

	public function getContentUrl(bool $canonical = false, array $extraParams = [], $hash = null)
	{
		return $this->app()->router('public')->buildLink('members', $this->User) . '#badges';
	}

	public function getContentPublicRoute()
	{
		return '';
	}

	public function getContentTitle(string $context = '')
	{
		return Addon::phrase('x_user_y_badge', [
			'title' => $this->Badge ? $this->Badge->title : '',
			'username' => $this->User ? $this->User->username : '',
		]);
	}

	public function canStack()
	{
		return $this->Badge && $this->Badge->stacking_badge_id == $this->badge_id;
	}

	public function getStackedUserBadges()
	{
		return $this->_getterCache['StackedUserBadges'] ?? new XF\Mvc\Entity\ArrayCollection([]);
	}

	public function setStackedUserBadges(XF\Mvc\Entity\ArrayCollection $userBadges)
	{
		$this->_getterCache['StackedUserBadges'] = $userBadges;
	}

	// ################################## LIFE CYCLE ###########################################

	protected function _postSave()
	{
		parent::_postSave();

		$user = $this->User;

		if ($user)
		{
			if ($this->isInsert())
			{
				$user->ozzmodz_badges_badge_count = $user->ozzmodz_badges_badge_count + 1;

				$badge = $this->Badge;
				if ($badge)
				{
					$badge->awarded_number = $badge->awarded_number + 1;
					$badge->save();
				}
			}

			if ($this->isInsert() || ($this->isUpdate() && $this->isChanged(['featured', 'reason'])))
			{
				$user->rebuildBadgeCache(false);
				$user->rebuildReceivedBadgeIds(false);
				$user->rebuildBadgeTierCounts(false);

				$user->ozzmodz_badges_last_award_date = XF::$time;
			}

			$user->save();
		}
	}

	protected function _postDelete()
	{
		parent::_postDelete();

		$user = $this->User;
		if ($user)
		{
			$user->rebuildBadgeCache(false);
			$user->rebuildReceivedBadgeIds(false);
			$user->rebuildBadgeTierCounts(false);

			$user->ozzmodz_badges_badge_count = max(0, $user->ozzmodz_badges_badge_count - 1);

			$badge = $this->Badge;
			if ($badge)
			{
				$badge->awarded_number = $badge->awarded_number - 1;
				$badge->saveIfChanged();
			}

			$user->save();
		}

		if (XF::isAddOnActive('DBTech/Credits'))
		{
			/** @var \DBTech\Credits\Repository\EventTrigger $eventTriggerRepo */
			$eventTriggerRepo = $this->repository('DBTech\Credits:EventTrigger');

			$eventTriggerRepo->getHandler('ozzmodz_badges_awarded')
				->undo($this->getEntityId(), [
					'timestamp' => XF::$time,
					'content_type' => $this->getEntityContentType(),
					'content_id' => $this->getEntityId(),
					'badge_id' => $this->badge_id
				], $this->User);
		}

		$this->db()->delete('xf_user_alert',
			'content_type = ? AND action = ? AND content_id = ?',
			['ozzmodz_badges_badge', 'award', $this->badge_id]
		);
	}


	/**
	 * @param XF\Api\Result\EntityResult $result
	 * @param $verbosity
	 * @param array $options
	 * @return void
	 *
	 * @api-out string $badge_title
	 */
	protected function setupApiResultData(
		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
	)
	{
		if (!empty($options['with_badge']))
		{
			$result->includeRelation('Badge');
		}

		if (!empty($options['with_user']))
		{
			$result->includeRelation('User');
		}

		$result->badge_title = $this->Badge ? $this->Badge->title : '';
	}

	// ################################## STRUCTURE ###########################################

	public static function getStructure(Structure $structure)
	{
		$structure->table = Addon::table('user_badge');
		$structure->shortName = Addon::shortName('UserBadge');
		$structure->primaryKey = 'user_badge_id';
		$structure->contentType = 'ozzmodz_badges_user_badge';

		$structure->columns = [
			'user_badge_id' => ['type' => self::UINT, 'autoIncrement' => true, 'api' => true],
			'user_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'awarding_user_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'is_manually_awarded' => ['type' => self::BOOL, 'default' => false, 'api' => true],
			'badge_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'award_date' => ['type' => self::UINT, 'default' => XF::$time, 'api' => true],
			'reason' => ['type' => self::STR, 'default' => '', 'api' => true],
			'featured' => ['type' => self::BOOL, 'default' => false, 'api' => true]
		];

		$structure->getters['StackedUserBadges'] = true;

		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			],
			'AwardingUser' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$awarding_user_id']],
				'primary' => true
			],
			'Badge' => [
				'entity' => Addon::shortName('Badge'),
				'type' => self::TO_ONE,
				'conditions' => 'badge_id',
				'primary' => true
			]
		];

		$structure->withAliases = [
			'full' => [
				'Badge',
				'Badge.Category',
				'Badge.Tier',
				'Badge.StackingBadge'
			]
		];

		$structure->defaultWith = ['User', 'Badge'];

		$structure->options = [
			'force_as_featured' => false
		];

		return $structure;
	}

	// ################################## UTIL ###########################################

	/**
	 * @return XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\UserBadge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	public function getUserBadgeRepo()
	{
		return $this->repository(Addon::shortName('UserBadge'));
	}
}