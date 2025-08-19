<?php

namespace Siropu\AdsManager\Option;

class AllowedResourceCategories extends \XF\Option\AbstractOption
{
	public static function renderSelectMultiple(\XF\Entity\Option $option, array $htmlParams)
	{
		if (!\XF::em()->find('XF:AddOn', 'XFRM'))
          {
			return self::getTemplate('admin:siropu_ads_manager_option_template_no_choices', $option, $htmlParams, [
				'message' => \XF::phrase('siropu_ads_manager_xfrm_not_installed')
			]);
          }

		$controlOptions = self::getControlOptions($option, $htmlParams);
		$controlOptions['multiple'] = true;
		$controlOptions['size'] = 8;

		$choices = [];

		$categoryRepo = \XF::repository('XFRM:Category');
		$categories = $categoryRepo->findCategoryList()->fetch();
		$categoryTree = $categoryRepo->createCategoryTree($categories);

		foreach ($categoryTree->getFlattened() as $entry)
		{
			$category = $entry['record'];

			if ($entry['depth'])
			{
				$prefix = str_repeat('--', $entry['depth']) . ' ';
			}
			else
			{
				$prefix = '';
			}

			$choices[$category->resource_category_id] = [
				'value' => $category->resource_category_id,
				'label' => $prefix . \XF::escapeString($category->title)
			];
		}

		return self::getTemplater()->formSelectRow(
			$controlOptions, $choices, self::getRowOptions($option, $htmlParams)
		);
	}
}
