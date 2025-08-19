<?php
// FROM HASH: c6cfb10ab5688eee88203f6a34982895
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

' . $__templater->formSelectRow(array(
		'name' => 'options[order]',
		'value' => $__vars['options']['order'],
	), array(array(
		'value' => 'random',
		'label' => 'Random',
		'_type' => 'option',
	),
	array(
		'value' => 'alphabetically',
		'label' => 'Alphabetically',
		'_type' => 'option',
	),
	array(
		'value' => 'registerDate',
		'label' => 'Registration date',
		'_type' => 'option',
	)), array(
		'label' => 'Display order',
	));
	return $__finalCompiled;
}
);