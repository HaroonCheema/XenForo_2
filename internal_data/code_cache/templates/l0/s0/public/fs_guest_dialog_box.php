<?php
// FROM HASH: 16310a6a69120e8ca25af88b3d941a37
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Guest Feature Sponsored by D Mark Performance (with the link included).');
	$__finalCompiled .= '

' . $__templater->form('

	<div class="block-container">
		
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'email',
		'type' => 'email',
		'autocomplete' => 'email',
		'required' => 'required',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'email', ), false),
	), array(
		'label' => 'Email',
		'hint' => 'Required',
	)) . '
		</div>
		
		' . $__templater->formSubmitRow(array(
	), array(
		'html' => '
				' . $__templater->button('
					' . 'Submit' . '
				', array(
		'type' => 'submit',
		'class' => 'button--primary',
		'icon' => 'save',
	), '', array(
	)) . '
			',
	)) . '
		
	</div>

', array(
		'action' => $__templater->func('link', array('threads/guest-email', $__vars['thread'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);