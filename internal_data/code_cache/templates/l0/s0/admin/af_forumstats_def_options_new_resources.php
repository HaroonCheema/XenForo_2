<?php
// FROM HASH: b27be7f5c133b01ab0ec9a2da10ec564
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['options']['limit'],
		'min' => '1',
	), array(
		'label' => 'Maximum entries',
	)) . '

';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'All categories or contextual category',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['categoryTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['resource_category_id'],
				'label' => '
            ' . $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . $__templater->escape($__vars['treeEntry']['record']['title']) . '
        ',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[resource_category_ids][]',
		'value' => ($__vars['options']['resource_category_ids'] ?: 0),
		'multiple' => 'multiple',
		'size' => '7',
	), $__compilerTemp1, array(
		'label' => 'Category limit',
		'explain' => 'If no categories are explicitly selected, this widget will pull from all categories unless used within a resource category. In this case, the resources will be limited to that category and descendents.',
	)) . '

' . $__templater->formSelectRow(array(
		'name' => 'options[prefix]',
		'value' => ($__vars['options']['prefix'] ?: ''),
	), array(array(
		'value' => '',
		'label' => 'No prefix',
		'_type' => 'option',
	),
	array(
		'value' => 'html',
		'label' => 'HTML',
		'_type' => 'option',
	),
	array(
		'value' => 'plain',
		'label' => 'Plain',
		'_type' => 'option',
	)), array(
		'label' => 'Prefix',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[ignore_view_perms]',
		'selected' => $__vars['options']['ignore_view_perms'],
		'label' => 'Yes',
		'_type' => 'option',
	)), array(
		'label' => 'Ignore user view permissions',
	));
	return $__finalCompiled;
}
);