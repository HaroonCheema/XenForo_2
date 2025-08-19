<?php

namespace Siropu\AdsManager\Option;

class FeaturedResourcePrefix extends \XF\Option\AbstractOption
{
	public static function renderSelect(\XF\Entity\Option $option, array $htmlParams)
	{
          if (!\XF::em()->find('XF:AddOn', 'XFRM'))
          {
			return self::getTemplate('admin:siropu_ads_manager_option_template_no_choices', $option, $htmlParams, [
				'message' => \XF::phrase('siropu_ads_manager_xfrm_not_installed')
			]);
          }

		$prefixes = [\XF::phrase('(none)')];

		$prefixes += \XF::repository('XFRM:ResourcePrefix')
			->findPrefixesForList()
			->fetch()
			->pluckNamed('title', 'prefix_id');

		return self::getSelectRow($option, $htmlParams, $prefixes);
	}
}
