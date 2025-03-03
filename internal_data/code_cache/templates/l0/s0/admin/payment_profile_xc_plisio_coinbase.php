<?php
// FROM HASH: bae52b95b525feb3f0c95c5448136bef
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[api_key]',
		'value' => $__vars['profile']['options']['api_key'],
	), array(
		'label' => 'API key',
		'explain' => 'Enter your API key for Coinbase Commerce. You can find this <a href="https://commerce.coinbase.com/dashboard/settings">here</a>. Additionally, you may also need to whitelist your domain on that page (your board URL is: ' . $__templater->escape($__vars['xf']['options']['boardUrl']) . ').',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[webhook_secret]',
		'value' => $__vars['profile']['options']['webhook_secret'],
	), array(
		'label' => 'Webhook secret',
		'explain' => 'The key for your webhook secret. Found on the <a href="https://plisio.net/account">Coinbase Commerce settings page</a>. You will also need to add your callback URL in the same location. Click "Add an endpoint" and add: ' . $__templater->escape($__vars['xf']['options']['boardUrl']) . '/' . 'payment_callback.php?_xfProvider=xc_plisio_coinbase' . '',
	));
	return $__finalCompiled;
}
);