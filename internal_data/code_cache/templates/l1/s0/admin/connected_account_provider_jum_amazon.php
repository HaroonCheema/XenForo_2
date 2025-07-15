<?php
// FROM HASH: e891f21bd2df09d2d187dff73d942cd0
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
You can create it in the Amazon console on the <a href="https://developer.amazon.com/settings/console/securityprofile/overview.html" target="_blank">Security profiles</a> page.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[client_secret]',
		'value' => $__vars['options']['client_secret'],
	), array(
		'label' => 'Client secret',
		'hint' => 'Required',
		'explain' => 'Client Secret of your application.',
	));
	return $__finalCompiled;
}
);