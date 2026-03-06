<?php
// FROM HASH: 2f5795c83dd835941a4a8d172bb1a51d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] Multiple route filters');
	$__finalCompiled .= '

' . '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add route filter', array(
		'href' => $__templater->func('link', array('multi-route-filters/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['routeFilters'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['routeFilters'])) {
			foreach ($__vars['routeFilters'] AS $__vars['routeFilter']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'delete' => $__templater->func('link', array('multi-route-filters/delete', $__vars['routeFilter'], ), false),
				), array(array(
					'_type' => 'cell',
					'html' => '
								' . $__templater->escape($__vars['routeFilter']['find_route_readable']) . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__templater->escape($__vars['routeFilter']['replace_route_readable']) . '
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'route-filters',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Find',
		),
		array(
			'_type' => 'cell',
			'html' => 'Replace',
		),
		array(
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '
					' . $__compilerTemp1 . '
				', array(
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['routeFilters'], ), true) . '</span>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('multi-route-filters/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
	';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);