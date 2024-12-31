<?php


namespace OzzModz\Badges\Import\Data;


use OzzModz\Badges\Addon;

class BdMedal extends \XF\Import\Data\AbstractEmulatedData
{
	protected $title = null;
	protected $description = null;
	protected $altDescription = null;

	public function getImportType()
	{
		return 'badge';
	}

	protected function getEntityShortName()
	{
		return Addon::shortName('Badge');
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

	/**
	 * @return null
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return null
	 */
	public function getAltDescription()
	{
		return $this->altDescription;
	}

	/**
	 * @param null $description
	 */
	public function setDescription($description): void
	{
		$this->description = $description;
	}

	/**
	 * @param null $altDescription
	 */
	public function setAltDescription($altDescription): void
	{
		$this->altDescription = $altDescription;
	}

	protected function preSave($oldId)
	{
		if ($this->title === null)
		{
			throw new \LogicException('Must call setTitle with a non-null value to save a item category');
		}

		if ($this->description === null)
		{
			throw new \LogicException('Must call setDescription with a non-null value to save a item category');
		}
	}

	protected function postSave($oldId, $newId)
	{
		$this->insertMasterPhrase('ozzmodz_badges_badge_title.' . $newId, $this->title);
		$this->insertMasterPhrase('ozzmodz_badges_badge_description.' . $newId, $this->description);
		$this->insertMasterPhrase('ozzmodz_badges_badge_alt_description.' . $newId, $this->altDescription);
	}
}