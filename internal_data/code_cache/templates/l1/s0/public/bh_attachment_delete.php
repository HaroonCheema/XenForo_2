<?php
// FROM HASH: 50e49a052a37caca5e9091aed1e19ba1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['attachment']) {
		$__compilerTemp1 .= '
					' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
					<strong><a href="' . $__templater->func('link', array('bh-recent-photos/view', $__vars['attachment'], ), true) . '">' . $__templater->escape($__vars['attachment']['filename']) . '</a></strong>
				';
	} else {
		$__compilerTemp1 .= '
					' . 'Please confirm that you want to delete the ' . $__templater->func('count', array($__vars['attachmentIds'], ), true) . ' selected attached files.' . '
				';
	}
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['attachmentIds'])) {
		foreach ($__vars['attachmentIds'] AS $__vars['attachmentId']) {
			$__compilerTemp2 .= '
		' . $__templater->formHiddenVal('attachment_ids[]', $__vars['attachmentId'], array(
			)) . '
	';
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

	' . $__compilerTemp2 . '

', array(
		'action' => $__templater->func('link', array('bh-recent-photos/delete', null, $__vars['linkFilters'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);