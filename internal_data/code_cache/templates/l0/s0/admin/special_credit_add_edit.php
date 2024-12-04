<?php
// FROM HASH: 569b8a2a8c3c7f29455fdc40bb317c3f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['specialCredits']['user_special_credit_id']) {
		$__compilerTemp1 .= '
        ' . 'Edit User Special Credit:' . ' ' . $__templater->escape($__vars['specialCredits']['User']['username']) . '
        ';
	} else {
		$__compilerTemp1 .= '
        ' . 'Add User Special Credits' . '
    ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
    ' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

' . $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'ac' => 'single',
		'value' => $__vars['specialCredits']['User']['username'],
	), array(
		'label' => 'Username',
	)) . '
            ' . $__templater->formTextAreaRow(array(
		'name' => 'reason',
		'value' => $__vars['specialCredits']['reason'],
		'autosize' => 'true',
		'required' => 'true',
	), array(
		'label' => 'Reason',
	)) . '
            ' . $__templater->formNumberBoxRow(array(
		'name' => 'special_credit',
		'min' => '1',
		'step' => '1',
		'value' => $__vars['specialCredits']['User']['special_credit'],
	), array(
		'label' => 'Credits',
	)) . '
        </div>
        ' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('user-special-credit/save', $__vars['specialCredits'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);