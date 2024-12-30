<?php
// FROM HASH: 1ca97b10183058d4c6b127f0902cbfe4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formRadioRow(array(
		'name' => 'options[style]',
		'value' => ($__vars['options']['style'] ?: 'simple'),
	), array(array(
		'value' => 'simple',
		'hint' => 'new_posts_display_style_simple_explain',
		'label' => 'Simple',
		'_type' => 'option',
	),
	array(
		'value' => 'full',
		'hint' => 'A full size view, displaying as a standard thread list.',
		'label' => 'Full',
		'_type' => 'option',
	)), array(
		'label' => 'Display style',
	));
	return $__finalCompiled;
}
);