<?php
// FROM HASH: 825801829ba1cc30bccf9661db945516
return array(
'macros' => array('record_table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => '!',
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
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['val']) {
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
				'html' => ' ' . ($__vars['val']['threads_score'] ? $__templater->func('number', array($__vars['val']['threads_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['reply_score'] ? $__templater->func('number', array($__vars['val']['reply_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['worlds_score'] ? $__templater->func('number', array($__vars['val']['worlds_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['reactions_score'] ? $__templater->func('number', array($__vars['val']['reactions_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['solutions_score'] ? $__templater->func('number', array($__vars['val']['solutions_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__vars['val']['total_score'] ? $__templater->func('number', array($__vars['val']['total_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) : 'N/A') . ' ',
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Users of month');
	$__finalCompiled .= '

<div class="block">

	<div class="block-container">
		';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__finalCompiled .= '

			<div class="block-body">

				' . $__templater->dataList('

					' . $__templater->callMacro(null, 'record_table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '

				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__templater->func('count', array($__vars['data'], ), false), $__templater->func('count', array($__vars['data'], ), false), ), true) . '</span
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