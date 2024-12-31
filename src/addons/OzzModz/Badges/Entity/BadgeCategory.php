<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Entity;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null $badge_category_id
 * @property string $icon_type
 * @property string $fa_icon
 * @property string $mdi_icon
 * @property string $image_url
 * @property string $image_url_2x
 * @property string $image_url_3x
 * @property string $image_url_4x
 * @property string $class
 * @property int $display_order
 *
 * RELATIONS
 * @property AbstractCollection|Badge[] $Badges
 */
class BadgeCategory extends TitleEntity
{
	// ################################## HELPERS ###########################################

	public static function getPrePhrase(): string
	{
		return Addon::prefix('badge_category');
	}

	/**
	 * @param \XF\Api\Result\EntityResult $result
	 * @param $verbosity
	 * @param array $options
	 * @return void
	 *
	 * @api-out string $title
	 */
	protected function setupApiResultData(
		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
	)
	{
		$result->title = $this->title;
	}

	// ################################## LIFE CYCLE ###########################################

	protected function _postDelete()
	{
		parent::_postDelete();

		$this->db()->update(
			Addon::table('badge'),
			['badge_category_id' => 0],
			'badge_category_id = ?',
			$this->badge_category_id
		);
	}

	// ################################## STRUCTURE ###########################################

	public static function getStructure(Structure $structure)
	{
		$structure->table = Addon::table('badge_category');
		$structure->shortName = Addon::shortName('BadgeCategory');
		$structure->primaryKey = 'badge_category_id';

		$structure->columns = [
			'badge_category_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true, 'api' => true],
			'icon_type' => ['type' => self::STR, 'default' => '', 'allowedValues' => ['', 'fa', 'mdi', 'image', 'asset'], 'api' => true],
			'fa_icon' => ['type' => self::STR, 'maxLength' => 256, 'default' => '', 'api' => true],
			'mdi_icon' => ['type' => self::STR, 'maxLength' => 256, 'default' => '', 'api' => true],
			'image_url' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'image_url_2x' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'image_url_3x' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'image_url_4x' => ['type' => self::STR, 'default' => '', 'maxLength' => 512, 'api' => true],
			'class' => ['type' => self::STR, 'maxLength' => 256, 'default' => '', 'api' => true],
			'display_order' => ['type' => self::UINT, 'default' => 10, 'api' => true]
		];

		$structure->relations = [
			'Badges' => [
				'entity' => Addon::shortName('Badge'),
				'type' => self::TO_MANY,
				'conditions' => [
					['badge_category_id', '=', '$badge_category_id']
				]
			]
		];

		parent::addTitleStructureElements($structure);

		return $structure;
	}
}