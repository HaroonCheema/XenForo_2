<?php
// FROM HASH: 5fa81901abf460b3118470e9be99decb
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
		'explain' => 'Client identifier of your vimeo application. You can create an application on <a href="https://developer.vimeo.com/apps" target="_blank">this page</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[app_secret]',
		'value' => $__vars['options']['app_secret'],
	), array(
		'label' => 'App secret',
		'hint' => 'Required',
		'explain' => 'Client secret of your application.',
	));
	return $__finalCompiled;
}
);