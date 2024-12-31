<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Entity;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $badge_id
 * @property array $user_criteria
 * @property int $badge_category_id
 * @property int $badge_tier_id
 * @property string $icon_type
 * @property string $fa_icon
 * @property string $mdi_icon
 * @property string $html_icon
 * @property string $image_url
 * @property string $image_url_2x
 * @property string $image_url_3x
 * @property string $image_url_4x
 * @property string $class
 * @property string $badge_link
 * @property array|null $badge_link_attributes
 * @property int $awarded_number
 * @property bool $is_repetitive
 * @property int $repeat_delay
 * @property bool $is_revoked
 * @property bool $is_manually_awarded
 * @property int $stacking_badge_id
 * @property int $display_order
 * @property bool $active
 *
 * RELATIONS
 * @property BadgeCategory $Category
 * @property BadgeTier $Tier
 * @property Badge $StackingBadge
 */
class Badge extends TitleDescEntity
{
	public function canView()
	{
		return $this->active;
	}

	public function isAwardable()
	{
		return $this->active && $this->is_manually_awarded;
	}

	public function isUnawardable()
	{
		return $this->is_manually_awarded || empty($this->user_criteria) || $this->is_repetitive;
	}

	// ################################## HELPERS ###########################################

	public function rebuildAwardedNumber($autoSave = true)
	{
		$this->awarded_number = $this->finder(Addon::shortName('UserBadge'))
			->where('badge_id', $this->badge_id)
			->total();

		if ($autoSave)
		{
			$this->saveIfChanged();
		}
	}

	protected function rebuildBadgesCache()
	{
		\XF::runOnce('ozzmodz_badges_badgeCacheRebuild', function () {
			$this->getBadgeRepo()->rebuildBadgesCache();
		});
	}

	public static function getPrePhrase(): string
	{
		return Addon::prefix('badge');
	}

	/**
	 * @return \XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\Badge
	 */
	protected function getBadgeRepo()
	{
		return $this->repository(Addon::shortName('Badge'));
	}

	// ################################## LIFE CYCLE ###########################################

	protected function _postSave()
	{
		parent::_postSave();

		if ($this->hasChanges())
		{
			$this->rebuildBadgesCache();
		}

		// Stack the main badge with itself
		if ($this->StackingBadge && $this->isChanged('stacking_badge_id'))
		{
			$this->StackingBadge->fastUpdate('stacking_badge_id', $this->stacking_badge_id);
		}
	}

	protected function _postDelete()
	{
		parent::_postDelete();

		$this->db()->delete('xf_user_alert', "content_type = 'ozzmodz_badges_badge' AND action = 'award'");

		$this->app()->jobManager()->enqueueUnique(
			'badgeDelete' . $this->badge_id,
			Addon::shortName('DeleteUserBadges'),
			['badge_id' => $this->badge_id],
			false
		);

		$this->rebuildBadgesCache();
	}

	/**
	 * @param \XF\Api\Result\EntityResult $result
	 * @param $verbosity
	 * @param array $options
	 * @return void
	 *
	 * @api-out string $title
	 * @api-out string $description
	 */
	protected function setupApiResultData(
		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
	)
	{
		if (!empty($options['with_category']))
		{
			$result->includeRelation('Category');
		}

		if (!empty($options['with_tier']))
		{
			$result->includeRelation('Tier');
		}

		$result->title = $this->title;
		$result->description = $this->description;
	}

	// ################################## STRUCTURE ###########################################

	public static function getStructure(Structure $structure)
	{
		$structure->table = Addon::table('badge');
		$structure->shortName = Addon::shortName('Badge');
		$structure->primaryKey = 'badge_id';
		$structure->contentType = 'ozzmodz_badges_badge';

		$structure->columns = [
			'badge_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true, 'api' => true],
			'badge_category_id' => ['type' => self::UINT, 'api' => true],
			'badge_tier_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'user_criteria' => ['type' => self::JSON_ARRAY, 'default' => [], 'api' => true],
			'icon_type' => ['type' => self::STR, 'allowedValues' => ['fa', 'mdi', 'image', 'asset', 'html'], 'api' => true],
			'fa_icon' => ['type' => self::STR, 'maxLength' => 256, 'default' => '', 'api' => true],
			'mdi_icon'  => ['type' => self::STR, 'maxLength' => 256, 'default' => '', 'api' => true],
			'html_icon' => ['type' => self::STR, 'maxLength' => 65535, 'default' => '', 'api' => true],
			'image_url' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'image_url_2x' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'image_url_3x' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'image_url_4x' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'class' => ['type' => self::STR, 'maxLength' => 256, 'default' => '', 'api' => true],
			'badge_link' => ['type' => self::STR, 'default' => '', 'api' => true],
			'badge_link_attributes' => ['type' => self::JSON_ARRAY, 'default' => [], 'nullable' => true, 'api' => true],

			'awarded_number' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'is_repetitive' => ['type' => self::BOOL, 'default' => false, 'api' => true],
			'repeat_delay' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'is_revoked' => ['type' => self::BOOL, 'default' => false, 'api' => true],
			'is_manually_awarded' => ['type' => self::BOOL, 'default' => false, 'api' => true],

			'stacking_badge_id' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'display_order' => ['type' => self::UINT, 'default' => 10, 'api' => true],
			'active' => ['type' => self::BOOL, 'default' => true, 'api' => true]
		];

		$structure->relations = [
			'Category' => [
				'type' => self::TO_ONE,
				'entity' => Addon::shortName('BadgeCategory'),
				'conditions' => 'badge_category_id'
			],
			'Tier' => [
				'type' => self::TO_ONE,
				'entity' => Addon::shortName('BadgeTier'),
				'conditions' => 'badge_tier_id'
			],
			'StackingBadge' => [
				'type' => self::TO_ONE,
				'entity' => Addon::shortName('Badge'),
				'conditions' => [['badge_id', '=', '$stacking_badge_id']]
			]
		];

		$structure->withAliases = [
			'full' => [
				'Category',
				'Tier',
				'StackingBadge'
			]
		];

		parent::addTitleDescStructureElements($structure);

		return $structure;
	}
}