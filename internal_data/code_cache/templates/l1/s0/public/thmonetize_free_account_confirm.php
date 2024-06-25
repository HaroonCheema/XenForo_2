<?php
// FROM HASH: 8a3ab2ad13a76c5a5858b5744a1e5510
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . 'Confirm free account' . '
');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<div class="block-row">
				' . 'By choosing a free account, you may miss valuable perks and offers around the platform and may have limited access to our services. But don\'t worry, you can upgrade your account anytime later, should you decide to change your mind!' . '
			</div>
		</div>
		' . $__templater->formHiddenVal('confirm', '1', array(
	)) . '
		' . $__templater->formSubmitRow(array(
		'icon' => 'confirm',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('thmonetize-free-account', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);