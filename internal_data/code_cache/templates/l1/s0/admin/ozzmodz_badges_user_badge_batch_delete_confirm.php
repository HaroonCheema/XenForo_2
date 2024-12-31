<?php
// FROM HASH: 27dea342715632258390e6f9a161ce53
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['userBadgeIds'])) {
		foreach ($__vars['userBadgeIds'] AS $__vars['userBadgeId']) {
			$__compilerTemp1 .= '
			' . $__templater->formHiddenVal('user_badge_ids[]', $__vars['userBadgeId'], array(
			)) . '
		';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
				<strong>' . 'Badges' . ' (' . $__templater->escape($__vars['total']) . ')</strong>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		
		' . $__templater->formHiddenVal('action', 'delete', array(
	)) . '
		' . $__templater->formHiddenVal('action_confirm', '1', array(
	)) . '
		
		' . $__compilerTemp1 . '
		
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges-user-badge/batch-update', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);