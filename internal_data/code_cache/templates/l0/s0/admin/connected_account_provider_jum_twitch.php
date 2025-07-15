<?php
// FROM HASH: 482f2509300c8501041ff60f5e451490
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
You can create it in the Twitch developers console on this <a href="https://glass.twitch.tv/console/apps" target="_blank">page</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[client_secret]',
		'value' => $__vars['options']['client_secret'],
	), array(
		'label' => 'Client secret',
		'hint' => 'Required',
		'explain' => 'Secret code of your application.',
	));
	return $__finalCompiled;
}
);