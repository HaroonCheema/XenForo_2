<?php
// FROM HASH: 2870151ab0f1ccd5a2d600ece8d7881d
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
		'explain' => 'The ID that is associated with your <a href="https://vk.com/apps?act=manage" target="_blank">VK application</a> for this domain.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[app_secret]',
		'value' => $__vars['options']['app_secret'],
	), array(
		'label' => 'App secret',
		'hint' => 'Required',
		'explain' => 'The secret for the VK application you created for this domain.',
	));
	return $__finalCompiled;
}
);