<?php

namespace FS\ReviewsMap\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int reviewmap_id
 * @property bool is_active
 * @property int file_count
 * @property int entry_count
 * @property bool is_compressed
 * @property int complete_date
 */
class ReviewmapLog extends Entity
{
	public function getAbstractedSitemapFileName($fileNumber)
	{
		/** @var \FS\ReviewsMap\Repository\SitemapLog $sitemapRepo */
		$sitemapRepo = $this->repository('FS\ReviewsMap:ReviewmapLog');
		return $sitemapRepo->getAbstractedSitemapFileName($this->reviewmap_id, $fileNumber, $this->is_compressed);
	}

	protected function _postSave()
	{
		if ($this->isUpdate() && $this->is_active == false && $this->getPreviousValue('is_active') == true) {
			$this->removeSitemapFiles();
		}
	}

	protected function _postDelete()
	{
		if ($this->is_active) {
			$this->removeSitemapFiles();
		}
	}

	protected function removeSitemapFiles()
	{
		for ($i = 1; $i <= $this->file_count; $i++) {
			\XF\Util\File::deleteFromAbstractedPath($this->getAbstractedSitemapFileName($i));
		}
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'fs_reviewmap';
		$structure->shortName = 'FS\ReviewsMap:ReviewmapLog';
		$structure->primaryKey = 'reviewmap_id';
		$structure->columns = [
			'reviewmap_id' => ['type' => self::UINT, 'required' => true],
			'is_active' => ['type' => self::BOOL, 'required' => true],
			'file_count' => ['type' => self::UINT],
			'entry_count' => ['type' => self::UINT],
			'is_compressed' => ['type' => self::BOOL],
			'complete_date' => ['type' => self::UINT, 'default' => \XF::$time]
		];
		$structure->getters = [];
		$structure->relations = [];

		return $structure;
	}
}
