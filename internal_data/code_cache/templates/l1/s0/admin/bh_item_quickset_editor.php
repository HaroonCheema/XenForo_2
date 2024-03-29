<?php
// FROM HASH: 6f6f11916f5d5ba388eec56749f620d6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Quick set items');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['items'])) {
		foreach ($__vars['items'] AS $__vars['itemId'] => $__vars['items']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['itemId'],
				'checked' => 'checked',
				'label' => '<span class="">' . $__templater->escape($__vars['items']['item_title']) . '</span>',
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp2 = array(array(
		'value' => '',
		'selected' => !$__vars['nodeIds'],
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['brands'])) {
		foreach ($__vars['brands'] AS $__vars['brand']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['brand']['brand_id'] . ',' . $__vars['brand']['brand_title'],
				'label' => $__templater->escape($__vars['brand']['brand_title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = array(array(
		'value' => '',
		'selected' => !$__vars['nodeIds'],
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['brandCategories'])) {
		foreach ($__vars['brandCategories'] AS $__vars['brandCategory']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['brandCategory']['category_id'],
				'label' => $__templater->escape($__vars['brandCategory']['category_title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formCheckBoxRow(array(
		'name' => 'item_ids',
		'listclass' => 'inputChoices--inline',
	), $__compilerTemp1, array(
		'label' => 'Apply to these items',
	)) . '
			
			<hr class="formRowSep" />
			
			' . $__templater->formSelectRow(array(
		'name' => 'brand_id',
		'value' => $__vars['item']['brand_id'] . ',' . $__vars['item']['brand_title'],
		'required' => 'true',
	), $__compilerTemp2, array(
		'label' => 'Make',
	)) . '
			
			' . $__templater->formSelectRow(array(
		'name' => 'category_id',
		'value' => $__vars['item']['category_id'],
		'required' => 'true',
	), $__compilerTemp3, array(
		'label' => 'Category',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('bh_item/quick-set', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);