<?php
// FROM HASH: b227f8375b37416e04d3330858533bde
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['forum'], 'canRegisterUsingPost', array())) {
		$__finalCompiled .= '

	' . $__templater->formRow('
		' . $__templater->formInfoRow('
			<h3>
				<center>
					' . 'Register' . '
				</center>
			</h3>
		', array(
		)) . '
	', array(
		)) . '

	' . $__templater->callMacro('register_macros', 'username_row', array(
			'fieldName' => $__templater->method($__vars['regForm'], 'getFieldName', array('username', )),
			'value' => $__vars['fields']['username'],
		), $__vars) . '

	' . $__templater->callMacro('register_macros', 'email_row', array(
			'fieldName' => $__templater->method($__vars['regForm'], 'getFieldName', array('email', )),
			'value' => $__vars['fields']['email'],
		), $__vars) . '

	' . $__templater->formPasswordBoxRow(array(
			'name' => $__templater->method($__vars['regForm'], 'getFieldName', array('password', )),
			'autocomplete' => 'new-password',
			'required' => 'required',
			'checkstrength' => 'true',
		), array(
			'label' => 'Password',
			'hint' => 'Required',
		)) . '

	' . '

	' . $__templater->callMacro('register_macros', 'tos_row', array(), $__vars) . '

	' . $__templater->formHiddenVal('reg_key', $__templater->method($__vars['regForm'], 'getUniqueKey', array()), array(
		)) . '
	' . $__templater->formHiddenVal($__templater->method($__vars['regForm'], 'getFieldName', array('timezone', )), '', array(
			'data-xf-init' => 'auto-timezone',
		)) . '

	';
	} else {
		$__finalCompiled .= '

	' . $__templater->formTextBoxRow(array(
			'name' => '_xfUsername',
			'data-xf-init' => 'guest-username',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		), array(
			'label' => 'Name',
		)) . '

';
	}
	return $__finalCompiled;
}
);