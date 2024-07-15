<?php
// FROM HASH: 0e4c877cd9b0a1fb3996b40860f6130a
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Rules');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['xf']['options']['registrationTimer']) {
		$__compilerTemp1 .= '
					<span id="js-regTimer" data-timer-complete="' . $__templater->filter('Accept', array(array('for_attr', array()),), true) . '">
						' . $__vars['xf']['language']['parenthesis_open'] . 'Please wait ' . ('<span>' . $__templater->escape($__vars['xf']['options']['registrationTimer']) . '</span>') . ' second(s).' . $__vars['xf']['language']['parenthesis_close'] . '
					</span>
					';
	} else {
		$__compilerTemp1 .= '
					' . 'Accept' . '
				';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body" style="overflow: auto; height: 500px;">
			' . $__templater->formInfoRow('
			' . '<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>' . '
			', array(
	)) . '
			' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'accept',
		'required' => 'required',
		'label' => '<b>I have read, and agree to rules.</b>',
		'_type' => 'option',
	)), array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
	), array(
		'html' => '
			' . $__templater->button('
				' . $__compilerTemp1 . '
			', array(
		'type' => 'submit',
		'class' => 'button--primary',
		'id' => 'js-signUpButton',
	), '', array(
	)) . '
			',
	)) . '
	</div>

', array(
		'action' => $__templater->func('link', array('register/', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => 'reg-form',
	));
	return $__finalCompiled;
}
);