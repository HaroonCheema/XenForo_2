<?php
// FROM HASH: 886edbfed3549c802c79d58dfe0d2662
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[app_key]',
		'value' => $__vars['options']['app_key'],
	), array(
		'label' => 'App key',
		'hint' => 'Required',
		'explain' => 'App key of your application.
<br/>
You can create it in the Dropbox app console on this <a href="https://www.dropbox.com/developers/apps/create" target="_blank">page</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[app_secret]',
		'value' => $__vars['options']['app_secret'],
	), array(
		'label' => 'App secret',
		'hint' => 'Required',
		'explain' => 'App secret of your application.',
	));
	return $__finalCompiled;
}
);