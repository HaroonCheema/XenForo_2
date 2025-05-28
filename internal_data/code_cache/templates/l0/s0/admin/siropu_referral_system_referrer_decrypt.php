<?php
// FROM HASH: 0b851b8a044154e346377db0e33b769e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Decrypt referrer ID');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'name' => 'referrer_id',
		'placeholder' => 'Encrypted ID',
		'class' => 'input--inline',
		'required' => 'required',
	)) . '
			' . $__templater->button('Decrypt', array(
		'type' => 'submit',
	), '', array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('referral-system/referrer/decrypt', ), false),
		'class' => 'block',
	)) . '

';
	if ($__vars['userId']) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body block-row">
				' . 'User ID' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['userId']);
		if ($__vars['user']) {
			$__finalCompiled .= ', ' . 'User' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('username_link', array($__vars['user'], true, array(
			)));
		}
		$__finalCompiled .= '
			</div>
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);