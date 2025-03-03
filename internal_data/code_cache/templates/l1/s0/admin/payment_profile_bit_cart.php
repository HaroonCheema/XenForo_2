<?php
// FROM HASH: b4894649f2108a37b67f095b75ab28cc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[store_id]',
		'value' => $__vars['profile']['options']['store_id'],
	), array(
		'label' => 'Store Id',
		'explain' => 'Find Store <a href="https://admin.bitcart.ai/stores">Click here </a>',
	)) . '
' . $__templater->formTextBoxRow(array(
		'name' => 'options[basic_url]',
		'value' => $__vars['profile']['options']['basic_url'],
	), array(
		'label' => 'Basic Admin url.',
		'explain' => 'Basic Admin Url.Do not put backslash at the end.',
	));
	return $__finalCompiled;
}
);