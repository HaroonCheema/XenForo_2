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
	if ($__vars['xf']['options']['fs_enable'] AND (!$__vars['xf']['options']['fs_use_random'])) {
		$__compilerTemp2 .= '
	' . $__templater->includeTemplate('gallery_avatar_register', $__vars) . '
';
	}
	$__compilerTemp3 = '';
	if (($__templater->func('rand', array(0, 2, ), false) == 1)) {
		$__compilerTemp3 .= '
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
	$__compilerTemp4 = '';
	if (($__templater->func('rand', array(0, 2, ), false) == 1)) {
		$__compilerTemp4 .= '
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
	$__compilerTemp5 = '';
	if (($__templater->func('rand', array(0, 2, ), false) == 1)) {
		$__compilerTemp5 .= '
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
			' . $__templater->includeTemplate('fs_random_avatar_register', $__vars) . '

' . $__compilerTemp2 . '

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
			' . $__compilerTemp3 . '

			' . $__templater->callMacro('register_macros', 'email_row', array(
		'fieldName' => $__templater->method($__vars['regForm'], 'getFieldName', array('email', )),
		'value' => $__vars['fields']['email'],
	), $__vars) . '

' . $__templater->formRow('
	' . $__templater->formSelect(array(
		'name' => 'reg_account_type',
		'required' => 'required',
	), array(array(
		'value' => '',
		'label' => 'None',
		'_type' => 'option',
	),
	array(
		'value' => 'doner',
		'label' => 'Doner',
		'_type' => 'option',
	),
	array(
		'value' => 'donee',
		'label' => 'Donee',
		'_type' => 'option',
	))) . '

', array(
		'label' => 'Account type',
		'hint' => 'Required',
	)) . '

			' . '
			' . $__compilerTemp4 . '

			' . '
			' . $__compilerTemp5 . '

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

			' . $__templater->callMacro('register_custom_fields', 'general_custom_fields_edit', array(
		'type' => 'users',
		'group' => null,
		'set' => $__vars['xf']['visitor']['Profile']['custom_fields'],
		'additionalFilters' => array('registration', ),
	), $__vars) . '
' . $__templater->formRadioRow(array(
		'name' => 'account_type',
		'value' => '',
		'id' => 'account_type',
	), array(array(
		'value' => '1',
		'label' => 'Hobbyist',
		'data-hide' => 'true',
		'selected' => true,
		'data-xf-init' => 'disabler',
		'data-container' => '.js-hobbyist',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'Companion',
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-provider',
		'_type' => 'option',
	)), array(
		'hint' => 'Required',
		'label' => 'Account Type',
	)) . '
			<div class="js-hobbyist">
				' . $__templater->formRow('<span>' . '<h3>Sign up hobbyist  / premium account</h3>
Joining our community offers a unique experience tailored to your needs. As a Premium
member, you unlock unparalleled benefits:<br>
<ul>
<li>Exclusive Content: Enjoy special access to "The Rest of the Story" (ROS) reviews,
which remain hidden from guests, regular, and female members.</li>
<li>Engage in Private Discussions: Create and browse through "Private" posts in
public forums, and immerse yourself in exclusive spaces like the Men\'s Lounge.</li>
<li>Enhanced  Messaging: Say goodbye to the basic 50-message limit. With
Premium, store up to 1,000 messages, neatly organizing them in custom folders.</li>
<li>You will gain exclusive access to a "Request an Appointment" feature, allowing you to
schedule appointments with companions more efficiently. Say goodbye to the
back-and-forth process of waiting for reference checks and date/time confirmations.
With this feature, you can directly request an appointment with the companion by
providing the necessary information and sending your request.</li>
</ul>
Moreover, as a testament to your authenticity:<br>
<ul>
<li>Verified SWB Badge: Your profile will feature an SWB badge, signifying our
verification in our community, reinforcing trust among members.<l/i>
<li>P411 Affiliation: If you\'re linked with the P411 site, we\'ll highlight this on your
profile, making your membership evident to others.</li>
</ul>
<ul>
<li>1 year: $100<l/i>
<li>6 months: $65</li>
</ul>
<br>
After you submit your verification then head over to make your payment, we will
commence the verification process. This typically requires a minimum of 24 - 48 hours
to complete.
<br><br>
To initiate your upgrade, kindly provide the required information as specified within the upgrade
subscription guidelines. Following that, you can conveniently make your payment through the
designated "Upgrade" section on our website. Elevate your experience and enjoy all the benefits
of our premium membership today!<br><br>
While registering on our platform is free and allows you to browse, please note that you will
have limited access to the site without a membership. To enjoy the full array of features and
benefits our community has to offer, a membership is essential. Southwest Board (SWB)
operates as a paid members-only site.<br><br>
We prioritize safety within our community, and our membership system helps maintain a secure
and enjoyable environment for all. Join us as a paid member to unlock the complete experience
of SWB!' . '</span>', array(
	)) . '
				' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
		'type' => 'users',
		'group' => null,
		'set' => $__templater->method($__vars['xf']['visitor']['Profile'], 'getGroupTypeFields', array('hobbyist_fields', )),
		'additionalFilters' => array('registration', ),
	), $__vars) . '
				
			</div>
			
			<div class="js-provider">
				' . $__templater->formRow('<span>' . '<strong>All independent and reputable Companions can sign up for a free SWB account under these conditions: </strong>
<ul>
<li>No agencies at this time. 
</li>
<li>Sexual content, direct or coded, is banned in SWB ads.</li>
<li>Companions must be 21+, with age verification required.</li>
<li>Any signs of minor exploitation, human trafficking, or undue control will be reported for investigation.</li>
<li>SWB aims to provide a safe environment.</li>
</ul>

While registering on our platform is free and allows you to browse, please note that you will
have limited access to the site without a membership. To enjoy the full array of features and
benefits our community has to offer, a membership is essential. Southwest Board (SWB)
operates as a paid members-only site.
<br><br>
We prioritize safety within our community, and our membership system helps maintain a secure
and enjoyable environment for all. Join us as a paid member to unlock the complete experience
of SWB!
<br><br>
Once you\'ve successfully signed up and completed the verification process, you\'ll unlock the
option to enhance your membership experience by upgrading. For a comprehensive
understanding of our membership details and the prerequisites involved, please refer to the
"General Interest" section found under "Upgrade Subscription."
<br><br>
To initiate your upgrade, kindly provide the required information as specified within the upgrade
subscription guidelines. Following that, you can conveniently make your payment through the
designated "Companion Upgrade" section on our website. Elevate your experience and enjoy all
the benefits of our VIP and premium membership today!

<b>Please ensure to check your email or spam folder after completing the registration process for further instructions on how to proceed with verification. We require all verification documents before granting access to SWB. Don\'t forget to check your email for important details.</b>' . '</span>', array(
	)) . '
				
				' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
		'type' => 'users',
		'group' => null,
		'set' => $__templater->method($__vars['xf']['visitor']['Profile'], 'getGroupTypeFields', array('provider_fields', )),
		'additionalFilters' => array('registration', ),
	), $__vars) . '		
			</div>		


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