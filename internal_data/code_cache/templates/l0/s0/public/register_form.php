<?php
// FROM HASH: 6f526345fb55ff46ebf0e5d6b1b967ed
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'xf/login_signup.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Register');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'robots', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	if ($__vars['xf']['session']['preRegActionKey']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--highlight">
		' . 'Thanks for your contribution. 
Before your content can be posted, please take a few moments to register a free user account.' . '<br />
		<br />
		' . 'Already have an account?' . '
		' . $__templater->button('Login', array(
			'class' => 'button--link',
			'href' => $__templater->func('link', array('login', null, array('_xfRedirect' => $__vars['redirect'], ), ), false),
			'data-xf-click' => 'overlay',
		), '', array(
		)) . '
	</div>
';
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['providers'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['providers'])) {
			foreach ($__vars['providers'] AS $__vars['provider']) {
				$__compilerTemp1 .= '
							<li>
								' . $__templater->callMacro('connected_account_macros', 'button', array(
					'provider' => $__vars['provider'],
				), $__vars) . '
							</li>
						';
			}
		}
		$__finalCompiled .= $__templater->formRow('

					<ul class="listHeap">
						' . $__compilerTemp1 . '
					</ul>
				', array(
			'rowtype' => 'button',
			'label' => 'Register faster using',
		)) . '
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp2 = '';
	if ($__vars['xf']['options']['af_paidregistrations_guest']) {
		$__compilerTemp2 .= '
    ';
		if ($__vars['userUpgrade']) {
			$__compilerTemp2 .= '
        ' . $__templater->formInfoRow('Thank you for your purchase! Please fill this form to complete registration, your account upgrade will be automatically applied shortly.', array(
			)) . '
        ' . $__templater->formRow($__templater->escape($__vars['userUpgrade']['title']) . ' (' . $__templater->escape($__vars['userUpgrade']['cost_phrase']) . ')', array(
				'label' => 'Account Type',
			)) . '
        ' . $__templater->formHiddenVal('prk', $__vars['purchaseRequest']['request_key'], array(
			)) . '
    ';
		} else {
			$__compilerTemp2 .= '
        ' . $__templater->formRow($__templater->escape($__vars['xf']['options']['af_paidregistrations_freeTitle']) . ' (' . 'Free' . ')', array(
				'label' => 'Account Type',
			)) . '
    ';
		}
		$__compilerTemp2 .= '
    ';
		if ($__templater->method($__vars['xf']['request'], 'exists', array('_xfRedirect', ))) {
			$__compilerTemp2 .= '
        ' . $__templater->func('redirect_input', array($__templater->method($__vars['xf']['request'], 'get', array('_xfRedirect', )), null, false, ), true) . '
    ';
		}
		$__compilerTemp2 .= '
