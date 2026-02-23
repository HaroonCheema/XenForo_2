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
			$params['categories'] = $this->finder('XF:Node')->where('node_type_id', 'Category')->fetch();
		}
		return $params;
	}

	public function render()
	{
		$visitor = \XF::visitor();
		$options = $this->options;
		$nodeIds = $options['node_ids'];

		// Step 1: Fetch all nodes once (to build the tree without N+1 queries)
		$allNodes = $this->finder('XF:Node')->fetch();

		// Step 2: Get category nodes
		$nodeFinder = $this->finder('XF:Node')->where('node_type_id', 'Category');

		if ($nodeIds && !in_array(0, $nodeIds)) {
			$nodeFinder->where('node_id', $nodeIds);
		}

		$categories = $nodeFinder->fetch();

		// Step 3: Build a parent->children map from ALL nodes
		$childrenMap = [];
		foreach ($allNodes as $node) {
			$childrenMap[$node->parent_node_id][] = $node->node_id;
		}

		// Step 4: For each category, recursively get ALL descendant node IDs
		// then find max last_post_date from xf_thread for those descendants
		$db = \XF::db();

		$categoryScores = [];

		foreach ($categories as $category) {
			// Recursively collect all descendant node IDs
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

		// Step 5: Sort categories by their max last_post_date ascending
		$categoriesArray = $categories->toArray();

		uasort($categoriesArray, function ($a, $b) use ($categoryScores) {
			return $categoryScores[$a->node_id] <=> $categoryScores[$b->node_id];
			// For descending (newest first), swap $a and $b:
			// return $categoryScores[$b->node_id] <=> $categoryScores[$a->node_id];
		});

		$viewParams = [
			'nodes'  => $categoriesArray,
			'title'  => $this->getTitle(),
			'style'  => $this->options['style'],
		];

		return $this->renderer('widget_show_all_states', $viewParams);
	}

	/**
	 * Recursively collect all descendant node IDs for a given parent node ID.
	 */
	protected function getAllDescendantNodeIds(int $parentId, array $childrenMap): array
	{
		$ids = [];

		if (empty($childrenMap[$parentId])) {
			return $ids;
		}

		foreach ($childrenMap[$parentId] as $childId) {
			$ids[] = $childId;
			// Recurse into this child's children
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
