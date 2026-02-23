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

		$nodeFinder = $this->finder('XF:Node')->where('node_type_id', 'Category');


		if ($nodeIds && !in_array(0, $nodeIds)) {
			$nodeFinder->where('node_id', $nodeIds);
		}


		$viewParams = [
			'nodes' => $nodeFinder->fetch(),
			'title' => $this->getTitle(),
			'style' => $this->options['style'],
		];
		return $this->renderer('widget_show_all_states', $viewParams);
	}

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
