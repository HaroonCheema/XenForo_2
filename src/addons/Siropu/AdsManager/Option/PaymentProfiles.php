<?php

namespace Siropu\AdsManager\Option;

class PaymentProfiles extends \XF\Option\AbstractOption
{
	public static function renderCheckMultiple(\XF\Entity\Option $option, array $htmlParams)
	{
		$paymentProfiles = \XF::repository('XF:Payment')
			->findPaymentProfilesForList()
			->fetch();

		$profiles = [];

		foreach ($paymentProfiles as $profile)
		{
			$profiles[$profile->payment_profile_id] = $profile->title;
		}

		return self::getCheckboxRow($option, $htmlParams, $profiles);
	}
}
