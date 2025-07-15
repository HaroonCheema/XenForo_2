<?php
// FROM HASH: e1f24d978e680ddd7ecbbaa4cd06ef4b
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
		'explain' => 'Web app ID of your Reddit application. You can create an application on <a href="https://www.reddit.com/prefs/apps" target="_blank">this page</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[app_secret]',
		'value' => $__vars['options']['app_secret'],
	), array(
		'label' => 'App secret',
		'hint' => 'Required',
		'explain' => 'App secret of your Reddit application. ',
	));
	return $__finalCompiled;
}
);