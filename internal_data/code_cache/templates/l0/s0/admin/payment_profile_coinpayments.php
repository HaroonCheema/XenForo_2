<?php
// FROM HASH: 50d2bd64531ef34d219f55a6fa04ca6c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[currency_entry]',
		'value' => $__vars['profile']['options']['currency_entry'],
		'type' => 'text',
	), array(
		'label' => 'Original Currency',
		'hint' => 'Required',
		'explain' => '
		' . 'Currency that will be used to calculate the price in the outgoing currency.' . '
	',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[amount]',
		'value' => $__vars['profile']['options']['amount'],
		'type' => 'text',
	), array(
		'label' => 'Amount',
		'hint' => 'Required',
		'explain' => '
		' . 'Amount of the original currency that will be converted into the outdoing currency.' . '
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
		' . 'Currency that will be returned to your wallet on CoinPayments.' . '
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
		' . 'You can obtain a key via this link : <u><a href="https://www.coinpayments.net/acct-api-keys">https://www.coinpayments.net/acct-api-keys</a></u>' . '
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
		' . 'You can obtain a key via this link : <u><a href="https://www.coinpayments.net/acct-api-keys">https://www.coinpayments.net/acct-api-keys</a></u>' . '
	',
	));
	return $__finalCompiled;
}
);