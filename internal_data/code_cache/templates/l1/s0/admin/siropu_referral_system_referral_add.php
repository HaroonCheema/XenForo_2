<?php
// FROM HASH: 08e9783728fc62a66b51f6935e184f0c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add referral');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'referral',
		'placeholder' => 'Name' . $__vars['xf']['language']['ellipsis'],
		'data-xf-init' => 'auto-complete',
		'data-single' => 'true',
	), array(
		'label' => 'Referral',
	)) . '
			' . $__templater->formTextBoxRow(array(
		'name' => 'referrer',
		'placeholder' => 'Name' . $__vars['xf']['language']['ellipsis'],
		'data-xf-init' => 'auto-complete',
		'data-single' => 'true',
	), array(
		'label' => 'Referrer',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'submit' => 'Add referral',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('referral-system/referrals/save', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);