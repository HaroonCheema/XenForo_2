<?php
// FROM HASH: ab39a911b656573ef416310ca0a95712
return array(
'macros' => array('record_table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
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
	$__vars['afterDot'] = $__vars['xf']['options']['fs_thread_scoring_system_decimals'];
	$__finalCompiled .= '

	' . $__templater->dataRow(array(
	), array(array(
		'_type' => 'cell',
		'html' => ' ' . $__templater->func('number', array($__vars['user']['threads_score'], $__vars['afterDot'], ), true) . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . $__templater->func('number', array($__vars['user']['reply_score'], $__vars['afterDot'], ), true) . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . $__templater->func('number', array($__vars['user']['worlds_score'], $__vars['afterDot'], ), true) . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . $__templater->func('number', array($__vars['user']['reactions_score'], $__vars['afterDot'], ), true) . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . $__templater->func('number', array($__vars['user']['solutions_score'], $__vars['afterDot'], ), true) . ' ',
	))) . '

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
	if (!$__templater->test($__vars['user'], 'empty', array())) {
		$__compilerTemp1 .= '

					' . $__templater->callMacro(null, 'record_table_list', array(
			'user' => $__vars['user'],
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