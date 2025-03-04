<?php
// FROM HASH: 8f8884333bc0a6148022e32edc02512e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[merchant_id]',
		'value' => $__vars['profile']['options']['merchant_id'],
		'required' => 'required',
	), array(
		'label' => 'Merchant id',
		'explain' => 'Enter <a href="https://portal.coinpal.io/#/admin/integration" target="_blank">CoinPal</a> merchant id here...!',
	)) . '
' . $__templater->formTextBoxRow(array(
		'name' => 'options[secret_key]',
		'value' => $__vars['profile']['options']['secret_key'],
		'required' => 'required',
	), array(
		'label' => 'Secret key',
		'explain' => 'Enter <a href="https://portal.coinpal.io/#/admin/integration" target="_blank">CoinPal</a> secret key here...!',
	));
	return $__finalCompiled;
}
);