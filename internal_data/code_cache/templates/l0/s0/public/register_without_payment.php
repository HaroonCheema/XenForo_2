<?php
// FROM HASH: a11b6961123e311c31eb500261a8da65
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Register Without Payment');
	$__finalCompiled .= '
';
	$__templater->includeCss('andy_paid_registrations.less');
	$__finalCompiled .= '
<div class="block">
	<div class="block-container">
		<div class="block-body block-row paid-registrations-block-body">
			<div class="blockMessage blockMessage--important blockMessage--iconic">
				' . $__templater->formInfoRow('Not Allow to register without payment clear.', array(
		'rowtype' => 'confirm',
	)) . '
			</div>
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