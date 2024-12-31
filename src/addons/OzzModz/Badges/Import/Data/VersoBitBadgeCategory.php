<?php


namespace OzzModz\Badges\Import\Data;


use OzzModz\Badges\Addon;

class VersoBitBadgeCategory extends \XF\Import\Data\AbstractEmulatedData
{
	protected $title = null;

	public function getImportType()
	{
		return 'badge_category';
	}

	protected function getEntityShortName()
	{
		return Addon::shortName('BadgeCategory');
	}

	/**
	 * @return null
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param null $title
	 */
	public function setTitle($title): void
	{
		$this->title = $title;
	}

	protected function preSave($oldId)
	{
		if ($this->title === null)
		{
			throw new \LogicException("Must call setTitle with a non-null value to save a item category");
		}
	}

	protected function postSave($oldId, $newId)
	{
		$this->insertMasterPhrase('ozzmodz_badges_badge_category_title.' . $newId, $this->title);
	}
}