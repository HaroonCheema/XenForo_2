<?php
// FROM HASH: 3c23e2ff79d9768e1271c0db52bab9d2
return array(
'macros' => array('table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['value']) {
			$__compilerTemp1 .= '
			' . $__templater->dataRow(array(
			), array(array(
				'href' => $__templater->func('link', array('dis-bb-codes/permissions', $__vars['value'], ), false),
				'label' => $__templater->escape($__vars['value']['bb_code_id']),
				'hint' => '[' . $__templater->escape($__vars['value']['bb_code_id']) . ']',
				'_type' => 'main',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('dis-bb-codes/permissions', $__vars['value'], ), false),
				'_type' => 'action',
				'html' => '
					' . 'Permissions' . '
				',
			))) . '
		';
		}
	}
	$__finalCompiled .= $__templater->dataList('
		' . $__compilerTemp1 . '
	', array(
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Built In BB Codes');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				' . $__templater->dataList('

					' . $__templater->callMacro(null, 'table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '

				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__vars['totalReturn'], $__vars['total'], ), true) . '</span
						>
				</div>

			</div>
			';
	} else {
		$__compilerTemp1 .= '
			<div class="block-body block-row">' . 'No items have been created yet.' . '</div>

		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'dis-bb-codes',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>

	<div class="block-container">

		' . $__compilerTemp1 . '

	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'dis-bb-codes',
		'wrapperclass' => 'block',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array($__vars['prefix'] . '/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '
';
	return $__finalCompiled;
}
);