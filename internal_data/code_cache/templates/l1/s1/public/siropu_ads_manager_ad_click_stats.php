<?php
// FROM HASH: 01cfdbdd9d8a71e40fff5aa39f31b355
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Click statistics' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

';
	if ($__templater->test($__vars['accessKey'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->wrapTemplate('siropu_ads_manager_wrapper', $__vars);
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['ad']['settings']['click_stats']) {
		$__finalCompiled .= '
	' . $__templater->callMacro('siropu_ads_manager_ad_stats_macros', 'filter', array(
			'link' => ($__vars['accessKey'] ? $__templater->func('link', array('ads-manager/statistics/click', array('access_key' => $__vars['accessKey'], ), array('ad_id' => $__vars['ad']['ad_id'], ), ), false) : $__templater->func('link', array('ads-manager/ads/click-stats', $__vars['ad'], ), false)),
			'datePresets' => $__vars['datePresets'],
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
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp3 . '
							',
				),
				array(
					'href' => $__vars['stats']['page_url'],
					'target' => '_blank',
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['stats']['page_url']),
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
			'html' => '',
		),
		array(
			'_type' => 'cell',
			'html' => 'Page URL',
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
			'link' => ($__vars['accessKey'] ? 'ads-manager/statistics/click' : 'ads-manager/ads/click-stats'),
			'data' => array('access_key' => $__vars['accessKey'], 'ad_id' => $__vars['ad']['ad_id'], ),
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