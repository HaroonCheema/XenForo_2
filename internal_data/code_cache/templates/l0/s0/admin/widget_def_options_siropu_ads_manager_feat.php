<?php
// FROM HASH: 257c16c1e1db90bc1050e3863d3c3cdc
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
		'value' => 'lastUpdate',
		'label' => 'Last update',
		'_type' => 'option',
	)), array(
		'label' => 'Display order',
	));
	return $__finalCompiled;
}
);