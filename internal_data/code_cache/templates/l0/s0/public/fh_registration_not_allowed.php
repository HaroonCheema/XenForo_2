<?php
// FROM HASH: 80e4a6e753c9305e9a7b262522f24f07
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Registration Without Payment');
	$__finalCompiled .= '

';
	$__templater->includeCss('andy_paid_registrations.less');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body block-row paid-registrations-block-body">
			<div class="blockMessage blockMessage--important blockMessage--iconic">
				' . $__templater->formInfoRow('Registration Without Payment', array(
		'rowtype' => 'confirm',
	)) . '
			</div>
			' . 'Registration with out payment is not allowed. To registration, please click the button below.' . '
			<br /><br />
			' . $__templater->button('Register', array(
		'href' => $__templater->func('link', array('paidregistrations', ), false),
		'class' => 'button--link',
	), '', array(
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);