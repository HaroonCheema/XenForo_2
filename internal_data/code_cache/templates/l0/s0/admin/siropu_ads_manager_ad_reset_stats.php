<?php
// FROM HASH: ba6543992d1b8d3988f4b7469cc3addf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['type'] == 'general') {
		$__compilerTemp1 .= '
		' . 'Reset general statistics' . $__vars['xf']['language']['label_separator'] . '
	';
	} else if ($__vars['type'] == 'daily') {
		$__compilerTemp1 .= '
		' . 'Reset daily statistics' . $__vars['xf']['language']['label_separator'] . '
	';
	} else if ($__vars['type'] == 'click') {
		$__compilerTemp1 .= '
		' . 'Reset click statistics' . $__vars['xf']['language']['label_separator'] . '
	';
	} else {
		$__compilerTemp1 .= '
		' . 'Reset statistics' . $__vars['xf']['language']['label_separator'] . '
	';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
	' . $__templater->escape($__vars['ad']['name']) . '
');
	$__finalCompiled .= '

';
	$__compilerTemp2 = '';
	if ($__vars['type']) {
		$__compilerTemp2 .= '
					' . 'Are you sure you want to reset these statistics?' . '
				';
	} else {
		$__compilerTemp2 .= '
					' . 'Are you sure you want to reset all the statistics for this ad?' . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__compilerTemp2 . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formHiddenVal('type', $__vars['type'], array(
	)) . '
		' . $__templater->formSubmitRow(array(
		'icon' => 'refresh',
		'submit' => 'Reset',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/reset-stats', $__vars['ad'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);