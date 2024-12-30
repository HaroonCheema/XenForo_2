<?php
// FROM HASH: bc76f22fabba3c3cbce1641fad9e0c85
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'After submitting this form, the user will be sent to your selection below.',
	)) . '

' . '

' . $__templater->formRadioRow(array(
		'name' => 'returnto',
		'value' => ($__vars['form']['returnto'] ? $__vars['form']['returnto'] : 2),
	), array(array(
		'value' => '1',
		'label' => 'Forms list',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'Forum home',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'label' => 'Newly created thread/post',
		'_type' => 'option',
	),
	array(
		'value' => '4',
		'label' => 'Link defined below',
		'_type' => 'option',
	)), array(
		'label' => 'Return member to',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'returnlink',
		'value' => $__vars['form']['returnlink'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'returnlink', ), false),
	), array(
		'label' => 'Return link',
		'explain' => 'If you selected \'Link Defined Below\', enter the link here.',
	)) . '

';
	return $__finalCompiled;
}
);