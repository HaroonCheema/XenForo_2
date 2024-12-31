<?php
// FROM HASH: 52e9d5c79f421d95ce89506b97e84469
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
				' . 'Please confirm that you want to delete the ' . $__templater->func('count', array($__vars['badgeIds'], ), true) . ' selected badges.' . '
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
	
	' . $__templater->formHiddenVal('action', 'delete', array(
	)) . '
	' . $__templater->formHiddenVal('action_confirm', '1', array(
	)) . '

	' . $__templater->func('redirect_input', array(null, null, true)) . '

', array(
		'action' => $__templater->func('link', array('ozzmodz-badges/batch-update', ), false),
		'class' => 'block',
		'ajax' => 'true',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);