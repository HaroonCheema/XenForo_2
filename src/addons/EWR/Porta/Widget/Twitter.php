<?php

namespace EWR\Porta\Widget;

class Twitter extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
		'height' => 400,
		'chrome' => [
			'noheader' => 'noheader',
			'nofooter' => 'nofooter',
			'noborders' => 'noborders',
			'transparent' => 'transparent',
		],
		'advanced_mode' => false,
	];
	
	public function render()
	{
		$this->options['chrome'] = implode(' ', $this->options['chrome']);
		
		return $this->renderer('widget_EWRporta_twitter');
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'widget_id' => 'str',
			'search' => 'str',
			'related' => 'str',
			'height' => 'uint',
			'chrome' => 'array',
			'advanced_mode' => 'bool',
		]);
		return true;
	}
}