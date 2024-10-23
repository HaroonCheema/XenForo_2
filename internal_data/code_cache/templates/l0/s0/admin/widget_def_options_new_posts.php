<?php
// FROM HASH: 63ffb2433950171006498c787743c842
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

' . $__templater->formRadioRow(array(
		'name' => 'options[style]',
		'value' => ($__vars['options']['style'] ?: 'simple'),
	), array(array(
		'value' => 'simple',
		'label' => 'Simple',
		'hint' => 'A simple view, designed for narrow spaces such as sidebars.',
		'_type' => 'option',
	),
	array(
		'value' => 'full',
		'label' => 'Standard',
		'hint' => 'A full size view, displaying as a standard thread list.',
		'_type' => 'option',
	)), array(
		'label' => 'Display style',
	)) . '

' . $__templater->formRadioRow(array(
		'name' => 'options[filter]',
		'value' => ($__vars['options']['filter'] ?: 'latest'),
	), array(array(
		'value' => 'latest',
		'label' => 'Latest',
		'hint' => 'A list of any thread which have been recently posted in (default for guests).',
		'_type' => 'option',
	),
	array(
		'value' => 'unread',
		'label' => 'Unread',
		'hint' => 'A list of threads which contain unread posts.',
		'_type' => 'option',
	),
	array(
		'value' => 'watched',
		'label' => 'Watched',
		'hint' => 'A list of threads the user is watching that have been recently posted in.',
		'_type' => 'option',
	)), array(
		'label' => 'Filter',
	)) . '

' . $__templater->includeTemplate('limit_node_selection', $__vars);
	return $__finalCompiled;
}
);