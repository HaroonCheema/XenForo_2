<?php
// FROM HASH: 197944be964db79c097cc677fc46974a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'options[widget_id]',
		'value' => $__vars['options']['widget_id'],
	), array(
		'label' => 'Widget ID',
	)) . '
' . $__templater->formTextBoxRow(array(
		'name' => 'options[search]',
		'value' => $__vars['options']['search'],
	), array(
		'label' => 'Search text',
	)) . '
' . $__templater->formTextBoxRow(array(
		'name' => 'options[related]',
		'value' => $__vars['options']['related'],
	), array(
		'label' => 'Related users',
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
		'name' => 'options[chrome][noheader]',
		'value' => 'noheader',
		'selected' => $__vars['options']['chrome']['noheader'],
		'label' => '
		' . 'Hide header' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[chrome][nofooter]',
		'value' => 'nofooter',
		'selected' => $__vars['options']['chrome']['nofooter'],
		'label' => '
		' . 'Hide footer' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[chrome][noborders]',
		'value' => 'noborders',
		'selected' => $__vars['options']['chrome']['noborders'],
		'label' => '
		' . 'Hide borders' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[chrome][transparent]',
		'value' => 'transparent',
		'selected' => $__vars['options']['chrome']['transparent'],
		'label' => '
		' . 'Hide background' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[chrome][noscrollbar]',
		'value' => 'noscrollbar',
		'selected' => $__vars['options']['chrome']['noscrollbar'],
		'label' => '
		' . 'Hide scrollbar' . '
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