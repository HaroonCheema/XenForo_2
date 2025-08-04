<?php
// FROM HASH: 841b581195b53646e2708b8dcb929c5e
return array(
'macros' => array('table_list' => array(
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
		'html' => ' ' . 'Email' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Date' . ' ',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '',
	))) . '
	';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['key'] => $__vars['value']) {
			$__vars['i']++;
			$__finalCompiled .= '
		';
			$__compilerTemp1 = array(array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['value']['email']) . ' ',
			)
,array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->func('date_dynamic', array($__vars['value']['date'], array(
			))) . ' ',
			));
			if (!$__templater->test($__vars['value']['phone_no'], 'empty', array())) {
				$__compilerTemp1[] = array(
					'href' => $__templater->func('link', array('email-logs/send', $__vars['value'], ), false),
					'_type' => 'action',
					'html' => '
					' . 'Send' . '
				',
				);
			}
			$__finalCompiled .= $__templater->dataRow(array(
			), $__compilerTemp1) . '
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] E-mail logs detail');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['emailLogsDetail'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				' . $__templater->dataList('

					' . $__templater->callMacro(null, 'table_list', array(
			'data' => $__vars['emailLogsDetail'],
		), $__vars) . '

				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '

				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__vars['emailLogsDetail'], $__vars['total'], ), true) . '</span
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
		'key' => 'email-logs/detail',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>

	<div class="block-container">

		' . $__compilerTemp1 . '

	</div>


	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'email-logs/detail',
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