<?php

namespace XB\ArticleThreadUrl;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################ INSTALLATION ####################

	/**
	 *
	 */
	public function installStep1(): void
	{
		$sm = $this->schemaManager();

		\XF::db()->insertBulk('xf_route_filter', [
			[
				'prefix' => 'threads',
				'find_route' => 'threads/',
				'replace_route' => 'article/',
				'enabled' => 1,
				'url_to_route_only' => 0
			]
		], false, false, 'IGNORE');

		/** @var \XF\Repository\RouteFilter $repo */
		$repo = \XF::repository('XF:RouteFilter');
		\XF::runOnce('routeFilterCachesRebuild', function () use ($repo) {
			$repo->rebuildRouteFilterCache();
		});
	}

	// ################################ UNINSTALL ####################

	/**
	 *
	 */
	public function uninstallStep1(): void
	{
		$sm = $this->schemaManager();

		$routeFilter = \XF::app()->finder('XF:RouteFilter')->where('find_route', 'threads/')->where('replace_route', 'article/')->where('prefix', 'threads')->fetchOne();

		if ($routeFilter) {
			$routeFilter->delete();
		}
	}
}
