<?php
// FROM HASH: 6029d42ecec5fd55222164a1177f7517
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[username]',
		'value' => $__vars['profile']['options']['username'],
	), array(
		'label' => 'Tebex Username',
		'explain' => 'Get the username by <a href="https://creator.tebex.io/developers/api-keys">Username</a>',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[password]',
		'value' => $__vars['profile']['options']['password'],
	), array(
		'label' => 'Tebex Password',
		'explain' => 'Get the password from <a href="https://creator.tebex.io/developers/api-keys">Private Key</a>',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[webhook_secret]',
		'value' => $__vars['profile']['options']['webhook_secret'],
	), array(
		'label' => 'Webhook Secret',
		'explain' => 'You will also need to add your callback URL in this <a href="https://creator.tebex.io/webhooks">location</a>. Click "Add an endpoint" and add: ' . $__templater->escape($__vars['xf']['options']['boardUrl']) . '/' . 'tebex_callback.php?_xfProvider=xc_tebex' . '',
	));
	return $__finalCompiled;
}
);