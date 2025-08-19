<?php

namespace Siropu\AdsManager\Option;

class CustomAdSizes extends \XF\Option\AbstractOption
{
	public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
	{
		$choices = [];

		foreach ($option->option_value AS $size)
		{
			$choices[] = [
				'width'  => $size['width'],
				'height' => $size['height']
			];
		}

		return self::getTemplate('admin:siropu_ads_manager_option_template_customAdSizes', $option, $htmlParams, [
			'choices'     => $choices,
			'nextCounter' => count($choices)
		]);
	}
	public static function verifyOption(array &$value)
	{
		foreach ($value AS $key => $val)
		{
			if (empty(intval($val['width'])) || empty(intval($val['height'])))
			{
				unset($value[$key]);
			}
		}

		return true;
	}
}
