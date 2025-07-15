<?php
// FROM HASH: 30fc1ab590b6a028712049d96af9b4a3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[app_id]',
		'value' => $__vars['options']['app_id'],
	), array(
		'label' => 'App ID',
		'hint' => 'Required',
		'explain' => 'The Application ID of your Odnoklassniki application. You can create an application on <a href="https://ok.ru/vitrine/myuploaded" target="_blank">this page</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[app_pub_key]',
		'value' => $__vars['options']['app_pub_key'],
	), array(
		'label' => 'Public key',
		'hint' => 'Required',
		'explain' => '',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[app_secret_key]',
		'value' => $__vars['options']['app_secret_key'],
	), array(
		'label' => 'Secret key',
		'hint' => 'Required',
		'explain' => '',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[scope_email]',
		'selected' => $__vars['options']['scope_email'],
		'label' => 'Request the user\'s email',
		'hint' => 'Before you set this option, you must add scope \'GET_EMAIL\' to the application.
<br/>
Read more <a href="https://apiok.ru/ext/oauth/permissions" target="_blank">here</a>.',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);