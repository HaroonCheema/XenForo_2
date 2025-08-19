<?php
// FROM HASH: d07afb339cc85ad808f72bce5bfe5d10
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Ads');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		<div class="buttonGroup-buttonWrapper">
			' . $__templater->button('Create ad', array(
		'class' => 'menuTrigger',
		'icon' => 'add',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
	), '', array(
	)) . '
			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					<h4 class="menu-header">' . 'Select ad type' . '</h4>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'code', ), ), true) . '" class="menu-linkRow">' . 'Code' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'banner', ), ), true) . '" class="menu-linkRow">' . 'Banner' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'text', ), ), true) . '" class="menu-linkRow">' . 'Text' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'link', ), ), true) . '" class="menu-linkRow">' . 'Link' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'keyword', ), ), true) . '" class="menu-linkRow">' . 'Keyword' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'affiliate', ), ), true) . '" class="menu-linkRow">' . 'Affiliate link' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'thread', ), ), true) . '" class="menu-linkRow">' . 'Promo thread' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'sticky', ), ), true) . '" class="menu-linkRow">' . 'Sticky thread' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'resource', ), ), true) . '" class="menu-linkRow">' . 'Featured resource' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'popup', ), ), true) . '" class="menu-linkRow">' . 'Popup' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'background', ), ), true) . '" class="menu-linkRow">' . 'Background' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => 'custom', ), ), true) . '" class="menu-linkRow">' . 'Custom service' . '</a>
				</div>
			</div>
		</div>
		<div class="buttonGroup-buttonWrapper">
			' . $__templater->button('&#8226;&#8226;&#8226;', array(
		'class' => 'menuTrigger',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
		'title' => $__templater->filter('More options', array(array('for_attr', array()),), false),
	), '', array(
	)) . '
			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					<h4 class="menu-header">' . 'More options' . '</h4>
					<a href="' . $__templater->func('link', array('ads-manager/ads/import', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Import' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/mass-export', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/delete-all', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Delete all ads' . '</a>
				</div>
			</div>
		</div>
	</div>
');
	$__finalCompiled .= '

