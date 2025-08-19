<?php
// FROM HASH: eb437631442c47596c0ba587daa61ccd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Daily statistics' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['ad'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	if ($__vars['ad']['settings']['daily_stats']) {
		$__finalCompiled .= '
	';
		if (!$__templater->test($__vars['dailyStats'], 'empty', array())) {
			$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('Reset', array(
				'href' => $__templater->func('link', array('ads-manager/ads/reset-stats', $__vars['ad'], array('type' => 'daily', ), ), false),
				'overlay' => 'true',
				'icon' => 'refresh',
			), '', array(
			)) . '
	');
		}
		$__finalCompiled .= '

	' . $__templater->callMacro('public:siropu_ads_manager_ad_stats_macros', 'totals', array(
			'ad' => $__vars['ad'],
		), $__vars) . '

	' . $__templater->callMacro('siropu_ads_manager_ad_stats_macros', 'filter', array(
			'link' => $__templater->func('link', array('ads-manager/ads/daily-stats', $__vars['ad'], ), false),
			'datePresets' => $__vars['datePresets'],
			'positions' => $__vars['positions'],
			'groupBy' => $__vars['groupBy'],
			'filters' => $__vars['linkParams'],
		), $__vars) . '

	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		$__compilerTemp2 = true;
		if ($__templater->isTraversable($__vars['dailyStats'])) {
			foreach ($__vars['dailyStats'] AS $__vars['stats']) {
				$__compilerTemp2 = false;
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['date']),
				),
				array(
					'href' => ($__vars['stats']['position_data'] ? $__templater->func('link', array('ads-manager/positions/edit', $__vars['stats']['position_data'], ), false) : null),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['position_title']),
				),
				array(
					'class' => 'samViewCount',
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['view_count']),
				),
				array(
					'class' => 'samClickCount',
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['click_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['ctr']) . '%',
				))) . '
						';
			}
		}
		if ($__compilerTemp2) {
			$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
			), array(array(
				'colspan' => '5',
				'_type' => 'cell',
				'html' => 'No entries have been logged.',
			))) . '
					';
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Date',
		),
		array(
			'_type' => 'cell',
			'html' => 'Position',
		),
		array(
			'_type' => 'cell',
			'html' => $__templater->func('sam_views_impressions_phrase', array(), true),
		),
		array(
			'_type' => 'cell',
			'html' => 'Clicks',
		),
		array(
			'_type' => 'cell',
			'html' => 'CTR',
		))) . '

					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['dailyStats'], $__vars['total'], ), true) . '</span>
			</div>
		</div>
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'ads-manager/ads/daily-stats',
			'data' => $__vars['ad'],
			'params' => $__vars['linkParams'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'Daily statistics have not been enabled for this ad.' . '</div>
';
	}
	return $__finalCompiled;
}
);