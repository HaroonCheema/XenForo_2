<?php
// FROM HASH: fd5021c4506e05558a059eed9baf59bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['statsAccess']['title']));
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__compilerTemp1 .= '
					<tbody class="dataList-rowGroup">
						';
			$__compilerTemp2 = '';
			if ($__vars['ad']['view_limit']) {
				$__compilerTemp2 .= '/' . $__templater->escape($__vars['ad']['view_limit']);
			}
			$__compilerTemp3 = '';
			if ($__vars['ad']['click_limit']) {
				$__compilerTemp3 .= '/' . $__templater->escape($__vars['ad']['click_limit']);
			}
			$__compilerTemp4 = '';
			$__compilerTemp5 = '';
			$__compilerTemp5 .= '
												';
			if ($__vars['ad']['Package'] AND $__vars['ad']['Package']['settings']['daily_stats']) {
				$__compilerTemp5 .= '
													<a href="' . $__templater->func('link', array('ads-manager/statistics/daily', $__vars['statsAccess'], array('ad_id' => $__vars['ad']['ad_id'], ), ), true) . '" class="menu-linkRow">' . 'Daily statistics' . '</a>
												';
			}
			$__compilerTemp5 .= '
												';
			if ($__vars['ad']['Package'] AND $__vars['ad']['Package']['settings']['click_stats']) {
				$__compilerTemp5 .= '
													<a href="' . $__templater->func('link', array('ads-manager/statistics/click', $__vars['statsAccess'], array('ad_id' => $__vars['ad']['ad_id'], ), ), true) . '" class="menu-linkRow">' . 'Click statistics' . '</a>
												';
			}
			$__compilerTemp5 .= '
											';
			if (strlen(trim($__compilerTemp5)) > 0) {
				$__compilerTemp4 .= '
									' . $__templater->button('
										' . $__templater->fontAwesome('far fa-chart-bar', array(
				)) . '
									', array(
					'class' => 'button--link menuTrigger',
					'data-xf-click' => 'menu',
					'aria-label' => 'More options',
					'aria-expanded' => 'false',
					'aria-haspopup' => 'true',
				), '', array(
				)) . '
									<div class="menu" data-menu="menu" aria-hidden="true">
										<div class="menu-content">
											' . $__compilerTemp5 . '
										</div>
									</div>
								';
			}
			$__compilerTemp1 .= $__templater->dataRow(array(
				'label' => $__templater->escape($__vars['ad']['name']),
				'explain' => $__templater->func('date', array($__vars['ad']['create_date'], ), true),
			), array(array(
				'_type' => 'cell',
				'html' => $__templater->escape($__templater->method($__vars['ad'], 'getTypePhrase', array())),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['ad']['view_count']) . $__compilerTemp2,
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['ad']['click_count']) . $__compilerTemp3,
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
				'width' => '1%',
				'_type' => 'cell',
				'html' => '
								' . $__compilerTemp4 . '
							',
			))) . '
					</tbody>
				';
		}
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => 'Ad',
	),
	array(
		'_type' => 'cell',
		'html' => 'Type',
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
		'_type' => 'cell',
		'html' => '',
	))) . '
				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);