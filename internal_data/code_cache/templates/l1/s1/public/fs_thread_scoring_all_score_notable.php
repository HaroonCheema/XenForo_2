<?php
// FROM HASH: 730130757a59609cad20d0dd49e0f17c
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
				'html' => ' ' . ($__templater->escape($__vars['totalCounts'][$__vars['val']['user_id']]['thread']) ?: 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['totalCounts'][$__vars['val']['user_id']]['reply']) ?: 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['totalCounts'][$__vars['val']['user_id']]['words']) ?: 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['totalCounts'][$__vars['val']['user_id']]['reactions']) ?: 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['totalCounts'][$__vars['val']['user_id']]['solution']) ?: 'N/A') . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . ($__templater->escape($__vars['totalCounts'][$__vars['val']['user_id']]['totalPoints']) ?: 'N/A') . ' ',
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