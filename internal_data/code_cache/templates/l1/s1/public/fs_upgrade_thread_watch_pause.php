<?php
// FROM HASH: 5db4b426db9df038ac1c9982e5d6b148
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['isPaused']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Unpause Upgrade');
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Pause Upgrade');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['isPaused']) {
		$__compilerTemp1 .= '
				' . $__templater->formInfoRow('
					' . 'Are you sure you want to unwatch this thread?' . '
				', array(
			'rowtype' => 'confirm',
		)) . '

				' . $__templater->formHiddenVal('stop', '1', array(
		)) . '
				';
	} else {
		$__compilerTemp1 .= '
				' . $__templater->formInfoRow('
					' . 'Are you sure you want to unwatch this thread?' . '
				', array(
			'rowtype' => 'confirm',
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__vars['isPaused']) {
		$__compilerTemp2 .= '
			' . $__templater->formSubmitRow(array(
			'submit' => 'Unpause',
		), array(
			'rowtype' => 'simple',
		)) . '
			';
	} else {
		$__compilerTemp2 .= '
			' . $__templater->formSubmitRow(array(
			'submit' => 'Pause',
		), array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '

			' . $__templater->formHiddenVal('itsPause', '1', array(
	)) . '
		</div>
		' . $__compilerTemp2 . '
	</div>
', array(
		'action' => $__templater->func('link', array('members/pause', $__vars['user'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);