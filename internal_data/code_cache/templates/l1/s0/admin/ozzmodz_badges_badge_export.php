<?php
// FROM HASH: 61a0021293a4133c25a2e43423201409
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['badgeIds'])) {
		foreach ($__vars['badgeIds'] AS $__vars['badgeId']) {
			$__compilerTemp1 .= '
		' . $__templater->formHiddenVal('badge_ids[]', $__vars['badgeId'], array(
			)) . '
	';
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to export the ' . $__templater->func('count', array($__vars['badgeIds'], ), true) . ' selected badges.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

	' . $__compilerTemp1 . '

	' . $__templater->func('redirect_input', array(null, null, true)) . '

', array(
		'action' => $__templater->func('link', array('ozzmodz-badges/export', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);