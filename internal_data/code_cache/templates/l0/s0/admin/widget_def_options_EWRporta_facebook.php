<?php
// FROM HASH: 5fd2801d36c895f820031bb6598cd58f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'options[href]',
		'value' => $__vars['options']['href'],
	), array(
		'label' => 'Page URL',
	)) . '
' . $__templater->formNumberBoxRow(array(
		'name' => 'options[height]',
		'value' => $__vars['options']['height'],
		'min' => '300',
	), array(
		'label' => 'Height',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[small_header]',
		'selected' => $__vars['options']['small_header'],
		'label' => '
		' . 'Small header' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[hide_cover]',
		'selected' => $__vars['options']['hide_cover'],
		'label' => '
		' . 'Hide cover' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[hide_cta]',
		'selected' => $__vars['options']['hide_cta'],
		'label' => '
		' . 'Hide call-to-action' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[show_facepile]',
		'selected' => $__vars['options']['show_facepile'],
		'label' => '
		' . 'Show facepile' . '
	',
		'_type' => 'option',
	)), array(
	)) . '

<hr class="formRowSep" />

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[advanced_mode]',
		'value' => '1',
		'selected' => $__vars['options']['advanced_mode'],
		'label' => 'Advanced mode',
		'hint' => 'If enabled, the HTML for your page will not be contained within a block.',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);