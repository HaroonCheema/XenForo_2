<?php

namespace Siropu\AdsManager\Option;

class AdvertiserUserGroups extends \XF\Option\AbstractOption
{
	public static function renderSelectMultiple(\XF\Entity\Option $option, array $htmlParams)
	{
		$userGroups = \XF::repository('XF:UserGroup')
			->findUserGroupsForList()
			->where('user_group_id', '<>', [1, 2, 3, 4])
			->fetch()
			->pluckNamed('title', 'user_group_id');

		if (!$userGroups)
          {
			return self::getTemplate('admin:siropu_ads_manager_option_template_no_choices', $option, $htmlParams, [
				'message' => \XF::phrase('siropu_ads_manager_no_custom_user_groups')
			]);
          }

		$choices = [];

		foreach ($userGroups AS $userGroupId => $label)
		{
			$choices[$userGroupId] = [
				'value' => $userGroupId,
				'label' => \XF::escapeString($label)
			];
		}

		$controlOptions = self::getControlOptions($option, $htmlParams);
		$controlOptions['multiple'] = true;
		$controlOptions['size'] = 8;

		return self::getTemplater()->formSelectRow(
			$controlOptions, $choices, self::getRowOptions($option, $htmlParams)
		);
	}
}
