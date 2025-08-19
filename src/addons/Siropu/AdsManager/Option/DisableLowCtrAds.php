<?php

namespace Siropu\AdsManager\Option;

class DisableLowCtrAds extends \XF\Option\AbstractOption
{
	public static function verifyOption(array &$value)
	{
		if (isset($value['ctr']) && empty(intval($value['ctr'])) || isset($value['days']) && empty(intval($value['days'])))
		{
			$value['enabled'] = '';
			$value['ctr']     = '';
			$value['days']    = '';
		}

		return true;
	}
}
