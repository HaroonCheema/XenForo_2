<?php

namespace Siropu\AdsManager\Option;

class ExcludePages extends \XF\Option\AbstractOption
{
	public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
	{
		return self::getTemplate('admin:siropu_ads_manager_option_template_excludePages', $option, $htmlParams, [
			'choices' => $option->option_value
		]);
	}
	public static function verifyOption(array &$value)
	{
		foreach ($value AS $key => $val)
		{
			if (empty($val))
			{
				unset($value[$key]);
			}
		}

		return true;
	}
}
