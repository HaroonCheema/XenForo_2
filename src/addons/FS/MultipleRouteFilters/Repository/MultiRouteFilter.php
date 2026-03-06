<?php

namespace FS\MultipleRouteFilters\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class MultiRouteFilter extends Repository
{
	/**
	 * @return Finder
	 */
	public function findRouteFiltersForList()
	{
		return $this->finder('FS\MultipleRouteFilters:MultiRouteFilter')->order(['route_filter_id']);
	}

	public function getRouteFilterCacheData()
	{
		/** @var \FS\MultipleRouteFilters\Finder\MultiRouteFilter $finder */
		$finder = $this->finder('FS\MultipleRouteFilters:MultiRouteFilter');

		$results = $finder->where('enabled', 1)
			->orderLength('replace_route')
			->fetch();

		$in = [];
		foreach ($results as $result) {
			$in[$result->route_filter_id] = [
				'find_route' => $result->find_route,
				'replace_route' => $result->replace_route
			];
		}

		$results = $finder->where('url_to_route_only', 0)
			->resetOrder()
			->orderLength('find_route')
			->order('prefix')
			->fetch();

		$out = [];
		foreach ($results as $result) {
			$out[$result->prefix][$result->route_filter_id] = [
				'find_route' => $result->find_route,
				'replace_route' => $result->replace_route
			];
		}

		return [
			'in' => $in,
			'out' => $out
		];
	}

	public function rebuildRouteFilterCache()
	{
		$caches = $this->getRouteFilterCacheData();
		// \XF::registry()->set('multiRouteFilters', $caches);

		return $caches;
	}
}
