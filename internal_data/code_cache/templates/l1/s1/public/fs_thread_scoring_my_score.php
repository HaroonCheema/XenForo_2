<?php
// FROM HASH: e681c5cc3d6090def02df6c29f28b653
return array(
'macros' => array('record_table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'totalCounts' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => ' ' . 'Thread Score' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Reply Score' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Words score' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Reactions score' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Solutions score' . ' ',
	))) . '

	';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['totalCounts'])) {
		foreach ($__vars['totalCounts'] AS $__vars['val']) {
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['thread'] ? $__templater->func('number', array($__vars['val']['thread'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['reply'] ? $__templater->func('number', array($__vars['val']['reply'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['words'] ? $__templater->func('number', array($__vars['val']['words'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['reactions'] ? $__templater->func('number', array($__vars['val']['reactions'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['solution'] ? $__templater->func('number', array($__vars['val']['solution'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			);
		}
	}
	$__finalCompiled .= $__templater->dataRow(array(
	), $__compilerTemp1) . '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">

	<div class="block-container">

		<div class="block-body">

			';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['totalCounts'], 'empty', array())) {
		$__compilerTemp1 .= '

					' . $__templater->callMacro(null, 'record_table_list', array(
			'totalCounts' => $__vars['totalCounts'],
		), $__vars) . '

					';
	} else {
		$__compilerTemp1 .= '
					<div class="blockMessage">
						' . 'No items have been created yet.' . '
					</div>
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>

	</div>
</div>

';
	return $__finalCompiled;
}
);