<?php

namespace FS\MultipleRouteFilters\Admin\Controller;

use XF\Http\Request;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Admin\Controller\AbstractController;

class MultiRouteFilter extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('option');
	}

	public function actionIndex()
	{
		$viewParams = [
			'routeFilters' => $this->getRouteFilterRepo()
				->findRouteFiltersForList()
				->fetch()
		];
		return $this->view('FS\MultipleRouteFilters:MultiRouteFilter\Listing', 'fs_multi_route_filter_list', $viewParams);
	}

	protected function routeFilterAddEdit(\FS\MultipleRouteFilters\Entity\MultiRouteFilter $routeFilter)
	{
		/** @var \XF\Mvc\Router $publicRouter */
		$publicRouter = $this->app->container('router.public');

		$fullIndex = $publicRouter->buildLink('full:index');
		$fullThreadLink = $publicRouter->buildLink('full:threads', ['thread_id' => 1, 'title' => 'example']);
		$routeValue = str_replace([$fullIndex, '?'], '', $fullThreadLink);

		$viewParams = [
			'routeFilter' => $routeFilter,
			'fullThreadLink' => $fullThreadLink,
			'routeValue' => $routeValue
		];
		return $this->view('FS\MultipleRouteFilters:MultiRouteFilter\Edit', 'fs_multi_route_filter_edit', $viewParams);
	}

	// public function actionEdit(ParameterBag $params)
	// {
	// 	$routeFilter = $this->assertRouteFilterExists($params['route_filter_id']);
	// 	return $this->routeFilterAddEdit($routeFilter);
	// }

	public function actionAdd()
	{
		$routeFilter = $this->em()->create('FS\MultipleRouteFilters:MultiRouteFilter');
		return $this->routeFilterAddEdit($routeFilter);
	}

	protected function routeFilterSaveProcess(\FS\MultipleRouteFilters\Entity\MultiRouteFilter $routeFilter)
	{
		$form = $this->formAction();

		$input = $this->filter([
			'find_route' => 'str',
			'replace_route' => 'str',
			'url_to_route_only' => 'str',
			// 'enabled' => 'bool'
		]);
		$form->basicEntitySave($routeFilter, $input);

		return $form;
	}

	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		if ($params['route_filter_id']) {
			$routeFilter = $this->assertRouteFilterExists($params['route_filter_id']);
		} else {
			$routeFilter = $this->em()->create('FS\MultipleRouteFilters:MultiRouteFilter');
		}

		$this->routeFilterSaveProcess($routeFilter)->run();

		$allRouteFilters = $this->getRouteFilterRepo()
			->findRouteFiltersForList()
			->fetch();

		$chainInfo = $this->findChainRoot($routeFilter, $allRouteFilters);

		$mainRoot = $chainInfo['root'];

		$MainRouteFilter = $mainRoot['MainRouteFilter'] ?? false;

		if (!$MainRouteFilter) {
			$MainRouteFilter = $this->finder('XF:RouteFilter')->where('find_route', $mainRoot->find_route)->where('prefix', $mainRoot->prefix)->fetchOne();

			if (!$MainRouteFilter) {
				$MainRouteFilter = $this->em()->create('XF:RouteFilter');
			}
		}

		$this->parentRouteFilterSaveProcess($MainRouteFilter, $mainRoot->find_route, $routeFilter->replace_route)->run();

		if (!$mainRoot['parent_route_filter_id']) {
			$mainRoot->bulkSet([
				'parent_route_filter_id' => $MainRouteFilter->route_filter_id
			]);
			$mainRoot->save();
		}

		$this->rebuildRouteFilterCaches();

		return $this->redirect($this->buildLink('multi-route-filters'));
	}

	protected function findChainRoot($savedFilter, $allRouteFilters)
	{
		$allFilters = $allRouteFilters->toArray();

		$replaceToFilter = [];
		foreach ($allFilters as $filter) {
			$replaceToFilter[$filter->replace_route] = $filter;
		}

		$chain = [];
		$current = $savedFilter;
		$visited = [];
		$maxSteps = 20;

		while ($current && count($visited) < $maxSteps) {
			$currentId = $current->route_filter_id;

			if (in_array($currentId, $visited)) {
				break;
			}

			array_unshift($chain, $current);
			$visited[] = $currentId;

			$findRoute = $current->find_route;
			$parent = isset($replaceToFilter[$findRoute])
				? $replaceToFilter[$findRoute]
				: null;

			if ($parent && $parent->route_filter_id !== $currentId) {
				$current = $parent;
			} else {
				break;
			}
		}

		$root = $chain[0];

		return [
			'root'         => $root,
			// 'root'         => $this->finder('FS\MultipleRouteFilters:MultiRouteFilter')->where('route_filter_id', $root->route_filter_id)->fetchOne(),
			'chain_length' => count($chain)
		];
	}

	protected function parentRouteFilterSaveProcess(\XF\Entity\RouteFilter $routeFilter, $findRoute, $replaceRoute)
	{
		$form = \xf::app()->formAction();

		$input = [
			'find_route' => $findRoute,
			'replace_route' => $replaceRoute,
			'url_to_route_only' => '',
			'enabled' => 'true'
		];
		$form->basicEntitySave($routeFilter, $input);

		return $form;
	}

	public function actionDelete(ParameterBag $params)
	{
		$routeFilter = $this->assertRouteFilterExists($params['route_filter_id']);

		/** @var \XF\ControllerPlugin\Delete $plugin */
		$plugin = $this->plugin('XF:Delete');

		if ($this->isPost() && ($routeFilter->MainRouteFilter != NULL)) {

			$routeFilter->MainRouteFilter->bulkSet([
				'enabled' => false
			]);
			$routeFilter->MainRouteFilter->save();

			$this->rebuildRouteFilterCaches();
		}

		return $plugin->actionDelete(
			$routeFilter,
			$this->buildLink('multi-route-filters/delete', $routeFilter),
			'',
			// $this->buildLink('multi-route-filters/edit', $routeFilter),
			$this->buildLink('multi-route-filters'),
			$routeFilter->find_route
		);
	}

	public function actionToggle()
	{
		/** @var \XF\ControllerPlugin\Toggle $plugin */
		$plugin = $this->plugin('XF:Toggle');
		return $plugin->actionToggle('FS\MultipleRouteFilters:MultiRouteFilter', 'enabled');
	}

	/**
	 * @param string $id
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \FS\MultipleRouteFilters\Entity\MultiRouteFilter
	 */
	protected function assertRouteFilterExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('FS\MultipleRouteFilters:MultiRouteFilter', $id, $with, $phraseKey);
	}

	/**
	 * @return \FS\MultipleRouteFilters\Repository\MultiRouteFilter
	 */
	protected function getRouteFilterRepo()
	{
		return $this->repository('FS\MultipleRouteFilters:MultiRouteFilter');
	}

	protected function rebuildRouteFilterCaches()
	{
		$repo = \XF::app()->repository('XF:RouteFilter');
		$repo->rebuildRouteFilterCache();
	}
}
