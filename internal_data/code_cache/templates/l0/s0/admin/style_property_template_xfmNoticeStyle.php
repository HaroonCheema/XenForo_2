<?php
// FROM HASH: caf5d288cda8d6e7ef31e06e50ea0d5a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => $__vars['formBaseKey'] . '[type]',
		'value' => $__vars['property']['property_value']['type'],
	), array(array(
		'value' => 'primary',
		'label' => 'Primary',
		'_type' => 'option',
	),
	array(
		'value' => 'accent',
		'label' => 'Accent',
		'_type' => 'option',
	),
	array(
		'value' => 'dark',
		'label' => 'Dark',
		'_type' => 'option',
	),
	array(
		'value' => 'light',
		'label' => 'Light',
		'_type' => 'option',
	),
	array(
		'value' => 'custom',
		'label' => 'Other, using custom CSS class name' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => $__vars['formBaseKey'] . '[css_class]',
		'value' => $__vars['property']['property_value']['css_class'],
		'dir' => 'ltr',
	))),
		'_type' => 'option',
	)), array(
		'rowclass' => $__vars['rowClass'],
		'label' => $__templater->escape($__vars['titleHtml']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['property']['description']),
	));
	return $__finalCompiled;
}
);