';
	}
	$__compilerTemp3 = '';
	if ($__vars['xf']['options']['fs_enable'] AND (!$__vars['xf']['options']['fs_use_random'])) {
		$__compilerTemp3 .= '
	' . $__templater->includeTemplate('gallery_avatar_register', $__vars) . '
';
	}
	$__compilerTemp4 = '';
	if (($__templater->func('rand', array(0, 2, ), false) == 1)) {
		$__compilerTemp4 .= '
				' . $__templater->formTextBoxRow(array(
			'name' => $__templater->method($__vars['regForm'], 'getFieldName', array('email_hp', )),
			'value' => '',
			'type' => 'email',
			'autocomplete' => 'off',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'email', ), false),
		), array(
			'rowclass' => 'formRow--limited',
			'label' => 'Email',
			'explain' => 'Please leave this field blank.',
		)) . '
			';
	}
	$__compilerTemp5 = '';
	if ($__vars['paidRegistrationsRefreshUrl']) {
		$__compilerTemp5 .= '
	';
		$__templater->setPageParam('head.' . 'paidRegistrationsRefreshUrl', $__templater->preEscaped('
		<script>
			window.location.href = "' . $__templater->filter($__vars['paidRegistrationsRefreshUrl'], array(array('escape', array('js', )),), true) . '";
		</script>
		<noscript>
			<meta http-equiv="refresh" content="0;url=' . $__templater->escape($__vars['paidRegistrationsRefreshUrl']) . '" />
		</noscript>
	'));
		$__compilerTemp5 .= '
';
	}
	$__vars['emailRowContents'] = $__templater->preEscaped('
	' . $__templater->callMacro('register_macros', 'email_row', array(
		'fieldName' => $__templater->method($__vars['regForm'], 'getFieldName', array('email', )),
		'value' => $__vars['fields']['email'],
	), $__vars) . '
');
	$__compilerTemp6 = '';
	if ($__vars['purchaseRequest'] AND $__vars['xf']['options']['af_paidregistrations_force_same_email']) {
		$__compilerTemp6 .= '
	';
		$__vars['emailRowContents'] = $__templater->func('trim', array($__vars['emailRowContents'], '', ), false);
		$__compilerTemp6 .= '
	' . $__templater->filter($__vars['emailRowContents'], array(array('replace', array('type="email"', 'type="email" readonly="readonly"', )),array('raw', array()),), true) . '
';
	} else {
		$__compilerTemp6 .= '
	' . $__templater->filter($__vars['emailRowContents'], array(array('raw', array()),), true) . '
';
	}
	$__compilerTemp7 = '';
	if (($__templater->func('rand', array(0, 2, ), false) == 1)) {
		$__compilerTemp7 .= '
				' . $__templater->formTextBoxRow(array(
			'name' => 'email',
			'value' => '',
			'type' => 'email',
			'autocomplete' => 'off',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'email', ), false),
		), array(
			'rowclass' => 'formRow--limited',
			'label' => 'Email',
			'explain' => 'Please leave this field blank.',
		)) . '
			';
	}
	$__compilerTemp8 = '';
	if (($__templater->func('rand', array(0, 2, ), false) == 1)) {
		$__compilerTemp8 .= '
				' . $__templater->formTextBoxRow(array(
			'name' => 'password',
			'type' => 'password',
			'autocomplete' => 'off',
		), array(
			'rowclass' => 'formRow--limited',
			'label' => 'Password',
			'explain' => 'Please leave this field blank.',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">

			' . '
			' . $__compilerTemp2 . '
' . $__templater->includeTemplate('fs_random_avatar_register', $__vars) . '

' . $__compilerTemp3 . '

' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'value' => '',
		'autocomplete' => 'off',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
	), array(
		'rowclass' => 'formRow--limited',
		'label' => 'Username',
		'explain' => 'Please leave this field blank.',
	)) . '

			' . $__templater->callMacro('register_macros', 'username_row', array(
		'fieldName' => $__templater->method($__vars['regForm'], 'getFieldName', array('username', )),
		'value' => $__vars['fields']['username'],
	), $__vars) . '

			' . '
			' . $__compilerTemp4 . '

			' . $__compilerTemp5 . '

' . '' . '
' . $__compilerTemp6 . '

			' . '
			' . $__compilerTemp7 . '

			' . '
			' . $__compilerTemp8 . '

			' . $__templater->formPasswordBoxRow(array(
		'name' => $__templater->method($__vars['regForm'], 'getFieldName', array('password', )),
		'autocomplete' => 'new-password',
		'required' => 'required',
		'checkstrength' => 'true',
	), array(
		'label' => 'Password',
		'hint' => 'Required',
	)) . '

' . $__templater->formPasswordBoxRow(array(
		'name' => 'password_confirm',
		'autocomplete' => 'new-password',
		'required' => 'required',
	), array(
		'label' => 'Confirm new password',
		'hint' => 'Required',
	)) . '

			' . $__templater->callMacro('register_macros', 'dob_row', array(), $__vars) . '

			' . $__templater->callMacro('register_macros', 'location_row', array(
		'value' => $__vars['fields']['location'],
	), $__vars) . '

			' . $__templater->callMacro('register_macros', 'custom_fields', array(), $__vars) . '

			' . $__templater->formRowIfContent($__templater->func('captcha', array(false, false)), array(
		'label' => 'Verification',
		'hint' => 'Required',
	)) . '

			' . $__templater->callMacro('register_macros', 'email_choice_row', array(), $__vars) . '

			' . $__templater->callMacro('register_macros', 'tos_row', array(), $__vars) . '
		</div>
		' . $__templater->callMacro('register_macros', 'submit_row', array(), $__vars) . '
	</div>

	' . $__templater->formHiddenVal('reg_key', $__templater->method($__vars['regForm'], 'getUniqueKey', array()), array(
	)) . '
	' . $__templater->formHiddenVal($__templater->method($__vars['regForm'], 'getFieldName', array('timezone', )), '', array(
		'data-xf-init' => 'auto-timezone',
	)) . '
', array(
		'action' => $__templater->func('link', array('register/register', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => 'reg-form',
		'data-timer' => $__vars['xf']['options']['registrationTimer'],
	));
	return $__finalCompiled;
}
);