<?php

namespace EWR\Porta\Widget;

class Features extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
		'mode' => 'fade',
		'speed' => 1000,
		'auto' => 20000,
		'pager' => true,
		'controls' => true,
		'autoControls' => true,
		'progress' => true,
		'limit' => 5,
		'trim' => 200,
		'category' => false,
		'author' => false,
		'pages' => false,
	];
	
	public function render()
	{
		$options = $this->options;
		$featureRepo = $this->app->repository('EWR\Porta:Feature');
		$entries = $featureRepo->findFeature()->limit($options['limit'])
			->where('Thread.discussion_state', 'visible');
		
		if (!$options['pages'] && $this->contextParams['page'] > 1)
		{
			return false;
		}
		
		if (!empty($this->contextParams['category']))
		{
			if ($options['category'])
			{
				$entries->with('CatLink')->where('CatLink.category_id', $this->contextParams['category']->category_id);
			}
			else
			{
				return false;
			}
		}
		
		if (!empty($this->contextParams['author']))
		{
			if ($options['author'])
			{
				$entries->with('Thread')->where('Thread.user_id', $this->contextParams['author']->user_id);
			}
			else
			{
				return false;
			}
		}
		
		if (!$features = $entries->fetch())
		{
			return false;
		}
		
		$viewParams = [
			'features' => $featureRepo->parseFeatures($features),
		];
		
		return $this->renderer('widget_EWRporta_features', $viewParams);
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'relocate' => 'str',
			'mode' => 'str',
			'speed' => 'uint',
			'auto' => 'uint',
			'pager' => 'bool',
			'controls' => 'bool',
			'autoControls' => 'bool',
			'progress' => 'bool',
			'limit' => 'uint',
			'trim' => 'uint',
			'category' => 'bool',
			'author' => 'bool',
			'pages' => 'bool',
		]);
		
		if ($options['limit'] < 1)
		{
			$options['limit'] = 1;
		}
		
		return true;
	}
}