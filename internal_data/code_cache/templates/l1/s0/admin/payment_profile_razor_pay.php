<?php
// FROM HASH: 0f8235719859b1998a2c8696fa51c4aa
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[api_key]',
		'value' => $__vars['profile']['options']['api_key'],
	), array(
		'label' => 'Api key',
		'explain' => 'Razor Pay api key. You can find this <a href="https://dashboard.razorpay.com/signin?screen=sign_in">here</a>.',
	)) . '
' . $__templater->formTextBoxRow(array(
		'name' => 'options[api_secret]',
		'value' => $__vars['profile']['options']['api_secret'],
	), array(
		'label' => 'Secret key',
		'explain' => 'Razor Pay secret key. You can find this <a href="https://dashboard.razorpay.com/signin?screen=sign_in">here</a>.',
	)) . '
' . $__templater->formRow('
	' . $__templater->escape($__vars['xf']['options']['boardUrl']) . '/payment_callback.php?_xfProvider=razor_pay
', array(
		'label' => 'Webhook',
		'explain' => 'Copy the web hook url above and set in razor pay Webhook Setup  also active all <strong>Events<strong>.',
	));
	return $__finalCompiled;
}
);