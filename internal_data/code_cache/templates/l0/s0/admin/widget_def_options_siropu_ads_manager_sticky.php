<?php
// FROM HASH: 17d62c4f35a56b6cafe06b8de6a61ab9
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
		'value' => 'lastPostDate',
		'label' => 'Last post date',
		'_type' => 'option',
	)), array(
		'label' => 'Display order',
	));
	return $__finalCompiled;
}
);