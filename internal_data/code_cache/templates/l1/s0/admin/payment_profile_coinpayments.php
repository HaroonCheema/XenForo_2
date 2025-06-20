<?php
// FROM HASH: 8f5a3f26a79b54db63607385cc053bc1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[merchant_id]',
		'value' => $__vars['profile']['options']['merchant_id'],
		'type' => 'text',
	), array(
		'label' => 'Merchant ID',
		'hint' => 'Required',
		'explain' => '
		' . 'You can obtain your \'merchant id\' from coinPayments via this link : <u><a href="https://www.coinpayments.net/index.php?cmd=acct_settings" target="_blank">https://www.coinpayments.net/index.php?cmd=acct_settings</a></u>' . '
	',
	)) . '


' . $__templater->formTextBoxRow(array(
		'name' => 'options[ipn_secret]',
		'value' => $__vars['profile']['options']['ipn_secret'],
		'type' => 'text',
	), array(
		'label' => 'IPN Secret',
		'hint' => 'Optional',
		'explain' => '
		' . 'This is used to verify that an IPN is from us.
You can obtain your \'IPN Secret\' from coinPayments via this link : <u><a href="https://www.coinpayments.net/index.php?cmd=acct_settings" target="_blank">https://www.coinpayments.net/index.php?cmd=acct_settings</a></u>' . '
	',
	)) . '


' . $__templater->formTextBoxRow(array(
		'name' => 'options[currency_exit]',
		'value' => $__vars['profile']['options']['currency_exit'],
		'type' => 'text',
	), array(
		'label' => 'Outgoing Currency',
		'hint' => 'Required',
		'explain' => '
		' . 'The currency the buyer will be sending. For example if your products are priced in USD but you are receiving BTC, you would use BTC. (for testing purposes use LTCT (Litecoin Testnet)
' . '
	',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[public_key]',
		'value' => $__vars['profile']['options']['public_key'],
		'type' => 'text',
	), array(
		'label' => 'Public Key',
		'hint' => 'Required',
		'explain' => '
		' . 'You can obtain a key via this link : <u><a href="https://www.coinpayments.net/acct-api-keys" target="_blank">https://www.coinpayments.net/acct-api-keys</a></u>' . '
	',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[private_key]',
		'value' => $__vars['profile']['options']['private_key'],
		'type' => 'text',
	), array(
		'label' => 'Private Key',
		'hint' => 'Required',
		'explain' => '
		' . 'You can obtain a key via this link : <u><a href="https://www.coinpayments.net/acct-api-keys" target="_blank">https://www.coinpayments.net/acct-api-keys</a></u>' . '
	',
	));
	return $__finalCompiled;
}
);