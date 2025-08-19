<?php
// FROM HASH: 704fe7b60781005adb8519ba1a4872d7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Your ads');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Create ad', array(
		'href' => $__templater->func('link', array('ads-manager/packages', ), false),
		'class' => 'button--cta',
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('siropu_ads_manager_wrapper', $__vars);
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['ads'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = array(array(
			'_type' => 'cell',
			'html' => 'Ad',
		));
		if ($__templater->method($__vars['xf']['visitor'], 'canViewGeneralStatsSiropuAdsManager', array())) {
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => $__templater->func('sam_views_impressions_phrase', array(), true),
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => 'Clicks',
			);
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => 'CTR',
			);
		}
		$__compilerTemp1[] = array(
			'_type' => 'cell',
			'html' => 'Status',
		);
		$__compilerTemp1[] = array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		);
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['ads'])) {
			foreach ($__vars['ads'] AS $__vars['ad']) {
				$__compilerTemp2 .= '
						<tbody class="dataList-rowGroup">
							';
				$__compilerTemp3 = array();
				if ($__templater->method($__vars['ad'], 'canViewGeneralStats', array())) {
					if (!$__templater->method($__vars['ad'], 'isPendingApproval', array())) {
						$__compilerTemp4 = '';
						if ($__vars['ad']['settings']['count_views']) {
							$__compilerTemp4 .= '
												' . $__templater->escape($__vars['ad']['view_count']);
							if ($__vars['ad']['view_limit']) {
								$__compilerTemp4 .= '/' . $__templater->escape($__vars['ad']['view_limit']);
							}
							$__compilerTemp4 .= '
											';
						} else {
							$__compilerTemp4 .= '
												' . 'N/A' . '
											';
						}
						$__compilerTemp3[] = array(
							'width' => '10%',
							'_type' => 'cell',
							'html' => '
											' . $__compilerTemp4 . '
										',
						);
						$__compilerTemp5 = '';
						if ($__vars['ad']['settings']['count_views']) {
							$__compilerTemp5 .= '
												' . $__templater->escape($__vars['ad']['click_count']);
							if ($__vars['ad']['click_limit']) {
								$__compilerTemp5 .= '/' . $__templater->escape($__vars['ad']['click_limit']);
							}
							$__compilerTemp5 .= '
											';
						} else {
							$__compilerTemp5 .= '
												' . 'N/A' . '
											';
						}
						$__compilerTemp3[] = array(
							'width' => '10%',
							'_type' => 'cell',
							'html' => '
											' . $__compilerTemp5 . '
										',
						);
						$__compilerTemp6 = '';
						if ($__vars['ad']['settings']['count_views'] AND $__vars['ad']['settings']['count_clicks']) {
							$__compilerTemp6 .= '
												' . $__templater->escape($__vars['ad']['ctr']) . '%
											';
						} else {
							$__compilerTemp6 .= '
												' . 'N/A' . '
											';
						}
						$__compilerTemp3[] = array(
							'width' => '10%',
							'_type' => 'cell',
							'html' => '
											' . $__compilerTemp6 . '
										',
						);
					} else {
						$__compilerTemp3[] = array(
							'width' => '10%',
							'_type' => 'cell',
							'html' => 'N/A',
						);
						$__compilerTemp3[] = array(
							'width' => '10%',
							'_type' => 'cell',
							'html' => 'N/A',
						);
						$__compilerTemp3[] = array(
							'width' => '10%',
							'_type' => 'cell',
							'html' => 'N/A',
						);
					}
				}
				$__compilerTemp3[] = array(
					'width' => '15%',
					'_type' => 'cell',
					'html' => $__templater->func('sam_status_phrase', array($__vars['ad']['status'], ), true),
				);
				$__compilerTemp7 = '';
				if ($__templater->method($__vars['ad'], 'canExtend', array())) {
					$__compilerTemp7 .= '
												<a href="' . $__templater->func('link', array('ads-manager/ads/extend', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Extend' . '</a>
											';
				}
				$__compilerTemp8 = '';
				if (!$__templater->method($__vars['ad'], 'isXfItem', array())) {
					$__compilerTemp8 .= '
												';
					if ($__templater->method($__vars['ad'], 'isPaused', array())) {
						$__compilerTemp8 .= '
													<a href="' . $__templater->func('link', array('ads-manager/ads/unpause', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Unpause' . '</a>
												';
					} else if ($__templater->method($__vars['ad'], 'canPause', array())) {
						$__compilerTemp8 .= '
													<a href="' . $__templater->func('link', array('ads-manager/ads/pause', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Pause' . '</a>
												';
					}
					$__compilerTemp8 .= '
												';
					if ($__templater->method($__vars['ad'], 'canViewDailyStats', array()) AND ($__vars['ad']['Package']['settings']['daily_stats'] AND $__templater->method($__vars['ad'], 'isOfStatus', array(array('active', 'inactive', ), )))) {
						$__compilerTemp8 .= '
													<a href="' . $__templater->func('link', array('ads-manager/ads/daily-stats', $__vars['ad'], ), true) . '" class="menu-linkRow">' . 'Daily statistics' . '</a>
												';
					}
					$__compilerTemp8 .= '
												';
					if ($__templater->method($__vars['ad'], 'canViewClickStats', array()) AND ($__vars['ad']['Package']['settings']['click_stats'] AND $__templater->method($__vars['ad'], 'isOfStatus', array(array('active', 'inactive', ), )))) {
						$__compilerTemp8 .= '
													<a href="' . $__templater->func('link', array('ads-manager/ads/click-stats', $__vars['ad'], ), true) . '" class="menu-linkRow">' . 'Click statistics' . '</a>
												';
					}
					$__compilerTemp8 .= '
											';
				}
				$__compilerTemp9 = '';
				if ($__templater->method($__vars['ad'], 'canDelete', array())) {
					$__compilerTemp9 .= '
												<a href="' . $__templater->func('link', array('ads-manager/ads/delete', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Delete' . '</a>
											';
				}
				$__compilerTemp3[] = array(
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
											' . $__compilerTemp7 . '
											' . $__compilerTemp8 . '
											<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['ad'], ), true) . '" class="menu-linkRow">' . 'Edit' . '</a>
											' . $__compilerTemp9 . '
										</div>
									</div>
								',
				);
				$__compilerTemp2 .= $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['ad']['name']),
					'href' => $__templater->func('link', array('ads-manager/ads/edit', $__vars['ad'], ), false),
					'hint' => $__templater->escape($__templater->method($__vars['ad']['Package'], 'getTypePhrase', array())),
					'explain' => (($__vars['ad']['end_date'] AND $__templater->method($__vars['ad'], 'isActive', array())) ? ('<i class="fal fa-hourglass"></i> ' . $__templater->func('date_time', array($__vars['ad']['end_date'], ), true)) : ''),
					'dir' => 'auto',
				), $__compilerTemp3) . '
						</tbody>
					';
			}
		}
		$__compilerTemp10 = '';
		if ($__vars['total'] >= 2) {
			$__compilerTemp10 .= '
				<div class="block-footer block-footer--split">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['total'], ), true) . '</span>
					<span class="block-footer-select">' . 'Order by' . $__vars['xf']['language']['label_separator'] . '</span>
					<span class="block-footer-controls">
						<div class="inputGroup inputGroup--auto">
							' . $__templater->formSelect(array(
				'name' => 'order_field',
				'value' => $__vars['order']['field'],
			), array(array(
				'value' => 'name',
				'label' => 'Name',
				'_type' => 'option',
			),
			array(
				'value' => 'view_count',
				'label' => $__templater->func('sam_views_impressions_phrase', array(), true),
				'_type' => 'option',
			),
			array(
				'value' => 'click_count',
				'label' => 'Clicks',
				'_type' => 'option',
			),
			array(
				'value' => 'ctr',
				'label' => 'CTR',
				'_type' => 'option',
			))) . '
							<span class="inputGroup-splitter"></span>
							' . $__templater->formSelect(array(
				'name' => 'order_direction',
				'value' => $__vars['order']['direction'],
			), array(array(
				'value' => 'asc',
				'label' => 'Ascending',
				'_type' => 'option',
			),
			array(
				'value' => 'desc',
				'label' => 'Descending',
				'_type' => 'option',
			))) . '
							<span class="inputGroup-splitter"></span>
							' . $__templater->button('', array(
				'type' => 'submit',
				'icon' => 'save',
			), '', array(
			)) . '
						</div>
					</span>
				</div>
			';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), $__compilerTemp1) . '
					' . $__compilerTemp2 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			' . $__compilerTemp10 . '
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/ads', ), false),
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'You haven\'t created any ads yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);