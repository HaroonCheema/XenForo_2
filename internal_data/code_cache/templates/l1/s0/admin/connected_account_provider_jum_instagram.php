<?php
// FROM HASH: 2d33bf70b013f88d29e819de13cbbca6
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
		'explain' => 'Сlient ID of your application.
<br/>
You can create it in the Instagram <a href="https://www.instagram.com/developer/clients/manage/" target="_blank">app console</a>.',
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