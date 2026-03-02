<?php

namespace FS\AllStates\Widget;

use XF\Http\Request;
use XF\Phrase;
use XF\Widget\AbstractWidget;
use XF\Widget\WidgetRenderer;
use function array_slice,
	count,
	in_array;

class State extends AbstractWidget
{

	protected $defaultOptions = [
		'node_ids' => []
	];

	protected function getDefaultTemplateParams($context)
	{
		$params = parent::getDefaultTemplateParams($context);
		if ($context == 'options') {
			$catFinder = $this->finder('XF:Node')->where('node_type_id', 'Category')->where('parent_node_id', 0);

			$options = \XF::options();

			$catIds = explode(',', $options->fs_stats_exclude_cat_ids);

			if ($catIds) {
				$catFinder->where('node_id', '!=', $catIds);
			}

			$params['categories'] = $catFinder->fetch();
		}
		return $params;
	}

	public function render()
	{
		$visitor = \XF::visitor();
		$options = $this->options;
		$nodeIds = $options['node_ids'];

		$allNodes = $this->finder('XF:Node')->fetch();

		$options = \XF::options();

		$catIds = explode(',', $options->fs_stats_exclude_cat_ids);

		$nodeFinder = $this->finder('XF:Node')->where('node_type_id', 'Category')->where('parent_node_id', 0);

		if ($catIds) {
			$nodeFinder->where('node_id', '!=', $catIds);
		}

		if ($nodeIds && !in_array(0, $nodeIds)) {
			$nodeFinder->where('node_id', $nodeIds);
		}

		$categories = $nodeFinder->fetch();

		$childrenMap = [];
		foreach ($allNodes as $node) {
			$childrenMap[$node->parent_node_id][] = $node->node_id;
		}

		$db = \XF::db();

		$categoryScores = [];

		foreach ($categories as $category) {
			$descendantIds = $this->getAllDescendantNodeIds($category->node_id, $childrenMap);

			if (empty($descendantIds)) {
				$categoryScores[$category->node_id] = 0;
				continue;
			}

			$placeholders = implode(',', array_fill(0, count($descendantIds), '?'));

			$maxLastPost = $db->fetchOne(
				"SELECT MAX(last_post_date) 
             FROM xf_thread 
             WHERE node_id IN ($placeholders)
             AND discussion_state = 'visible'",
				$descendantIds
			);

			$categoryScores[$category->node_id] = (int)($maxLastPost ?? 0);
		}

		$categoriesArray = $categories->toArray();

		uasort($categoriesArray, function ($a, $b) use ($categoryScores) {
			return $categoryScores[$a->node_id] <=> $categoryScores[$b->node_id];
		});

		$viewParams = [
			'nodes'  => $categoriesArray,
			'title'  => $this->getTitle(),
			'style'  => $this->options['style'],
		];

		return $this->renderer('widget_show_all_states', $viewParams);
	}


	protected function getAllDescendantNodeIds(int $parentId, array $childrenMap): array
	{
		$ids = [];

		if (empty($childrenMap[$parentId])) {
			return $ids;
		}

		foreach ($childrenMap[$parentId] as $childId) {
			$ids[] = $childId;
			$ids = array_merge($ids, $this->getAllDescendantNodeIds($childId, $childrenMap));
		}

		return $ids;
	}


	// public function render()
	// {

	// 	$visitor = \XF::visitor();
	// 	$options = $this->options;
	// 	$nodeIds = $options['node_ids'];

	// 	$nodeFinder = $this->finder('XF:Node')->where('display_in_list', 1)->where('node_type_id', 'Category');


	// 	if ($nodeIds && !in_array(0, $nodeIds)) {
	// 		$nodeFinder->where('node_id', $nodeIds);
	// 	}


	// 	$viewParams = [
	// 		'nodes' => $nodeFinder->order('node_id')->fetch(),
	// 		'title' => $this->getTitle(),
	// 		'style' => $this->options['style'],
	// 	];
	// 	return $this->renderer('widget_show_all_states', $viewParams);
	// }

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'node_ids' => 'array-uint'
		]);
		if (in_array(0, $options['node_ids'])) {
			$options['node_ids'] = [0];
		}

		return true;
	}
}
