<?php
// FROM HASH: a1c15e1eec693ffd1575e48b42dce628
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'name' => 'allow_filter',
		'selected' => $__vars['field']['FieldData']['allow_filter'],
		'label' => 'Allow Filter',
		'hint' => 'If enable, the users will be able to filter thread lists by the value of this field, and the filter will be shown in the Filters popup on thread list page.',
		'_type' => 'option',
	)
,array(
		'name' => 'allow_search',
		'selected' => $__vars['field']['FieldData']['allow_search'],
		'label' => 'Allow Search',
		'hint' => 'If enabled, the filter will be shown in Thread Search page. Only fields available in the forum being searched will be shown.',
		'_type' => 'option',
	));
	if ($__vars['field']['is_sortable']) {
		$__compilerTemp1[] = array(
			'name' => 'allow_sorting',
			'selected' => $__vars['field']['FieldData']['allow_sorting'],
			'label' => 'Allow Sorting',
			'hint' => 'If enabled, the field will be available in Thread Sorting options.',
			'_type' => 'option',
		);
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), $__compilerTemp1, array(
		'label' => 'Thread Filter options',
	));
	return $__finalCompiled;
}
);