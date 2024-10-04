<?php
// FROM HASH: e6f9692e2e3df4ef5978a71225c1c4cd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[live_key_id]',
		'value' => $__vars['profile']['options']['live_key_id'],
	), array(
		'label' => 'razorpay_live_key_id',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[live_key_secret]',
		'value' => $__vars['profile']['options']['live_key_secret'],
	), array(
		'label' => 'razorpay_live_key_secret',
		'explain' => 'razorpay_live_keys_explain',
	)) . '

<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'options[test_key_id]',
		'value' => $__vars['profile']['options']['test_key_id'],
	), array(
		'label' => 'razorpay_test_key_id',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[test_key_secret]',
		'value' => $__vars['profile']['options']['test_key_secret'],
	), array(
		'label' => 'razorpay_test_key_secret',
		'explain' => 'razorpay_test_keys_explain',
	));
	return $__finalCompiled;
}
);