<?php

namespace XenAddons\Showcase\Repository;

use XF\Repository\AbstractField;

class UpdateField extends AbstractField
{
	protected function getRegistryKey()
	{
		return 'xa_scUpdateFields';
	}

	protected function getClassIdentifier()
	{
		return 'XenAddons\Showcase:UpdateField';
	}

	public function getDisplayGroups()
	{
		return [
			'above' => \XF::phrase('xa_sc_above_update'),
			'below' => \XF::phrase('xa_sc_below_update'),
			'self_place' => \XF::phrase('xa_sc_self_placement'),
		];
	}
}