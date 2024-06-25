<?php
// FROM HASH: 746856a88009ee330f9df6c6281941bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Gift ' . $__templater->escape($__vars['upgrade']['title']) . ' to a user');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'name' => 'anonymous',
		'label' => 'Send gift anonymously',
		'hint' => 'Checking this option will not reveal your identity to the user you are gifting.',
		'_type' => 'option',
	));
	if ($__templater->method($__vars['xf']['visitor'], 'canGiftForFree', array())) {
		$__compilerTemp1[] = array(
			'name' => 'gift_for_free',
			'label' => 'Gift for free',
			'hint' => 'Checking this will bestow this upgrade upon the user but won\'t charge them or you for it.',
			'_type' => 'option',
		);
	}
	$__compilerTemp2 = '';
	if ($__vars['coupon']) {
		$__compilerTemp2 .= $__templater->formHiddenVal('coupon', $__vars['coupon'], array(
		));
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow($__templater->escape($__vars['upgrade']['title']) . ' (' . $__templater->escape($__templater->method($__vars['upgrade'], 'getGiftCostPhrase', array())) . ')', array(
		'label' => 'Upgrade',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'ac' => 'single',
		'autocomplete' => 'off',
		'required' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		'placeholder' => 'Name' . $__vars['xf']['language']['ellipsis'],
		'autofocus' => 'on',
	), array(
		'label' => 'Gift to',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), $__compilerTemp1, array(
	)) . '
			
			' . $__templater->formHiddenVal('confirmed', '1', array(
	)) . '
			' . $__templater->formHiddenVal('payment_profile_id', $__vars['profileId'], array(
	)) . '
			' . $__templater->formHiddenVal('gift', '1', array(
	)) . '
			' . $__templater->formHiddenVal('cost_amount', $__vars['upgrade']['cost_amount'], array(
	)) . '
			' . $__compilerTemp2 . '
		</div>
		
		' . $__templater->formSubmitRow(array(
		'submit' => 'Continue' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('purchase', $__vars['upgrade'], array('user_upgrade_id' => $__vars['upgrade']['user_upgrade_id'], ), ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);