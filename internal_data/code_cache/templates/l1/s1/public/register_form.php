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
	$__templater->inlineJs('
if(!window.jQuery){
    let script = document.createElement(\'script\');
    document.head.appendChild(script);
    script.type = \'text/javascript\';
    script.src = "//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js";
    await script.onload
}
');
	$__templater->inlineJs('
$(document).ready(function() {







  var phoneInputID = "#phone";
  var input = document.querySelector(phoneInputID);
  var iti = window.intlTelInput(input, {
    formatOnDisplay: true,
    geoIpLookup: function(callback) {
       $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
         var countryCode = (resp && resp.country) ? resp.country : "";
         callback(countryCode);
       });
    },
    hiddenInput: "full_number",
    initialCountry: "auto",
    separateDialCode: true,
    searchCountryField:true,
    countrySearch:true,
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
  });
  input.addEventListener(\'input\', function() {
    var fullNumber = iti.getNumber();
    document.getElementById(\'phone2\').value = fullNumber;
  });


  input.addEventListener("countrychange", function() {
    var fullNumber = iti.getNumber();
    document.getElementById(\'phone2\').value = fullNumber;
});


// on click button: validate
  var buttonInputID = "#js-signUpButton";
  var button= document.querySelector(buttonInputID);

button.addEventListener(\'click\', (evt) => {

  var phoneInputID = "#phone2";
  var input = document.querySelector(phoneInputID);

if (input.value.trim()) {
    if (iti.isValidNumber()) {
    $(\'#space\').remove();
    } else {
     alert("Invalid phoneNumber");
	$(\'#phone\').after(\'<span id="space" style="color:red">invalid number</span>\');
	
evt.preventDefault();
    }
  }

});

});


 ');
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

			' . $__templater->callMacro('register_macros', 'dob_row', array(), $__vars) . '

			' . $__templater->callMacro('register_macros', 'location_row', array(
		'value' => $__vars['fields']['location'],
	), $__vars) . '

			' . $__templater->callMacro('register_macros', 'custom_fields', array(), $__vars) . '
' . '' . '
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
   <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

	' . $__templater->formTextBoxRow(array(
		'id' => 'phone',
		'type' => 'tel',
		'name' => 'phone',
	), array(
		'label' => 'Phone Number',
		'explain' => 'It is for verification purposes only and will NOT be displayed to the public.',
	)) . '
<input type="hidden" id="phone2" name="phone_full" />

' . '' . '

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