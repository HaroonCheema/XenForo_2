<?php

namespace FS\LatestThread\Option;
use  XF\Option\AbstractOption;

class Prefix extends AbstractOption
{
	public static function renderSelect(\XF\Entity\Option $option, array $htmlParams)
	{
		$data = self::getSelectData($option, $htmlParams);

		return self::getTemplater()->formSelectRow(
			$data['controlOptions'], $data['choices'], $data['rowOptions']
		);
	}

	public static function renderSelectMultiple(\XF\Entity\Option $option, array $htmlParams)
	{
		$data = self::getSelectData($option, $htmlParams);
		$data['controlOptions']['multiple'] = true;
		$data['controlOptions']['size'] = 8;

		return self::getTemplater()->formSelectRow(
			$data['controlOptions'], $data['choices'], $data['rowOptions']
		);
	}

	protected static function getSelectData(\XF\Entity\Option $option, array $htmlParams)
	{
		/** @var \XF\Repository\UserGroup $userGroupRepo */
		$userGroupRepo = \XF::repository('XF:ThreadPrefix');

		$choices = $userGroupRepo->getVisiblePrefixListData();
		$choices=self::getPrefixOptionsData($choices['prefixGroups']);



		

		return [
			'choices' => $choices,
			'controlOptions' => self::getControlOptions($option, $htmlParams),
			'rowOptions' => self::getRowOptions($option, $htmlParams)
		];
	}

	public static function getPrefixOptionsData($prefixGroups)
	{
		$choices = [];


		

		foreach ($prefixGroups AS $groupId => $label)
		{
		
			$choices[$groupId] = [
				'value' => $groupId,
				'label' => !($groupId)?"(Ungrouped)":\XF::phrase('thread_prefix_group.'.$groupId)
			];

		}

		return $choices;
	}


}