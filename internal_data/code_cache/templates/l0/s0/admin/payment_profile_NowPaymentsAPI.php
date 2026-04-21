<?php
// FROM HASH: 75ad6834cd024f0b97ed7bba73f2ede9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
  
  ' . $__templater->formTextBoxRow(array(
		'name' => 'options[ipn_urln]',
		'value' => $__vars['profile']['options']['ipn_urln'],
		'autocomplete' => 'text',
	), array(
		'label' => 'IPN URL',
		'hint' => 'Required',
	)) . '
' . $__templater->formPasswordBoxRow(array(
		'name' => 'options[api_key]',
		'value' => $__vars['profile']['options']['api_key'],
		'type' => 'password',
		'autocomplete' => 'new-password',
	), array(
		'label' => 'Api key',
		'hint' => 'Required',
	)) . '

' . $__templater->formPasswordBoxRow(array(
		'name' => 'options[secret_key]',
		'value' => $__vars['profile']['options']['secret_key'],
		'type' => 'password',
		'autocomplete' => 'new-password',
	), array(
		'label' => 'IPN Secret key',
		'hint' => 'Required',
	));
	return $__finalCompiled;
}
);