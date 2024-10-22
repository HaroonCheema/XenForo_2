<?php
// FROM HASH: 589c1cf938c70d337ccd26213e38e0f4
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
				'html' => ' ' . ($__templater->escape($__vars['val']['thread']) ?: 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['val']['reply']) ?: 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['val']['words']) ?: 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['val']['reactions']) ?: 'N/A') . ' ',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['val']['solution']) ?: 'N/A') . ' ',
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