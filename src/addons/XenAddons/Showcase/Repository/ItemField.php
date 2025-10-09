<?php

namespace XenAddons\Showcase\Repository;

use XF\Repository\AbstractField;

class ItemField extends AbstractField
{
	protected function getRegistryKey()
	{
		return 'xa_scItemFields';
	}

	protected function getClassIdentifier()
	{
		return 'XenAddons\Showcase:ItemField';
	}

	public function getDisplayGroups()
	{
		return [
			'header' => \XF::phrase('xa_sc_item_header'),
			'section_1' => \XF::phrase('xa_sc_section_1'),
			'section_2' => \XF::phrase('xa_sc_section_2'),
			'section_3' => \XF::phrase('xa_sc_section_3'),
			'section_4' => \XF::phrase('xa_sc_section_4'),			
			'section_5' => \XF::phrase('xa_sc_section_5'),
			'section_6' => \XF::phrase('xa_sc_section_6'),
			'new_tab' => \XF::phrase('xa_sc_own_tab'),
			'sidebar' => \XF::phrase('xa_sc_sidebar_block'),
			'new_sidebar_block' => \XF::phrase('xa_sc_own_sidebar_block'),
			'self_place' => \XF::phrase('xa_sc_self_placement'),
		];
	}
}