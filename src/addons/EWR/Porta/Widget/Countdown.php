<?php

namespace EWR\Porta\Widget;

class Countdown extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
		'date' => '1577854800',
		'time' => '00:00',
		'zone' => 'Europe/London',
	];

	protected function getDefaultTemplateParams($context)
	{
		$params = parent::getDefaultTemplateParams($context);
		if ($context == 'options')
		{
			$tzData = $this->app->data('XF:TimeZone');
			$params['timeZones'] = $tzData->getTimeZoneOptions();
		}
		return $params;
	}
	
	public function render()
	{
		return $this->renderer('widget_EWRporta_countdown');
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'date' => 'datetime',
			'time' => 'str',
			'zone' => 'str',
			'active' => 'str',
			'inactive' => 'str',
		]);
		
		list ($hour, $min) = explode(':', $options['time']);
		$dateTime = new \DateTime('@'.$options['date']);
		$dateTime->setTimeZone(new \DateTimeZone($options['zone']));
		$dateTime->setTime($hour, $min);
		$options['datetime'] = $dateTime->getTimestamp() . '000';
		
		return true;
	}
}