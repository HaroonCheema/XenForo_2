<?php
// FROM HASH: 55295ef7a5bfac9d5e705232bb6da412
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'options[relocate]',
		'value' => $__vars['options']['relocate'],
	), array(
		'label' => 'Relocate slider',
		'explain' => 'The slider will be detached and inserted before this element.',
	)) . '

' . $__templater->formSelectRow(array(
		'name' => 'options[mode]',
		'value' => $__vars['options']['mode'],
	), array(array(
		'value' => 'fade',
		'label' => 'fade',
		'_type' => 'option',
	),
	array(
		'value' => 'horizontal',
		'label' => 'horizontal',
		'_type' => 'option',
	),
	array(
		'value' => 'vertical',
		'label' => 'vertical',
		'_type' => 'option',
	)), array(
		'label' => 'Transition mode',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[speed]',
		'value' => $__vars['options']['speed'],
		'min' => '0',
		'step' => '100',
	), array(
		'label' => 'Transition speed',
	)) . '
' . $__templater->formNumberBoxRow(array(
		'name' => 'options[auto]',
		'value' => $__vars['options']['auto'],
		'min' => '0',
		'step' => '100',
	), array(
		'label' => 'Transition frequency',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[pager]',
		'selected' => $__vars['options']['pager'],
		'label' => '
		' . 'Show pager bullets' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[controls]',
		'selected' => $__vars['options']['controls'],
		'label' => '
		' . 'Show prev/next controls' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[autoControls]',
		'selected' => $__vars['options']['autoControls'],
		'label' => '
		' . 'Show start/stop controls' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[progress]',
		'selected' => $__vars['options']['progress'],
		'label' => '
		' . 'Show progress bar' . '
	',
		'_type' => 'option',
	)), array(
	)) . '

<hr class="formRowSep" />

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['options']['limit'],
		'min' => '1',
	), array(
		'label' => 'Maximum entries',
	)) . '
' . $__templater->formNumberBoxRow(array(
		'name' => 'options[trim]',
		'value' => $__vars['options']['trim'],
		'min' => '0',
	), array(
		'label' => 'Excerpt trim',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[category]',
		'selected' => $__vars['options']['category'],
		'label' => '
		' . 'Show on category pages' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[author]',
		'selected' => $__vars['options']['author'],
		'label' => '
		' . 'Show on author pages' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[pages]',
		'selected' => $__vars['options']['pages'],
		'label' => '
		' . 'Show on pages beyond the first' . '
	',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);