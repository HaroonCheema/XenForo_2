<?php
// FROM HASH: a66abf95907870e67d858006bac3b64d
return array(
'macros' => array('filter' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'link' => '!',
		'datePresets' => '!',
		'positions' => '!',
		'grouping' => true,
		'filters' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array(array(
		'label' => 'Date presets' . $__vars['xf']['language']['label_separator'],
		'_type' => 'option',
	));
	$__compilerTemp1[] = array(
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp2]['options'] = $__templater->mergeChoiceOptions($__compilerTemp1[$__compilerTemp2]['options'], $__vars['datePresets']);
	$__compilerTemp1[$__compilerTemp2]['options'][] = array(
		'value' => '1995-01-01',
		'label' => 'All time',
		'_type' => 'option',
	);
	$__compilerTemp3 = array(array(
		'label' => 'Position',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['positions'])) {
		foreach ($__vars['positions'] AS $__vars['position']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['position']['position_id'],
				'label' => $__templater->escape($__vars['position']['title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp4 = '';
	if ($__vars['grouping']) {
		$__compilerTemp4 .= '
						<span class="inputGroup-splitter"></span>
						' . $__templater->formSelect(array(
			'name' => 'grouping',
			'class' => 'input--autoSize',
			'value' => ($__vars['filters']['grouping'] ?: 'daily'),
		), array(array(
			'value' => 'hourly',
			'label' => 'Hourly',
			'_type' => 'option',
		),
		array(
			'value' => 'daily',
			'label' => 'Daily',
			'_type' => 'option',
		),
		array(
			'value' => 'monthly',
			'label' => 'Monthly',
			'_type' => 'option',
		))) . '
					';
	}
	$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body block-row">
				<div class="inputGroup inputGroup--auto">
					' . $__templater->formDateInput(array(
		'name' => 'start',
		'placeholder' => 'Since date...',
		'value' => ($__vars['filters']['start'] ? $__templater->func('date', array($__vars['filters']['start'], 'picker', ), false) : ''),
	)) . '
					<span class="inputGroup-text">-</span>
					' . $__templater->formDateInput(array(
		'name' => 'end',
		'placeholder' => 'Until date...',
		'value' => ($__vars['filters']['end'] ? $__templater->func('date', array($__vars['filters']['end'], 'picker', ), false) : ''),
	)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->formSelect(array(
		'name' => 'date_preset',
		'class' => 'input--autoSize',
		'value' => ($__vars['filters']['date_preset'] ? $__templater->func('date', array($__vars['filters']['date_preset'], 'picker', ), false) : ''),
	), $__compilerTemp1) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->formSelect(array(
		'name' => 'position_id',
		'class' => 'input--autoSize',
		'value' => $__vars['filters']['position_id'],
	), $__compilerTemp3) . '
					' . $__compilerTemp4 . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->button('Filter', array(
		'type' => 'submit',
	), '', array(
	)) . '
				</div>
			</div>
		</div>
	', array(
		'action' => $__vars['link'],
		'class' => 'block',
	)) . '
';
	return $__finalCompiled;
}
),
'ad_stats' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
		'total' => '',
		'header' => 'Top performing ads',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			';
	if ($__vars['header']) {
		$__finalCompiled .= '
				<h2 class="block-header">' . $__templater->escape($__vars['header']) . '</h2>
			';
	}
	$__finalCompiled .= '
			<div class="block-body">
				';
	$__compilerTemp1 = '';
	$__compilerTemp2 = true;
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__compilerTemp2 = false;
			$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
				'hash' => $__vars['ad']['ad_id'],
				'href' => $__templater->func('link', array('ads-manager/ads/edit', $__vars['ad'], ), false),
				'label' => $__templater->escape($__vars['ad']['name']),
				'delete' => $__templater->func('link', array('ads-manager/ads/delete', $__vars['ad'], ), false),
				'dir' => 'auto',
			), array(array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['ad']['view_count']),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['ad']['click_count']),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['ad']['ctr']) . '%',
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->func('sam_status_phrase', array($__vars['ad']['status'], ), true),
			),
			array(
				'width' => '5%',
				'class' => 'dataList-cell--separated',
				'_type' => 'cell',
				'html' => '
								' . $__templater->button('', array(
				'class' => 'button--link button--iconOnly menuTrigger',
				'data-xf-click' => 'menu',
				'aria-label' => 'More options',
				'aria-expanded' => 'false',
				'aria-haspopup' => 'true',
				'fa' => 'fas fa-chart-bar',
			), '', array(
			)) . '
								<div class="menu" data-menu="menu" aria-hidden="true">
									<div class="menu-content">
										<a href="' . $__templater->func('link', array('ads-manager/ads/general-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'General statistics' . '</a>
										<a href="' . $__templater->func('link', array('ads-manager/ads/daily-stats', $__vars['ad'], ), true) . '" class="menu-linkRow">' . 'Daily statistics' . '</a>
										<a href="' . $__templater->func('link', array('ads-manager/ads/click-stats', $__vars['ad'], ), true) . '" class="menu-linkRow">' . 'Click statistics' . '</a>
									</div>
								</div>
							',
			),
			array(
				'width' => '5%',
				'class' => 'dataList-cell--separated',
				'_type' => 'cell',
				'html' => '
								' . $__templater->button('', array(
				'class' => 'button--link button--iconOnly menuTrigger',
				'data-xf-click' => 'menu',
				'aria-label' => 'More options',
				'aria-expanded' => 'false',
				'aria-haspopup' => 'true',
				'fa' => 'fas fa-cog',
			), '', array(
			)) . '
								<div class="menu" data-menu="menu" aria-hidden="true">
									<div class="menu-content">
										<a href="' . $__templater->func('link', array('ads-manager/ads/clone', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Clone' . '</a>
										<a href="' . $__templater->func('link', array('ads-manager/ads/embed', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Embed' . '</a>
										<a href="' . $__templater->func('link', array('ads-manager/ads/export', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>
									</div>
								</div>
							',
			))) . '
						';
		}
	}
	if ($__compilerTemp2) {
		$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
			'rowclass' => 'dataList-row--noHover dataList-row--note',
		), array(array(
			'colspan' => '5',
			'class' => 'dataList-cell--noSearch',
			'_type' => 'cell',
			'html' => 'No items have been found for statistics.',
		))) . '
					';
	}
	$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => 'Ad name',
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
	),
	array(
		'_type' => 'cell',
		'html' => 'Status',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '&nbsp;',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '&nbsp;',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '&nbsp;',
	))) . '
					' . $__compilerTemp1 . '
				', array(
	)) . '
			</div>
			';
	if (!$__templater->test($__vars['total'], 'empty', array())) {
		$__finalCompiled .= '
				<div class="block-footer">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['ads'], $__vars['total'], ), true) . '</span>
				</div>
			';
	}
	$__finalCompiled .= '
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);