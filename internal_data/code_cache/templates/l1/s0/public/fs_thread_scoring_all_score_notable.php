<?php
// FROM HASH: 45f3fb9cded72846abeb4993b9a70e0c
return array(
'macros' => array('record_table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'totalCounts' => '!',
		'records' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => ' ' . 'User' . ' ',
	),
	array(
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
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Total Points' . ' ',
	))) . '

	';
	if ($__templater->isTraversable($__vars['records'])) {
		foreach ($__vars['records'] AS $__vars['val']) {
			$__finalCompiled .= '
		' . $__templater->dataRow(array(
			), array(array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->func('username_link', array($__vars['val']['User'], true, array(
				'defaultname' => $__vars['val']['User']['username'],
				'itemprop' => 'name',
			))) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['totalCounts'][$__vars['val']['user_id']]['thread'] ? $__templater->func('number', array($__vars['totalCounts'][$__vars['val']['user_id']]['thread'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['totalCounts'][$__vars['val']['user_id']]['reply'] ? $__templater->func('number', array($__vars['totalCounts'][$__vars['val']['user_id']]['reply'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['totalCounts'][$__vars['val']['user_id']]['words'] ? $__templater->func('number', array($__vars['totalCounts'][$__vars['val']['user_id']]['words'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['totalCounts'][$__vars['val']['user_id']]['reactions'] ? $__templater->func('number', array($__vars['totalCounts'][$__vars['val']['user_id']]['reactions'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['totalCounts'][$__vars['val']['user_id']]['solution'] ? $__templater->func('number', array($__vars['totalCounts'][$__vars['val']['user_id']]['solution'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['totalCounts'][$__vars['val']['user_id']]['totalPoints'] ? $__templater->func('number', array($__vars['totalCounts'][$__vars['val']['user_id']]['totalPoints'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			))) . '
	';
		}
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Thread total points ');
	$__finalCompiled .= '

<div class="block">

	<div class="block-container">
		';
	if (!$__templater->test($__vars['totalCounts'], 'empty', array())) {
		$__finalCompiled .= '

			<div class="block-body">

				' . $__templater->dataList('

					' . $__templater->callMacro(null, 'record_table_list', array(
			'totalCounts' => $__vars['totalCounts'],
			'records' => $__vars['records'],
		), $__vars) . '

				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__templater->func('count', array($__vars['totalCounts'], ), false), $__templater->func('count', array($__vars['totalCounts'], ), false), ), true) . '</span
						>
				</div>

			</div>
			';
	} else {
		$__finalCompiled .= '
			<div class="blockMessage">
				' . 'No items have been created yet.' . '
			</div>
		';
	}
	$__finalCompiled .= '

	</div>
</div>

';
	return $__finalCompiled;
}
);