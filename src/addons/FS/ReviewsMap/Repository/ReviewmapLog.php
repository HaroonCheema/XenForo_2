<?php

namespace FS\ReviewsMap\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class ReviewmapLog extends Repository
{
	/**
	 * @return Finder
	 */
	public function findReviewmapLogsForList()
	{
		return $this->finder('FS\ReviewsMap:ReviewmapLog')->setDefaultOrder('reviewmap_id', 'DESC');
	}

	/**
	 * @return \FS\ReciewsMap\Entity\ReviewmapLog
	 */
	public function getActiveSitemap()
	{
		return $this->finder('FS\ReviewsMap:ReviewmapLog')->where('is_active', 1)->order('reviewmap_id', 'desc')->fetchOne();
	}

	public function getAbstractedSitemapFileName($fileSet, $fileNumber, $compressed = false, $temp = false)
	{
		$fileSet = intval($fileSet);
		$fileNumber = intval($fileNumber);

		$tempPrefix = $temp ? 'temp-' : '';
		if ($temp) {
			$compressed = false;
		}
		$compressedSuffixed = $compressed ? '.gz' : '';

		return "internal-data://reviewmaps/{$tempPrefix}reviewmap-{$fileSet}-{$fileNumber}.xml{$compressedSuffixed}";
	}

	public function logPendingBuild($id, $entryCount, $fileCount, $compressed)
	{
		$reviewmapLog = $this->em->find('FS\ReviewsMap:ReviewmapLog', $id);
		if (!$reviewmapLog) {
			$reviewmapLog = $this->em->create('FS\ReviewsMap:ReviewmapLog');
			$reviewmapLog->reviewmap_id = $id;
		}

		$reviewmapLog->is_active = 0;
		$reviewmapLog->is_compressed = $compressed ? 1 : 0;
		$reviewmapLog->file_count = $fileCount;
		$reviewmapLog->entry_count = $entryCount;
		$reviewmapLog->complete_date = 0;

		$reviewmapLog->save();

		return $reviewmapLog;
	}

	public function logCompletedBuild($id, $entryCount, $fileCount, $compressed)
	{
		$reviewmapLog = $this->em->find('FS\ReviewsMap:ReviewmapLog', $id);
		if (!$reviewmapLog) {
			$reviewmapLog = $this->em->create('FS\ReviewsMap:ReviewmapLog');
			$reviewmapLog->reviewmap_id = $id;
		}

		$reviewmapLog->is_active = 1;
		$reviewmapLog->is_compressed = $compressed ? 1 : 0;
		$reviewmapLog->file_count = $fileCount;
		$reviewmapLog->entry_count = $entryCount;
		$reviewmapLog->complete_date = time();

		$reviewmapLog->save();

		return $reviewmapLog;
	}

	public function deactivateOldSitemaps($skipId = null)
	{
		$finder = $this->finder('FS\ReviewsMap:ReviewmapLog')->where('is_active', 1);
		if ($skipId) {
			$finder->where('reviewmap_id', '<>', $skipId);
		}

		/** @var \FS\ReciewsMap\Entity\ReviewmapLog $reviewmapLog */
		foreach ($finder->fetch() as $reviewmapLog) {
			$reviewmapLog->is_active = 0;
			$reviewmapLog->save();
		}
	}

	public function deleteOldSitemapLogs($cutOff = null)
	{
		$cutOff = $cutOff ?: \XF::$time - 86400 * 60;
		return $this->db()->delete('fs_reviewmap', 'reviewmap_id < ? AND is_active = 0', $cutOff);
	}

	/**
	 * @return \XF\Sitemap\AbstractHandler[]
	 */
	public function getSitemapHandlers()
	{
		$handlers = [];

		foreach (\XF::app()->getContentTypeField('sitemap_handler_class') as $contentType => $handlerClass) {
			if (class_exists($handlerClass)) {
				$handlerClass = \XF::extendClass($handlerClass);
				$handlers[$contentType] = new $handlerClass($contentType, $this->app());
			}
		}

		return $handlers;
	}

	/**
	 * @param string $type
	 * @param bool $throw
	 *
	 * @return \XF\Sitemap\AbstractHandler|null
	 */
	public function getSitemapHandler($type, $throw = false)
	{
		$handlerClass = $this->app()->getContentTypeFieldValue($type, 'sitemap_handler_class');
		if (!$handlerClass) {
			if ($throw) {
				throw new \InvalidArgumentException("No sitemap handler for '$type'");
			}
			return null;
		}

		if (!class_exists($handlerClass)) {
			if ($throw) {
				throw new \InvalidArgumentException("Reviewmap handler for '$type' does not exist: $handlerClass");
			}
			return null;
		}

		$handlerClass = \XF::extendClass($handlerClass);
		return new $handlerClass($type, $this->app());
	}

	public function getSitemapContentTypes($includeExcluded = false)
	{
		$types = [];
		// $excluded = $this->options()->sitemapExclude;

		// foreach (\XF::app()->getContentTypeField('sitemap_handler_class') as $type => $class) {
		// 	if (empty($excluded[$type]) || $includeExcluded) {
		// 		if (!class_exists($class)) {
		// 			continue;
		// 		}

		// 		$types[$type] = $class;
		// 	}
		// }

		$types = [
			'sc_category' => 'XenAddons\Showcase\Sitemap\Category',
			'sc_item' => 'XenAddons\Showcase\Sitemap\Item',
			'thread' => 'XF\Sitemap\Thread'
		];

		return $types;
	}
}
