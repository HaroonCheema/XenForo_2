<?php

namespace XenAddons\Showcase\Repository;

use XF\Repository\AbstractField;

class ReviewField extends AbstractField
{
	protected function getRegistryKey()
	{
		return 'xa_scReviewFields';
	}

	protected function getClassIdentifier()
	{
		return 'XenAddons\Showcase:ReviewField';
	}

	public function getDisplayGroups()
	{
		return [
			'top' => \XF::phrase('xa_sc_top_below_rating'),
			'middle' => \XF::phrase('xa_sc_middle_above_review'),
			'bottom' => \XF::phrase('xa_sc_bottom_below_review'),
			'self_place' => \XF::phrase('xa_sc_self_placement'),
		];
	}
}