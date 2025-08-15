<?php
// FROM HASH: e7b1509165de99edca7f00dc33063a06
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formPasswordBoxRow(array(
		'name' => 'options[secret_key]',
		'value' => $__vars['profile']['options']['secret_key'],
		'type' => 'password',
		'autocomplete' => 'new-password',
	), array(
		'label' => 'Secret key',
		'hint' => 'Required',
	));
	return $__finalCompiled;
}
);