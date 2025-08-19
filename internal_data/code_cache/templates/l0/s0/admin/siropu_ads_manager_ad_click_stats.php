<?php
// FROM HASH: 37460831a07b93bbfce938aa3cefd02a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Click statistics' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['ad'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	if ($__vars['ad']['settings']['click_stats']) {
		$__finalCompiled .= '
	';
		if (!$__templater->test($__vars['clickStats'], 'empty', array())) {
			$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('Reset', array(
				'href' => $__templater->func('link', array('ads-manager/ads/reset-stats', $__vars['ad'], array('type' => 'click', ), ), false),
				'overlay' => 'true',
				'icon' => 'refresh',
			), '', array(
			)) . '
	');
		}
		$__finalCompiled .= '

	' . $__templater->callMacro('siropu_ads_manager_ad_stats_macros', 'filter', array(
			'link' => $__templater->func('link', array('ads-manager/ads/click-stats', $__vars['ad'], ), false),
			'datePresets' => $__vars['datePresets'],
			'positions' => $__vars['positions'],
			'grouping' => false,
			'filters' => $__vars['linkParams'],
		), $__vars) . '

	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		$__compilerTemp2 = true;
		if ($__templater->isTraversable($__vars['clickStats'])) {
			foreach ($__vars['clickStats'] AS $__vars['stats']) {
				$__compilerTemp2 = false;
				$__compilerTemp1 .= '
						';
				$__compilerTemp3 = '';
				if ($__vars['stats']['image_url']) {
					$__compilerTemp3 .= '
									<img src="' . $__templater->escape($__vars['stats']['image_url']) . '" style="max-width: 200px;">
								';
				}
				$__vars['device'] = $__templater->method($__vars['stats'], 'getDevice', array());
				$__compilerTemp4 = '';
				if ($__vars['device'] == 'desktop') {
					$__compilerTemp4 .= '
									' . 'Desktop' . '
								';
				} else if ($__vars['device'] == 'tablet') {
					$__compilerTemp4 .= '
									' . 'Tablet' . '
								';
				} else if ($__vars['device'] == 'mobile') {
					$__compilerTemp4 .= '
									' . 'Mobile phone' . '
								';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['stats']['stats_date'], array(
				))),
				),
				array(
					'href' => ($__vars['stats']['position_data'] ? $__templater->func('link', array('ads-manager/positions/edit', $__vars['stats']['position_data'], ), false) : null),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['position_title']),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp3 . '
							',
				),
				array(
					'href' => $__vars['stats']['page_url'],
					'target' => '_blank',
					'class' => 'u-ltr',
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['page_url']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('username_link', array($__templater->method($__vars['stats'], 'getVisitor', array()), true, array(
					'defaultname' => 'Guest',
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . '' . '

								' . $__compilerTemp4 . '
							',
				))) . '
						';
			}
		}
		if ($__compilerTemp2) {
			$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
			), array(array(
				'colspan' => '4',
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
			'html' => '',
		),
		array(
			'_type' => 'cell',
			'html' => 'Page URL',
		),
		array(
			'_type' => 'cell',
			'html' => 'User',
		),
		array(
			'_type' => 'cell',
			'html' => 'Device',
		))) . '

					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['clickStats'], $__vars['total'], ), true) . '</span>
			</div>
		</div>
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'ads-manager/ads/click-stats',
			'data' => $__vars['ad'],
			'params' => $__vars['linkParams'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'Click statistics have not been enabled for this ad.' . '</div>
';
	}
	return $__finalCompiled;
}
);