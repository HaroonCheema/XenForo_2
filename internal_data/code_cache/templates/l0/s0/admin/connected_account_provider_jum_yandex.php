<?php
// FROM HASH: 0237a81f7fc7640ab2554cbd34e830e0
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
		'explain' => 'The Application ID of your Yandex application. You can create an application on <a href="https://oauth.yandex.ru/" target="_blank">this page</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[app_password]',
		'value' => $__vars['options']['app_password'],
	), array(
		'label' => 'App password',
		'hint' => 'Required',
		'explain' => 'The Application password of your Yandex application.',
	));
	return $__finalCompiled;
}
);