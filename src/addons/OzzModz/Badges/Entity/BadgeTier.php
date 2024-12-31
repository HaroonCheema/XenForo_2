<?php

namespace OzzModz\Badges\Entity;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $badge_tier_id
 * @property string $color
 * @property string $css
 * @property int $display_order
 */
class BadgeTier extends TitleEntity
{
	protected function verifyCss(&$css)
	{
		$css = trim($css);
		if (!strlen($css))
		{
			return true;
		}

		$parser = new \Less_Parser();
		try
		{
			$parser->parse('.example { ' . $css . '}')->getCss();
		} catch (\Exception $e)
		{
			$this->error(\XF::phrase('please_enter_valid_user_name_css_rules'), 'css');
			return false;
		}

		return true;
	}

	public static function getPrePhrase(): string
	{
		return Addon::prefix('badge_tier');
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

	// ################################## LIFECYCLE ###########################################

	protected function _postSave()
	{
		parent::_postSave();

		if ($this->isChanged('color') || $this->isChanged('css'))
		{
			$this->rebuildCache();
		}
	}

	protected function _postDelete()
	{
		parent::_postDelete();

		$this->rebuildCache();
	}

	protected function rebuildCache()
	{
		$repo = $this->getBadgeTierRepo();

		\XF::runOnce('ozzmodz_badges_badgeTierRebuild', function () use ($repo) {
			$repo->rebuildBadgeTiersCache();
		});
	}

	/**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_ozzmodz_badges_badge_tier';
        $structure->shortName = 'OzzModz\Badges:BadgeTier';
        $structure->primaryKey = 'badge_tier_id';
        $structure->columns = [
            'badge_tier_id' => ['type' => static::UINT, 'autoIncrement' => true, 'api' => true],
			'color' => ['type' => static::STR, 'maxLength' => 255, 'required' => true, 'api' => true],
            'css' => ['type' => static::STR, 'maxLength' => 65535, 'default' => '', 'api' => true],
            'display_order' => ['type' => static::UINT, 'default' => '0', 'api' => true],
        ];

		self::addTitleStructureElements($structure);

        return $structure;
    }

	/**
	 * @return \XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\BadgeTier
	 */
	protected function getBadgeTierRepo()
	{
		return $this->repository(Addon::shortName('BadgeTier'));
	}
}