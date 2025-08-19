<?php
// FROM HASH: 074c405ef3d0acd17899729e94343ac8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Click fraud monitor');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Here you can monitor click fraud for the ads that have the option enabled.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'name' => 'ip',
		'value' => ($__vars['linkFilters']['ip'] ?: ''),
		'placeholder' => 'IP',
		'type' => 'search',
		'class' => 'input--inline',
	)) . '
			' . $__templater->button('', array(
		'type' => 'submit',
		'icon' => 'search',
	), '', array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/tools/click-fraud-monitor', ), false),
		'class' => 'block',
	)) . '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	$__compilerTemp2 = true;
	if ($__templater->isTraversable($__vars['entries'])) {
		foreach ($__vars['entries'] AS $__vars['entry']) {
			$__compilerTemp2 = false;
			$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
				'delete' => $__templater->func('link', array('ads-manager/ads/deblock-ip', $__vars['entry']['Ad'], array('ip' => $__templater->filter($__vars['entry']['ip'], array(array('ip', array()),), false), 'return' => 'monitor', ), ), false),
			), array(array(
				'href' => $__templater->func('link', array('ads-manager/ads/details', $__vars['entry']['Ad'], ), false),
				'overlay' => 'true',
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['entry']['Ad']['name']),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->func('date_dynamic', array($__vars['entry']['log_date'], array(
			))),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->filter($__vars['entry']['ip'], array(array('ip', array()),), true),
			),
			array(
				'_type' => 'cell',
				'html' => ($__templater->escape($__vars['entry']['page_url']) ?: 'N/A'),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['entry']['Ad']['settings']['click_fraud']['click_limit']),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['entry']['click_count']),
			),
			array(
				'_type' => 'cell',
				'html' => ($__templater->method($__vars['entry'], 'isIpBlocked', array()) ? $__templater->func('date_time', array($__vars['entry']['ip_blocked'], ), true) : 'No'),
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
		'width' => '25%',
		'_type' => 'cell',
		'html' => 'Ad name',
	),
	array(
		'_type' => 'cell',
		'html' => 'Date',
	),
	array(
		'_type' => 'cell',
		'html' => 'IP',
	),
	array(
		'_type' => 'cell',
		'html' => 'Page URL',
	),
	array(
		'_type' => 'cell',
		'html' => 'Click limit',
	),
	array(
		'_type' => 'cell',
		'html' => 'Click count',
	),
	array(
		'_type' => 'cell',
		'html' => 'IP blocked',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '&nbsp;',
	))) . '

				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['entries'], $__vars['total'], ), true) . '</span>
		</div>
	</div>
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'ads-manager/tools/click-fraud-monitor',
		'params' => $__vars['linkFilters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);