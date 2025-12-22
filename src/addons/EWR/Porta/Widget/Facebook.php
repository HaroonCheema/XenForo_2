<?php

namespace EWR\Porta\Widget;

class Facebook extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
		'height' => 400,
		'hide_cover' => false,
		'show_facepile' => true,
		'hide_cta' => false,
		'small_header' => false,
		'advanced_mode' => false,
	];
	
	public function render()
	{
		return $this->renderer('widget_EWRporta_facebook');
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'href' => 'str',
			'height' => 'uint',
			'small_header' => 'bool',
			'hide_cover' => 'bool',
			'hide_cta' => 'bool',
			'show_facepile' => 'bool',
			'advanced_mode' => 'bool',
		]);
		return true;
	}
}