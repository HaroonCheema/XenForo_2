<?php
// FROM HASH: 2f742549ebf7c946650e3fc3e0951d4b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[account_name]',
		'value' => $__vars['profile']['options']['account_name'],
	), array(
		'label' => 'Bank account name',
	)) . '
			   
' . $__templater->formTextBoxRow(array(
		'name' => 'options[account_number]',
		'value' => $__vars['profile']['options']['account_number'],
	), array(
		'label' => 'Bank account number (IBAN)',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[swift_code]',
		'value' => $__vars['profile']['options']['swift_code'],
	), array(
		'label' => 'SWIFT code',
	)) . '

' . $__templater->formTextAreaRow(array(
		'name' => 'options[instructions]',
		'value' => $__vars['profile']['options']['instructions'],
		'rows' => '3',
	), array(
		'label' => 'Bank transfer instructions',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[mark_as_paid]',
		'value' => '1',
		'checked' => ($__vars['profile']['options']['mark_as_paid'] == 1),
		'label' => 'Enable "Mark as paid" button',
		'_type' => 'option',
	)), array(
		'explain' => 'This option allows you to display a "Mark as paid" button that will notify you via an alert that the user has completed the payment.',
	));
	return $__finalCompiled;
}
);