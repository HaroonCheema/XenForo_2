<?php
// FROM HASH: 9d616ab861a705a89b021ebbdc277079
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[client_id]',
		'value' => $__vars['options']['client_id'],
	), array(
		'label' => 'Client ID',
		'hint' => 'Required',
		'explain' => 'Client ID of your application.
<br/>
You can create it in the PayPal <a href="https://developer.paypal.com/developer/applications" target="_blank">dashboard</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[client_secret]',
		'value' => $__vars['options']['client_secret'],
	), array(
		'label' => 'Client secret',
		'hint' => 'Required',
		'explain' => 'Client secret of your application.',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[scope_email]',
		'selected' => $__vars['options']['scope_email'],
		'label' => 'Request the user\'s email',
		'hint' => 'Before you set this option, you must add scope \'email\' to the application.
<br/>
Read more <a href="https://developer.paypal.com/docs/integration/direct/identity/attributes/#user-attribute-and-scope-mappingss" target="_blank">here</a>.',
		'_type' => 'option',
	),
	array(
		'name' => 'options[scope_location]',
		'selected' => $__vars['options']['scope_location'],
		'label' => 'Request the user\'s location',
		'hint' => 'Before you set this option, you must add scope \'address\' to the application.
<br/>
Read more <a href="https://developer.paypal.com/docs/integration/direct/identity/attributes/#user-attribute-and-scope-mappingss" target="_blank">here</a>.',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);