<?php
// FROM HASH: 6d6ce2e52e2d04fd708ba16e759ab885
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Password Match');
	$__finalCompiled .= '

' . $__templater->includeTemplate('dc_link_proxy_password_instrunctions', $__vars) . '

' . $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . $__templater->formTextBox(array(
		'name' => 'password',
		'placeholder' => 'Enter password here...!',
		'required' => 'required',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Password',
		'hint' => 'Required',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'submit',
		'sticky' => 'true',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('redirect/match-password', null, array('to' => $__vars['to'], ), ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);