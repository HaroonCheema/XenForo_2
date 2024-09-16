<?php
// FROM HASH: f59291756ea8f9b6001573b482f3a2ca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('prefix(\'thread\', $thread, \'escaped\') }}' . $__templater->escape($__vars['thread']['title']) . ' - ' . 'Rate this thread');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . ' - ' . 'Rate this thread');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread']['Forum'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__vars['xf']['visitor']['user_id']) {
		$__compilerTemp1 .= '
				' . $__templater->formTextBoxRow(array(
			'name' => 'username',
			'autofocus' => 'autofocus',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		), array(
			'label' => 'Your name',
		)) . '

				' . $__templater->formTextBoxRow(array(
			'name' => 'email',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'email', ), false),
			'type' => 'email',
		), array(
			'label' => 'Your email address',
		)) . '

				' . $__templater->formRowIfContent($__templater->func('captcha', array(false, false)), array(
			'label' => 'Verification',
		)) . '
				<hr class="formRowSep" />
			';
	}
	$__compilerTemp2 = '';
	if ($__vars['xf']['visitor']['user_id'] AND $__templater->method($__vars['thread'], 'canSendAnonymous', array())) {
		$__compilerTemp2 .= '
				' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'is_anonymous',
			'selected' => $__vars['rating']['is_anonymous'],
			'label' => 'Submit a review as an anonymously',
			'hint' => 'If you tick this box, the only author of the thread or moderators can see who ratings.',
			'_type' => 'option',
		)), array(
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '

			' . $__templater->callMacro('BRATR_rating_macros', 'rating', array(
		'currentRating' => $__vars['rating']['rating'],
	), $__vars) . '

			' . $__templater->formEditorRow(array(
		'name' => 'message',
		'data-min-height' => '100',
	), array(
		'label' => 'Message',
		'hint' => ($__templater->method($__vars['thread'], 'isMessageRequired', array()) ? 'Required' : ''),
		'explain' => 'Explain why you\'re giving this rating. Reviews which are not constructive may be removed without notice.',
	)) . '


			' . $__compilerTemp2 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Submit rating',
		'icon' => 'rate',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('threads/br-rate', $__vars['thread'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);