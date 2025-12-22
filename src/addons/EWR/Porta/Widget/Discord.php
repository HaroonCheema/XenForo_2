<?php

namespace EWR\Porta\Widget;

class Discord extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
		'height' => 400,
		'advanced_mode' => false,
	];
	
	public function render()
	{
		return $this->renderer('widget_EWRporta_discord');
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'server' => 'str',
			'height' => 'uint',
			'advanced_mode' => 'bool',
		]);
		
		return true;
	}
}