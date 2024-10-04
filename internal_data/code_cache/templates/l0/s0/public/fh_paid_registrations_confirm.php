<?php
// FROM HASH: e96de7dc1becc187368c6602d09a8c94
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('paidregistrations_payment_complete');
	$__finalCompiled .= '

';
	$__templater->includeCss('andy_paid_registrations.less');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body block-row paid-registrations-block-body">
			<div class="blockMessage blockMessage--success blockMessage--iconic">
				' . $__templater->formInfoRow('paidregistrations_payment_complete', array(
		'rowtype' => 'confirm',
	)) . '
			</div>
			' . 'paidregistrations_thank_you_for_your_purchase' . '
			<br /><br />
			' . $__templater->button('Register', array(
		'href' => $__templater->func('link', array('register', ), false),
		'class' => 'button--link',
	), '', array(
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);