';
	$__templater->includeCss('siropu_ads_manager_admin.less');
	$__templater->inlineCss('
	.dataList--responsive .dataList-cell.dataList-cell--main:not(.dataList-cell--link)
	{
		width: 100%;
	}
	.dataList--responsive .dataList-cell
	{
		display: inline-block !important;
	}
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['pendingAds'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">' . 'Pending approval' . '</h2>
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['pendingAds'])) {
			foreach ($__vars['pendingAds'] AS $__vars['pending']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'href' => $__templater->func('link', array('ads-manager/ads/edit', $__vars['pending'], ), false),
					'label' => $__templater->escape($__vars['pending']['name']),
					'hint' => $__templater->escape($__templater->method($__vars['pending'], 'getTypePhrase', array())),
					'delete' => $__templater->func('link', array('ads-manager/ads/delete', $__vars['pending'], ), false),
					'dir' => 'auto',
				), array(array(
					'href' => $__templater->func('link', array('ads-manager/ads/details', $__vars['pending'], ), false),
					'overlay' => 'true',
					'class' => 'dataList-cell--separated',
					'width' => '10%',
					'_type' => 'cell',
					'html' => 'Approve/Reject',
				))) . '
					';
			}
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
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['ads'], 'empty', array()) OR !$__templater->test($__vars['filters'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp2 = '';
		$__compilerTemp3 = $__templater->method($__vars['xf']['samAdmin'], 'getStatuses', array());
		if ($__templater->isTraversable($__compilerTemp3)) {
			foreach ($__compilerTemp3 AS $__vars['status'] => $__vars['phrase']) {
				$__compilerTemp2 .= '
							<a href="' . $__templater->func('link', array('ads-manager/ads', null, array('status' => $__vars['status'], ) + $__vars['filters'], ), true) . '" class="menu-linkRow ' . (($__vars['filters']['status'] AND ($__vars['filters']['status'] == $__vars['status'])) ? 'is-selected' : '') . '">' . $__templater->escape($__vars['phrase']) . '</a>
						';
			}
		}
		$__compilerTemp4 = '';
		if (!$__templater->test($__vars['packages'], 'empty', array())) {
			$__compilerTemp4 .= '
					<a class="menuTrigger button button--link"
					   data-xf-click="menu"
					   role="button"
					   tabindex="0"
					   aria-expanded="false"
					   aria-haspopup="true">' . 'Package' . $__vars['xf']['language']['label_separator'] . ' ' . ($__vars['filters']['package_id'] ? $__templater->escape($__vars['packages'][$__vars['filters']['package_id']]['title']) : $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close']) . '</a>

					<div class="menu" data-menu="menu" aria-hidden="true">
						<div class="menu-content">
							<h3 class="menu-header">' . 'Packages' . '</h3>
							<a href="' . $__templater->func('link', array('ads-manager/ads', null, array('status' => $__vars['filters']['status'], ), ), true) . '" class="menu-linkRow ' . ((!$__vars['input']['package_id']) ? 'is-selected' : '') . '">(' . 'Any' . ')</a>
							';
			if ($__templater->isTraversable($__vars['packages'])) {
				foreach ($__vars['packages'] AS $__vars['package']) {
					if (($__vars['package']['package_id'] != 0)) {
						$__compilerTemp4 .= '
								<a href="' . $__templater->func('link', array('ads-manager/ads', null, array('package_id' => $__vars['package']['package_id'], ) + $__vars['filters'], ), true) . '" class="menu-linkRow ' . (($__vars['filters']['package_id'] AND ($__vars['filters']['package_id'] == $__vars['package']['package_id'])) ? 'is-selected' : '') . '">' . $__templater->escape($__vars['package']['title']) . '</a>
							';
					}
				}
			}
			$__compilerTemp4 .= '
						</div>
					</div>
				';
		}
		$__compilerTemp5 = '';
		if (!$__templater->test($__vars['ads'], 'empty', array())) {
			$__compilerTemp5 .= '
						';
			if ($__templater->isTraversable($__vars['ads'])) {
				foreach ($__vars['ads'] AS $__vars['packageId'] => $__vars['adList']) {
					$__compilerTemp5 .= '
							<tbody class="dataList-rowGroup">
								';
					$__vars['package'] = $__vars['packages'][$__vars['packageId']];
					$__compilerTemp5 .= '
								';
					if ($__vars['packageId']) {
						$__compilerTemp5 .= '
									';
						$__compilerTemp6 = '';
						if (!$__templater->method($__vars['package'], 'isXfItem', array())) {
							$__compilerTemp6 .= '
												' . $__templater->button('', array(
								'href' => $__templater->func('link', array('ads-manager/packages/statistics', $__vars['package'], ), false),
								'class' => 'button--link button--iconOnly',
								'data-xf-init' => 'tooltip',
								'data-xf-click' => 'overlay',
								'title' => $__templater->filter('Package statistics', array(array('for_attr', array()),), false),
								'fa' => 'fas fa-chart-bar',
							), '', array(
							)) . '
											';
						}
						$__compilerTemp5 .= $__templater->dataRow(array(
							'rowtype' => 'subsection',
							'href' => $__templater->func('link', array('ads-manager/packages/edit', $__vars['package'], array('redirect' => 'ads', ), ), false),
							'label' => $__templater->escape($__vars['package']['title']),
							'hint' => $__templater->escape($__templater->method($__vars['package'], 'getTypePhrase', array())) . ' (' . $__templater->func('count', array($__vars['adList'], ), true) . ')',
							'delete' => $__templater->func('link', array('ads-manager/packages/delete', $__vars['package'], array('redirect' => 'ads', ), ), false),
							'colspan' => '4',
						), array(array(
							'width' => '5%',
							'class' => 'dataList-cell--separated',
							'_type' => 'cell',
							'html' => '
											' . $__templater->button('', array(
							'href' => $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => $__vars['package']['type'], 'package_id' => $__vars['package']['package_id'], ), ), false),
							'class' => 'button--link button--iconOnly',
							'data-xf-init' => 'tooltip',
							'title' => $__templater->filter('Create ad', array(array('for_attr', array()),), false),
							'fa' => 'fas fa-plus-square',
						), '', array(
						)) . '
										',
						),
						array(
							'width' => '5%',
							'class' => 'dataList-cell--separated',
							'style' => 'text-align: center;',
							'_type' => 'cell',
							'html' => '
											' . $__compilerTemp6 . '
										',
						),
						array(
							'class' => 'dataList-cell--separated',
							'_type' => 'cell',
							'html' => '
											' . $__templater->callMacro('siropu_ads_manager_package_macros', 'options_menu', array(
							'package' => $__vars['package'],
						), $__vars) . '
										',
						),
						array(
							'class' => 'dataList-cell--separated',
							'_type' => 'cell',
							'html' => '
											' . $__templater->callMacro('siropu_ads_manager_package_macros', 'ads_options_menu', array(
							'package' => $__vars['package'],
						), $__vars) . '
										',
						))) . '
								';
					} else {
						$__compilerTemp5 .= '
									' . $__templater->dataRow(array(
							'rowtype' => 'subsection',
							'class' => 'dataList-row--noHover',
							'label' => $__templater->escape($__vars['package']['title']),
							'hint' => '(' . $__templater->func('count', array($__vars['adList'], ), true) . ')',
							'colspan' => '9',
						), array()) . '
								';
					}
					$__compilerTemp5 .= '
								';
					if ($__templater->isTraversable($__vars['adList'])) {
						foreach ($__vars['adList'] AS $__vars['adId'] => $__vars['ad']) {
							$__compilerTemp5 .= '
									';
							$__compilerTemp7 = '';
							if ($__vars['xf']['options']['siropuAdsManagerDisplayAdOwner']) {
								$__compilerTemp7 .= '
												' . $__templater->func('username_link', array($__vars['ad']['User'], true, array(
									'default' => '$ad.username',
								))) . '
											';
							}
							$__compilerTemp8 = '';
							if ($__vars['xf']['options']['siropuAdsManagerDisplayAdExpirationDate']) {
								$__compilerTemp8 .= '
												';
								if ($__vars['ad']['end_date']) {
									$__compilerTemp8 .= '
													' . $__templater->func('date_time', array($__vars['ad']['end_date'], ), true) . '
												';
								}
								$__compilerTemp8 .= '
												';
								if ($__vars['ad']['settings']['count_views'] AND $__vars['ad']['view_limit']) {
									$__compilerTemp8 .= '
													' . $__templater->escape($__vars['ad']['view_count']) . '/' . $__templater->escape($__vars['ad']['view_limit']) . ' ' . 'Views' . '
												';
								}
								$__compilerTemp8 .= '
												';
								if ($__vars['ad']['settings']['count_clicks'] AND $__vars['ad']['click_limit']) {
									$__compilerTemp8 .= '
													' . $__templater->escape($__vars['ad']['click_count']) . '/' . $__templater->escape($__vars['ad']['click_limit']) . ' ' . 'Clicks' . '
												';
								}
								$__compilerTemp8 .= '
											';
							}
							$__compilerTemp9 = '';
							if (!$__templater->method($__vars['ad'], 'isXfItem', array())) {
								$__compilerTemp9 .= '
												' . $__templater->button('', array(
									'class' => 'button--link button--iconOnly menuTrigger',
									'data-xf-click' => 'menu',
									'aria-label' => 'More options',
									'aria-expanded' => 'false',
									'aria-haspopup' => 'true',
									'fa' => 'fa fa-chart-bar',
								), '', array(
								)) . '
												<div class="menu" data-menu="menu" aria-hidden="true">
													<div class="menu-content">
														<a href="' . $__templater->func('link', array('ads-manager/ads/general-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'General statistics' . '</a>
														<a href="' . $__templater->func('link', array('ads-manager/ads/daily-stats', $__vars['ad'], ), true) . '" class="menu-linkRow">' . 'Daily statistics' . '</a>
														<a href="' . $__templater->func('link', array('ads-manager/ads/click-stats', $__vars['ad'], ), true) . '" class="menu-linkRow">' . 'Click statistics' . '</a>
													</div>
												</div>
											';
							}
							$__compilerTemp10 = '';
							if ($__templater->method($__vars['ad'], 'isEmbeddable', array())) {
								$__compilerTemp10 .= '
														<a href="' . $__templater->func('link', array('ads-manager/ads/embed', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Embed' . '</a>
													';
							}
							$__compilerTemp11 = '';
							if ($__templater->method($__vars['ad'], 'isEmbeddable', array()) OR $__templater->method($__vars['ad'], 'isKeyword', array())) {
								$__compilerTemp11 .= '
														<a href="' . $__templater->func('link', array('ads-manager/ads/reset-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Reset statistics' . '</a>
													';
							}
							$__compilerTemp12 = '';
							if ($__templater->method($__vars['ad'], 'isCode', array())) {
								$__compilerTemp12 .= '
														<a href="' . $__templater->func('link', array('ads-manager/tools/click-fraud-monitor', null, array('ad_id' => $__vars['ad']['ad_id'], ), ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Click fraud monitor';
								if (!$__templater->method($__vars['ad'], 'isClickFraudEnabled', array())) {
									$__compilerTemp12 .= ' <span style="color: gray;">' . $__vars['xf']['language']['parenthesis_open'] . 'Not enabled' . $__vars['xf']['language']['parenthesis_close'] . '</span>';
								}
								$__compilerTemp12 .= '</a>
													';
							}
							$__compilerTemp5 .= $__templater->dataRow(array(
								'hash' => $__vars['ad']['ad_id'],
								'href' => $__templater->func('link', array('ads-manager/ads/edit', $__vars['ad'], ), false),
								'label' => $__templater->escape($__vars['ad']['name']),
								'hint' => ((($__vars['ad']['package_id'] == 0) AND (!$__vars['input']['type'])) ? $__templater->escape($__templater->method($__vars['ad'], 'getTypePhrase', array())) : ''),
								'delete' => $__templater->func('link', array('ads-manager/ads/delete', $__vars['ad'], ), false),
								'dir' => 'auto',
							), array(array(
								'_type' => 'cell',
								'html' => '
											' . $__compilerTemp7 . '
										',
							),
							array(
								'_type' => 'cell',
								'html' => '
											' . $__compilerTemp8 . '
										',
							),
							array(
								'width' => '10%',
								'_type' => 'cell',
								'html' => $__templater->func('sam_status_phrase', array($__vars['ad']['status'], ), true),
							),
							array(
								'width' => '5%',
								'class' => 'dataList-cell--separated',
								'_type' => 'cell',
								'html' => '
											' . $__templater->button('', array(
								'href' => $__templater->func('link', array('ads-manager/ads/details', $__vars['ad'], ), false),
								'class' => 'button--link button--iconOnly',
								'title' => $__templater->filter('View details', array(array('for_attr', array()),), false),
								'data-xf-init' => 'tooltip',
								'data-xf-click' => 'overlay',
								'style' => ($__templater->method($__vars['ad'], 'isPendingApproval', array()) ? 'color: crimson;' : ''),
								'fa' => 'fas ' . ($__templater->method($__vars['ad'], 'isPendingApproval', array()) ? 'fa-exclamation-triangle' : 'fas fa-info-circle'),
							), '', array(
							)) . '
										',
							),
							array(
								'width' => '5%',
								'class' => 'dataList-cell--separated',
								'_type' => 'cell',
								'html' => '
											' . $__compilerTemp9 . '
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
													' . $__compilerTemp10 . '
													<a href="' . $__templater->func('link', array('ads-manager/ads/export', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>
													' . $__compilerTemp11 . '
													' . $__compilerTemp12 . '
												</div>
											</div>
										',
							),
							array(
								'name' => 'ad_status[' . $__vars['ad']['ad_id'] . ']',
								'selected' => $__vars['ad']['status'] == 'active',
								'class' => 'dataList-cell--separated',
								'submit' => 'true',
								'tooltip' => 'Enable / disable \'' . $__vars['ad']['name'] . '\'',
								'_type' => 'toggle',
								'html' => '',
							))) . '
								';
						}
					}
					$__compilerTemp5 .= '
							</tbody>
						';
				}
			}
			$__compilerTemp5 .= '
					';
		} else {
			$__compilerTemp5 .= '
						' . $__templater->dataRow(array(
				'rowclass' => 'dataList-row--noHover dataList-row--note',
				'colspan' => '9',
			), array(array(
				'class' => 'dataList-cell--noSearch',
				'_type' => 'cell',
				'html' => '
								' . 'No ads have been found.' . '
							',
			))) . '
					';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			<div class="block-outer-main">
				<a class="menuTrigger button button--link"
				   data-xf-click="menu"
				   role="button"
				   tabindex="0"
				   aria-expanded="false"
				   aria-haspopup="true">' . 'Status' . $__vars['xf']['language']['label_separator'] . ' ' . ($__vars['filters']['status'] ? $__templater->func('sam_status_phrase', array($__vars['filters']['status'], 'ad', false, ), true) : $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close']) . '</a>

				<div class="menu" data-menu="menu" aria-hidden="true">
					<div class="menu-content">
						<h3 class="menu-header">' . 'Statuses' . '</h3>
						<a href="' . $__templater->func('link', array('ads-manager/ads', null, array('package_id' => $__vars['filters']['package_id'], ), ), true) . '" class="menu-linkRow ' . ((!$__vars['filters']['status']) ? 'is-selected' : '') . '">(' . 'Any' . ')</a>
						' . $__compilerTemp2 . '
					</div>
				</div>

				' . $__compilerTemp4 . '
			</div>
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'ads',
			'ajax' => $__templater->func('link', array('ads-manager/ads', ), false),
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'type_tabs', array(
			'route' => 'ads-manager/ads',
			'type' => $__vars['filters']['type'],
		), $__vars) . '
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp5 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['adCount'], $__vars['total'], ), true) . '</span>
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
			'value' => 'display_order',
			'label' => 'Display order',
			'_type' => 'option',
		),
		array(
			'value' => 'create_date',
			'label' => 'Creation date',
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
		</div>
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'params' => $__vars['filters'],
			'link' => 'ads-manager/ads',
			'wrapperclass' => 'js-filterHide block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	', array(
			'action' => $__templater->func('link', array('ads-manager/ads', ), false),
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No ads have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);