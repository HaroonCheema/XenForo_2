<?php
// FROM HASH: 37db44886a4c90063a4b6b46ec0d5e06
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[client_id]',
		'value' => $__vars['profile']['options']['client_id'],
		'type' => 'text',
	), array(
		'label' => 'Client Id',
		'hint' => 'Required',
		'explain' => '
		' . 'You can obtain a key via this link : <u><a href="https://a-dashboard.coinpayments.net/en/app/integrations" target="_blank">https://a-dashboard.coinpayments.net/en/app/integrations</a></u>' . '
	',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[client_secret]',
		'value' => $__vars['profile']['options']['client_secret'],
		'type' => 'text',
	), array(
		'label' => 'Client Secret',
		'hint' => 'Required',
		'explain' => '
		' . 'You can obtain a key via this link : <u><a href="https://a-dashboard.coinpayments.net/en/app/integrations" target="_blank">https://a-dashboard.coinpayments.net/en/app/integrations</a></u>' . '
	',
	));
	return $__finalCompiled;
}
);