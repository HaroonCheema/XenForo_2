<?php
// FROM HASH: 1aa826baebca0d93d6bdc284c6d599ea
return array(
'macros' => array('ad_unit' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'position' => '!',
		'wrapper' => true,
		'ads' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['xf']['visitor'] AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('siropuAdsManager', 'viewAds', ))) {
		$__finalCompiled .= '

		';
		if ($__templater->test($__vars['ads'], 'empty', array()) AND $__vars['xf']['samAds']) {
			$__finalCompiled .= '
			';
			$__vars['ads'] = $__templater->method($__vars['xf']['samAds'], 'getAds', array($__vars['position'], ));
			$__finalCompiled .= '
		';
		}
		$__finalCompiled .= '

		';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
				';
		if ($__templater->isTraversable($__vars['ads'])) {
			foreach ($__vars['ads'] AS $__vars['type'] => $__vars['data']) {
				$__compilerTemp1 .= '
					';
				if ($__templater->isTraversable($__vars['data'])) {
					foreach ($__vars['data'] AS $__vars['typeAds']) {
						$__compilerTemp1 .= '
						';
						$__vars['count'] = $__templater->func('count', array($__vars['typeAds'], ), false);
						$__compilerTemp1 .= '
						';
						$__vars['firstAd'] = $__templater->filter($__vars['typeAds'], array(array('first', array()),), false);
						$__compilerTemp1 .= '
						';
						$__vars['carousel'] = $__templater->method($__vars['firstAd'], 'isInCarousel', array($__vars['count'], ));
						$__compilerTemp1 .= '
						';
						if (($__vars['type'] == 'text') AND ($__vars['position'] == 'forum_view_above_stickies')) {
							$__compilerTemp1 .= '
							' . $__templater->callMacro(null, 'ad_text_thread', array(
								'ads' => $__vars['typeAds'],
							), $__vars) . '
						';
						} else if (($__vars['type'] == 'link') AND ($__templater->func('contains', array($__vars['position'], 'sidebar', ), false) OR $__templater->func('contains', array($__vars['position'], 'sidenav', ), false))) {
							$__compilerTemp1 .= '
							<div class="block">
								<div class="block-container">
									<h3 class="block-minorHeader">' . 'Advertisements' . '</h3>
									<div class="block-body block-row">
										' . $__templater->callMacro(null, 'ad_link', array(
								'position' => $__vars['position'],
								'ads' => $__vars['typeAds'],
								'firstAd' => $__vars['firstAd'],
								'carousel' => $__vars['carousel'],
								'unitAttributes' => $__templater->func('sam_unit_attributes', array($__vars['typeAds'], $__vars['position'], ), false),
							), $__vars) . '
									</div>
								</div>
							</div>
						';
						} else {
							$__compilerTemp1 .= '
							';
							if (($__vars['wrapper'] == false) AND ($__vars['type'] == 'code')) {
								$__compilerTemp1 .= '
								';
								if ($__templater->isTraversable($__vars['typeAds'])) {
									foreach ($__vars['typeAds'] AS $__vars['ad']) {
										$__compilerTemp1 .= '
									' . $__templater->filter(($__templater->method($__vars['ad'], 'isCallback', array()) ? $__vars['ad']['callback'] : $__templater->method($__vars['ad'], 'getCode', array($__vars['position'], ))), array(array('raw', array()),), true) . '
								';
									}
								}
								$__compilerTemp1 .= '
							';
							} else {
								$__compilerTemp1 .= '
								';
								$__vars['adUnit'] = $__templater->preEscaped('
									' . $__templater->callMacro(null, 'ad_' . $__vars['type'], array(
									'position' => $__vars['position'],
									'ads' => $__vars['typeAds'],
									'firstAd' => $__vars['firstAd'],
									'carousel' => $__vars['carousel'],
									'unitAttributes' => $__templater->func('sam_unit_attributes', array($__vars['typeAds'], $__vars['position'], ), false),
								), $__vars) . '
								');
								$__compilerTemp1 .= '
								';
								$__compilerTemp2 = '';
								if ($__vars['carousel']) {
									$__compilerTemp2 .= '
										' . $__templater->callMacro(null, 'carousel_container', array(
										'package' => $__vars['firstAd']['Package'],
										'adUnit' => $__vars['adUnit'],
										'firstAd' => $__vars['firstAd'],
										'carousel' => $__vars['carousel'],
									), $__vars) . '
									';
								} else {
									$__compilerTemp2 .= '
										' . $__templater->escape($__vars['adUnit']) . '
									';
								}
								$__vars['output'] = $__templater->preEscaped('
									' . $__compilerTemp2 . '
								');
								$__compilerTemp1 .= '
								';
								if ($__vars['firstAd']['Package'] AND $__templater->method($__vars['firstAd']['Package'], 'isInPostLayout', array($__vars['position'], ))) {
									$__compilerTemp1 .= '
									' . $__templater->callMacro(null, 'xf_post_layout', array(
										'package' => $__vars['firstAd']['Package'],
										'content' => $__templater->filter($__vars['output'], array(array('raw', array()),), false),
										'position' => $__vars['position'],
									), $__vars) . '
								';
								} else {
									$__compilerTemp1 .= '
									' . $__templater->filter($__vars['output'], array(array('raw', array()),), true) . '
								';
								}
								$__compilerTemp1 .= '
							';
							}
							$__compilerTemp1 .= '
						';
						}
						$__compilerTemp1 .= '
					';
					}
				}
				$__compilerTemp1 .= '
				';
			}
		}
		$__compilerTemp1 .= '
				';
		if ($__vars['xf']['visitor']['is_admin'] AND ($__vars['xf']['options']['siropuAdsManagerPositionVisualization'] AND $__vars['xf']['samPositions'][$__vars['position']])) {
			$__compilerTemp1 .= '
					<div class="samPositionPreview">' . $__templater->filter($__vars['xf']['samPositions'][$__vars['position']], array(array('raw', array()),), true) . '</div>
				';
		}
		$__compilerTemp1 .= '
			';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
			';
			$__templater->includeCss('siropu_ads_manager_ad.less');
			$__finalCompiled .= '

			';
			if ($__vars['xf']['options']['siropuAdsManagerJsFilePath']) {
				$__finalCompiled .= '
				';
				$__templater->includeJs(array(
					'src' => $__vars['xf']['options']['siropuAdsManagerJsFilePath'],
				));
				$__finalCompiled .= '
			';
			} else {
				$__finalCompiled .= '
				';
				$__templater->includeJs(array(
					'src' => 'siropu/am/core.js',
					'min' => '1',
				));
				$__finalCompiled .= '
			';
			}
			$__finalCompiled .= '

			' . $__compilerTemp1 . '
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_code' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'position' => '!',
		'ads' => '!',
		'firstAd' => '!',
		'unitAttributes' => '!',
		'carousel' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			if ($__templater->method($__vars['ad'], 'getSetting', array('no_wrapper', )) == 0) {
				$__compilerTemp1 .= '
					<div ' . $__templater->filter($__templater->method($__vars['ad'], 'getAttributes', array($__vars['position'], $__vars['carousel'], )), array(array('raw', array()),), true) . '>
						';
				if (!$__vars['ad']['settings']['lazyload']) {
					$__compilerTemp1 .= '
							' . $__templater->filter(($__templater->method($__vars['ad'], 'isCallback', array()) ? $__vars['ad']['callback'] : $__templater->method($__vars['ad'], 'getCode', array($__vars['position'], ))), array(array('raw', array()),), true) . '
						';
				}
				$__compilerTemp1 .= '
						' . $__templater->callMacro(null, 'backup', array(
					'ad' => $__vars['ad'],
				), $__vars) . '
						' . $__templater->callMacro(null, 'close_button', array(
					'position' => $__vars['position'],
				), $__vars) . '
						' . $__templater->callMacro(null, 'admin_actions', array(
					'ad' => $__vars['ad'],
				), $__vars) . '
					</div>
				';
			}
		}
	}
	$__compilerTemp1 .= '
			';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div ' . $__templater->filter($__vars['unitAttributes'], array(array('raw', array()),), true) . '>
			' . $__compilerTemp1 . '
			' . $__templater->callMacro(null, 'advertise_here', array(
			'ad' => $__vars['firstAd'],
			'display' => (!$__vars['carousel']),
		), $__vars) . '
		</div>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			if ($__templater->method($__vars['ad'], 'getSetting', array('no_wrapper', )) == 1) {
				$__finalCompiled .= '
		' . $__templater->filter(($__templater->method($__vars['ad'], 'isCallback', array()) ? $__vars['ad']['callback'] : $__templater->method($__vars['ad'], 'getCode', array($__vars['position'], ))), array(array('raw', array()),), true) . '
		' . $__templater->callMacro(null, 'admin_actions', array(
					'ad' => $__vars['ad'],
				), $__vars) . '
	';
			}
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_banner' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'position' => '!',
		'ads' => '!',
		'firstAd' => '!',
		'unitAttributes' => '!',
		'carousel' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div ' . $__templater->filter($__vars['unitAttributes'], array(array('raw', array()),), true) . '>
		';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
			';
			$__vars['bannerFile'] = $__vars['ad']['banner'];
			$__finalCompiled .= '
			<div ' . $__templater->filter($__templater->method($__vars['ad'], 'getAttributes', array($__vars['position'], $__vars['carousel'], )), array(array('raw', array()),), true) . '>
				';
			if ($__vars['ad']['content_2']) {
				$__finalCompiled .= '
					';
				if (!$__vars['ad']['settings']['lazyload']) {
					$__finalCompiled .= '
						' . $__templater->filter($__templater->method($__vars['ad'], 'getCode', array($__vars['position'], )), array(array('raw', array()),), true) . '
					';
				}
				$__finalCompiled .= '
					' . $__templater->callMacro(null, 'backup', array(
					'ad' => $__vars['ad'],
				), $__vars) . '
				';
			} else if ($__templater->method($__vars['ad'], 'isFlash', array($__vars['bannerFile'], ))) {
				$__finalCompiled .= '
					' . $__templater->callMacro(null, 'flash_banner', array(
					'ad' => $__vars['ad'],
					'file' => $__vars['bannerFile'],
				), $__vars) . '
				';
			} else if ($__templater->method($__vars['ad'], 'isMp4', array($__vars['bannerFile'], ))) {
				$__finalCompiled .= '
					' . $__templater->callMacro(null, 'mp4_banner', array(
					'ad' => $__vars['ad'],
					'file' => $__vars['bannerFile'],
				), $__vars) . '
				';
			} else {
				$__finalCompiled .= '
					';
				if (!$__vars['ad']['settings']['lazyload']) {
					$__finalCompiled .= '
						<a ' . $__templater->filter($__vars['ad']['link_attributes'], array(array('raw', array()),), true) . '>
							';
					if ($__vars['ad']['settings']['lazyload_image']) {
						$__finalCompiled .= '
								<img data-src="' . $__templater->escape($__vars['bannerFile']) . '" alt="' . $__templater->filter($__vars['ad']['content_4'], array(array('for_attr', array()),), true) . '" ' . $__templater->filter($__vars['ad']['width_height'], array(array('raw', array()),), true) . ' data-carousel="' . ((($__vars['position'] != 'advertisers') AND $__vars['carousel']) ? 'true' : 'false') . '" data-xf-init="sam-lazy">
							';
					} else {
						$__finalCompiled .= '
								<img src="' . $__templater->escape($__vars['bannerFile']) . '" alt="' . $__templater->filter($__vars['ad']['content_4'], array(array('for_attr', array()),), true) . '" ' . $__templater->filter($__vars['ad']['width_height'], array(array('raw', array()),), true) . '>
							';
					}
					$__finalCompiled .= '
						</a>
					';
				}
				$__finalCompiled .= '
				';
			}
			$__finalCompiled .= '
				' . $__templater->callMacro(null, 'admin_actions', array(
				'ad' => $__vars['ad'],
			), $__vars) . '
				' . $__templater->callMacro(null, 'close_button', array(
				'position' => $__vars['position'],
			), $__vars) . '
			</div>
		';
		}
	}
	$__finalCompiled .= '
		' . $__templater->callMacro(null, 'advertise_here', array(
		'ad' => $__vars['firstAd'],
		'display' => (!$__vars['carousel']),
	), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'ad_text' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'position' => '!',
		'ads' => '!',
		'firstAd' => '!',
		'unitAttributes' => '!',
		'carousel' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div ' . $__templater->filter($__vars['unitAttributes'], array(array('raw', array()),), true) . '>
		';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
			<div ' . $__templater->filter($__templater->method($__vars['ad'], 'getAttributes', array($__vars['position'], $__vars['carousel'], )), array(array('raw', array()),), true) . '>
				';
			if ($__templater->method($__vars['ad'], 'hasBanner', array())) {
				$__finalCompiled .= '
					<div class="samItemImage">
						';
				if ($__vars['ad']['content_2']) {
					$__finalCompiled .= '
							' . $__templater->filter($__vars['ad']['code'], array(array('raw', array()),), true) . '
						';
				} else {
					$__finalCompiled .= '
							<a ' . $__templater->filter($__vars['ad']['link_attributes'], array(array('raw', array()),), true) . '>
								';
					if ($__vars['ad']['settings']['lazyload_image']) {
						$__finalCompiled .= '
									<img data-src="' . $__templater->escape($__vars['ad']['banner']) . '" alt="' . $__templater->filter($__vars['ad']['content_4'], array(array('for_attr', array()),), true) . '" data-xf-init="sam-lazy">
								';
					} else {
						$__finalCompiled .= '
									<img src="' . $__templater->escape($__vars['ad']['banner']) . '" alt="' . $__templater->filter($__vars['ad']['content_4'], array(array('for_attr', array()),), true) . '">
								';
					}
					$__finalCompiled .= '
							</a>
						';
				}
				$__finalCompiled .= '
					</div>
				';
			}
			$__finalCompiled .= '
				<div class="samItemContent">
					<div class="samItemTitle">
						<a ' . $__templater->filter($__vars['ad']['link_attributes'], array(array('raw', array()),), true) . '>' . $__templater->escape($__vars['ad']['title']) . '</a>
					</div>
					<div class="samItemDescription">
						' . $__templater->filter($__vars['ad']['description'], array(array('nl2br', array()),), true) . '
					</div>
				</div>
				' . $__templater->callMacro(null, 'admin_actions', array(
				'ad' => $__vars['ad'],
			), $__vars) . '
				' . $__templater->callMacro(null, 'close_button', array(
				'position' => $__vars['position'],
			), $__vars) . '
			</div>
		';
		}
	}
	$__finalCompiled .= '
		' . $__templater->callMacro(null, 'advertise_here', array(
		'ad' => $__vars['firstAd'],
		'display' => (!$__vars['carousel']),
	), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'ad_link' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'position' => '!',
		'ads' => '!',
		'firstAd' => '!',
		'unitAttributes' => '!',
		'carousel' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div ' . $__templater->filter($__vars['unitAttributes'], array(array('raw', array()),), true) . '>
		';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
			<div ' . $__templater->filter($__templater->method($__vars['ad'], 'getAttributes', array($__vars['position'], $__vars['carousel'], )), array(array('raw', array()),), true) . '>
				<a ' . $__templater->filter($__vars['ad']['link_attributes'], array(array('raw', array()),), true) . '>' . $__templater->escape($__vars['ad']['title']) . '</a>
				' . $__templater->callMacro(null, 'admin_actions', array(
				'ad' => $__vars['ad'],
			), $__vars) . '
				' . $__templater->callMacro(null, 'close_button', array(
				'position' => $__vars['position'],
			), $__vars) . '
			</div>
		';
		}
	}
	$__finalCompiled .= '
		' . $__templater->callMacro(null, 'advertise_here', array(
		'ad' => $__vars['firstAd'],
		'display' => (!$__vars['carousel']),
	), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'ad_popup' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('siropu_ads_manager_ad.less');
	$__finalCompiled .= '
	';
	if ($__vars['xf']['options']['siropuAdsManagerJsFilePath']) {
		$__finalCompiled .= '
		';
		$__templater->includeJs(array(
			'src' => $__vars['xf']['options']['siropuAdsManagerJsFilePath'],
		));
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		';
		$__templater->includeJs(array(
			'src' => 'siropu/am/core.js',
			'min' => '1',
		));
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__compilerTemp1 .= '
				setTimeout(function() {
					';
			if ($__vars['ad']['content_2']) {
				$__compilerTemp1 .= '
						' . $__templater->filter($__vars['ad']['content_2'], array(array('raw', array()),), false) . '
					';
			} else if ($__vars['ad']['target_url']) {
				$__compilerTemp1 .= '
						var samWindowPopup = window.open(\'' . $__vars['ad']['target_url'] . '\', \'samWindowPopup\', \'' . ($__vars['ad']['content_3'] ?: 'fullscreen=yes') . '\');
						';
				if ($__vars['ad']['settings']['hide_after']) {
					$__compilerTemp1 .= '
							setTimeout(function() {
								samWindowPopup.close();
							}, ' . ($__vars['ad']['settings']['hide_after'] * 1000) . ');
						';
				}
				$__compilerTemp1 .= '
					';
			} else {
				$__compilerTemp1 .= '
						var $samOverlay = XF.getOverlayHtml({
							title: \'' . $__templater->filter($__vars['ad']['title'], array(array('for_attr', array()),), false) . '\',
							html: \'<div class="blockMessage"><div ' . $__templater->filter($__vars['ad']['attributes'], array(array('raw', array()),), false) . '></div></div>\'
						});
						$samOverlay.find(\'.samItem\').html(' . $__templater->filter($__vars['ad']['popup_content'], array(array('raw', array()),), false) . ');
						var samOverlay = new XF.Overlay($samOverlay, {
							backdropClose: false,
							keyboard: false,
							escapeClose: false,
							focusShow: false,
							className: \'samOverlay' . ($__vars['ad']['settings']['hide_close_button'] ? ' samOverlayDisableClose' : '') . ' samOverlay_' . $__vars['ad']['ad_id'] . '\'
						});
						samOverlay.show();
						';
				if ($__vars['ad']['settings']['count_views']) {
					$__compilerTemp1 .= '
							setTimeout(function() {
								$(\'.samItem[data-id="' . $__vars['ad']['ad_id'] . '"]\').trigger(\'adView\');
							}, 1000);
						';
				}
				$__compilerTemp1 .= '
						';
				if ($__vars['ad']['settings']['hide_after']) {
					$__compilerTemp1 .= '
							setTimeout(function() {
								samOverlay.hide();
							}, ' . ($__vars['ad']['settings']['hide_after'] * 1000) . ');
						';
				}
				$__compilerTemp1 .= '
					';
			}
			$__compilerTemp1 .= '
					';
			if ($__vars['ad']['settings']['count_views'] OR ($__vars['ad']['settings']['display_frequency'] AND ($__vars['ad']['content_2'] OR $__vars['ad']['target_url']))) {
				$__compilerTemp1 .= '
						var jsAd = $(\'<span ' . $__vars['ad']['attributes'] . ' />\').css({\'visibility\': \'hidden\', \'position\': \'absolute\', \'top\': 0});
						jsAd.appendTo($(\'.p-body\'));
						XF.activate(jsAd);
						setTimeout(function() {
							';
				if ($__vars['ad']['settings']['count_views']) {
					$__compilerTemp1 .= '
								jsAd.trigger(\'adView\');
							';
				}
				$__compilerTemp1 .= '
							';
				if ($__vars['ad']['settings']['display_frequency']) {
					$__compilerTemp1 .= '
								jsAd.trigger(\'adJsView\');
							';
				}
				$__compilerTemp1 .= '
						}, 1000);
					';
			}
			$__compilerTemp1 .= '
				}, ' . ($__vars['ad']['settings']['display_after'] * 1000) . ');
			';
		}
	}
	$__templater->inlineJs(trim('
		$(function() {
			' . $__compilerTemp1 . '
		});
	'));
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_background' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('siropu_ads_manager_ad.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'siropu/am/core.js',
		'min' => '1',
	));
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__compilerTemp1 .= '
				setTimeout(function() {
					body.addClass(\'samBackground\').css(\'background-image\', "url(\'' . $__vars['ad']['banner'] . '\')");
					var leftAd = $(\'<a ' . $__vars['ad']['attributes'] . ' />\').css(\'width\', adWidth);
					var rightAd = leftAd.clone().css(\'right\', 0);
					leftAd.appendTo(body);
					rightAd.appendTo(body);
					XF.activate(leftAd);
					XF.activate(rightAd);
					';
			$__compilerTemp2 = '';
			$__compilerTemp3 = '';
			if ($__vars['ad']['settings']['count_views']) {
				$__compilerTemp3 .= '
									leftAd.trigger(\'adView\');
								';
			}
			$__compilerTemp4 = '';
			if ($__vars['ad']['settings']['display_frequency']) {
				$__compilerTemp4 .= '
									leftAd.trigger(\'adJsView\');
								';
			}
			$__compilerTemp2 .= trim('
								' . $__compilerTemp3 . '
								' . $__compilerTemp4 . '
							');
			if (strlen(trim($__compilerTemp2)) > 0) {
				$__compilerTemp1 .= '
						setTimeout(function() {
							' . $__compilerTemp2 . '
						}, 1000);
					';
			}
			$__compilerTemp1 .= '
					';
			if ($__vars['ad']['settings']['hide_after']) {
				$__compilerTemp1 .= '
						setTimeout(function() {
							body.removeClass(\'samBackground\').css(\'background-image\', \'\');
							leftAd.remove();
							rightAd.remove();
						}, ' . ($__vars['ad']['settings']['hide_after'] * 1000) . ');
					';
			}
			$__compilerTemp1 .= '
				}, ' . ($__vars['ad']['settings']['display_after'] * 1000) . ');
				';
			if ($__vars['ad']['settings']['count_views']) {
				$__compilerTemp1 .= '
					XF.samBgAds.push(' . $__vars['ad']['ad_id'] . ');
				';
			}
			$__compilerTemp1 .= '
			';
		}
	}
	$__templater->inlineJs(trim('
		XF.samBgAds = [];
		$(function() {
			function calculateAdWidth() {
				return ($(window).width() - $(\'' . $__vars['xf']['options']['siropuAdsManagerInnerBodySelector'] . '\').width()) / 2;
			}
			var body = $(\'' . $__vars['xf']['options']['siropuAdsManagerBodySelector'] . '\');
			var footer = $(\'' . $__vars['xf']['options']['siropuAdsManagerFooterSelector'] . '\');
			var footerHeight = footer.innerHeight();
			var adWidth = calculateAdWidth();
			$(window).scroll(function() {
				if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - footerHeight)) {
					$(\'.samBackgroundItem\').css(\'bottom\', footerHeight);
				} else {
					$(\'.samBackgroundItem\').css(\'bottom\', \'\');
				}
			});
			$(window).resize(function() {
				$(\'.samBackgroundItem\').css(\'width\', calculateAdWidth());
			});
			' . $__compilerTemp1 . '
		});
	'));
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_text_thread' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
		<div class="structItem">
			<div class="structItem-cell structItem-cell--icon">
				<div class="structItem-iconContainer">
					';
			if ($__templater->method($__vars['ad'], 'hasBanner', array())) {
				$__finalCompiled .= '
						<a ' . $__templater->filter($__vars['ad']['link_attributes'], array(array('raw', array()),), true) . ' class="avatar"><img src="' . $__templater->escape($__vars['ad']['banner']) . '" alt="' . $__templater->filter($__vars['ad']['content_4'], array(array('for_attr', array()),), true) . '"></a>
					';
			} else {
				$__finalCompiled .= '
						' . $__templater->func('avatar', array($__vars['ad']['User'], 's', false, array(
				))) . '
					';
			}
			$__finalCompiled .= '
				</div>
			</div>
			<div class="structItem-cell structItem-cell--main">
				<div class="structItem-title">
					<a ' . $__templater->filter($__vars['ad']['link_attributes'], array(array('raw', array()),), true) . '>' . $__templater->escape($__vars['ad']['title']) . '</a>
				</div>
				<div class="structItem-minor">
					' . $__templater->escape($__vars['ad']['description']) . '
					' . $__templater->callMacro(null, 'admin_actions', array(
				'ad' => $__vars['ad'],
			), $__vars) . '
				</div>
			</div>
		</div>
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_thread' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'forum' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['packageData'] = $__vars['xf']['samThreadAds'][$__vars['type']];
	$__finalCompiled .= '
	';
	$__vars['costAmount'] = $__templater->filter(($__vars['packageData']['cost_custom'][$__vars['forum']['node_id']] ? $__vars['packageData']['cost_custom'][$__vars['forum']['node_id']] : $__vars['packageData']['cost_amount']), array(array('currency', array($__vars['packageData']['cost_currency'], )),), false);
	$__finalCompiled .= '
	<div class="structItem">
		<div class="structItem-cell structItem-cell--icon">
			<div class="structItem-iconContainer">
				' . $__templater->func('avatar', array($__vars['xf']['visitor'], 's', false, array(
	))) . '
			</div>
		</div>
		<div class="structItem-cell structItem-cell--main">
			<div class="structItem-title">
				<a href="' . $__templater->func('link', array('ads-manager/packages/create-ad', $__vars['packageData'], ), true) . '">
					';
	if ($__vars['type'] == 'thread') {
		$__finalCompiled .= '
						' . 'Create your own promo thread here for <b>' . $__templater->escape($__vars['costAmount']) . '</b> per <b>' . $__templater->escape($__vars['packageData']['cost_per']) . '</b>' . '
					';
	} else {
		$__finalCompiled .= '
						' . 'Make your thread sticky for <b>' . $__templater->escape($__vars['costAmount']) . '</b> per <b>' . $__templater->escape($__vars['packageData']['cost_per']) . '</b>' . '
					';
	}
	$__finalCompiled .= '
				</a>
			</div>
			<div class="structItem-minor">
				';
	if ($__vars['type'] == 'thread') {
		$__finalCompiled .= '
					' . 'Promotional thread.' . '
				';
	} else {
		$__finalCompiled .= '
					' . 'Get more exposure for your thread by making it sticky.' . '
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'flash_banner' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
		'file' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['url'] = $__vars['file'] . '?clickTAG=' . $__vars['ad']['target_url'] . ($__vars['ad']['settings']['target_blank'] ? '&clickTARGET=_blank' : '');
	$__finalCompiled .= '
	<object ' . $__templater->filter($__vars['ad']['width_height'], array(array('raw', array()),), true) . ' >
		<param name="movie" value="' . $__templater->escape($__vars['url']) . '">
		<param name="menu" value="false">
		<param name="wmode" value="opaque">
		<param name="scale" value="showAll">
		<embed src="' . $__templater->escape($__vars['url']) . '" ' . $__templater->filter($__vars['ad']['width_height'], array(array('raw', array()),), true) . ' menu="false" wmode="Opaque">
	</object>
';
	return $__finalCompiled;
}
),
'mp4_banner' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
		'file' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<video ' . $__templater->filter($__vars['ad']['width_height'], array(array('raw', array()),), true) . ' autoplay muted ' . ($__vars['ad']['target_url'] ? (('onclick="window.open(\'' . $__templater->escape($__vars['ad']['target_url'])) . '\')"') : '') . '>
		<source src="' . $__templater->escape($__vars['file']) . '" type="video/mp4">
	</video>
';
	return $__finalCompiled;
}
),
'backup' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (($__vars['xf']['options']['siropuAdsManagerAdBlock'] == 'backup') AND ($__vars['ad']['content_3'] AND $__templater->method($__vars['ad'], 'canViewBackup', array()))) {
		$__finalCompiled .= '
		<div class="samBackup" style="display: none;">
			' . $__templater->filter($__templater->method($__vars['ad'], 'getBackup', array()), array(array('raw', array()),), true) . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'advertise_here' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
		'display' => true,
		'carousel' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['ad']['Package'] AND $__vars['display']) {
		$__finalCompiled .= '
		';
		$__vars['cssClass'] = ($__vars['carousel'] ? $__templater->method($__vars['ad']['Package'], 'getUnitAlignmentClass', array()) : '');
		$__finalCompiled .= '
		';
		if ($__vars['xf']['options']['siropuAdsManagerEnabled'] AND ($__vars['ad']['Package']['advertise_here'] AND ($__vars['ad']['Package']['empty_slot_count'] AND (($__vars['ad']['Package']['placeholder_id'] != $__vars['ad']['ad_id']) AND ($__templater->method($__vars['ad']['Package'], 'isValidAdvertiser', array()) AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('siropuAdsManager', 'createAds', ))))))) {
			$__finalCompiled .= '
			<div class="samAdvertiseHereLink' . $__templater->escape($__vars['cssClass']) . '"' . ($__vars['carousel'] ? ' style="margin-top: 20px;"' : '') . '>
				<a href="' . $__templater->func('link', array('ads-manager/packages/create-ad', $__vars['ad']['Package'], ), true) . '">' . 'Place your Ad here for ' . $__templater->filter($__vars['ad']['Package']['cost_amount'], array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true) . ' per ' . $__templater->escape($__templater->method($__vars['ad']['Package'], 'getCostPerPhrase', array())) . '!' . '</a>
			</div>
		';
		}
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
					' . $__templater->filter($__vars['ad']['Package']['content'], array(array('raw', array()),), true) . '
					' . $__templater->includeTemplate('siropu_ads_manager_content_below_unit', $__vars) . '
				';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
			<div class="samUnitContent' . $__templater->escape($__vars['cssClass']) . '"' . ($__vars['carousel'] ? ' style="margin-top: 20px;"' : '') . '>
				' . $__compilerTemp1 . '
			</div>
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'admin_actions' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['xf']['visitor']['is_admin'] AND $__vars['xf']['options']['siropuAdsManagerAdActions']) {
		$__finalCompiled .= '
		<div class="samAdminActions">
			' . $__templater->button($__templater->fontAwesome('fas fa-info-circle', array(
		)), array(
			'href' => $__templater->func('link_type', array('admin', 'ads-manager/ads/details', $__vars['ad'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'overlay',
		), '', array(
		)) . '
			' . $__templater->button($__templater->fontAwesome('fas fa-edit', array(
		)), array(
			'href' => $__templater->func('link_type', array('admin', 'ads-manager/ads/edit', $__vars['ad'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'overlay',
		), '', array(
		)) . '
			' . $__templater->button($__templater->fontAwesome('fas fa-trash', array(
		)), array(
			'href' => $__templater->func('link_type', array('admin', 'ads-manager/ads/delete', $__vars['ad'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'overlay',
		), '', array(
		)) . '
			';
		if (!$__templater->method($__vars['ad'], 'isXfItem', array())) {
			$__finalCompiled .= '
				' . $__templater->button('
					' . $__templater->fontAwesome('fas fa-chart-bar', array(
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
						<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/general-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'General statistics' . '</a>
						<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/daily-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Daily statistics' . '</a>
						<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/click-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Click statistics' . '</a>
					</div>
				</div>
			';
		}
		$__finalCompiled .= '
			' . $__templater->button('
				' . $__templater->fontAwesome('fas fa-cog', array(
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
					<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/clone', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Clone' . '</a>
					';
		if (!$__templater->method($__vars['ad'], 'isXfItem', array())) {
			$__finalCompiled .= '
						<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/embed', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Embed' . '</a>
					';
		}
		$__finalCompiled .= '
					<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/export', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>
				</div>
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'close_button' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'position' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['position'] == 'footer_fixed') {
		$__finalCompiled .= '
		<a role="button" class="samCloseButton" data-xf-click="sam-close">' . $__templater->fontAwesome('fas fa-times-square', array(
		)) . '</a>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->func('in_array', array($__vars['position'], array('over_bb_code_video_attachment', 'media_view_video_container', 'media_view_video_embed_container', ), ), false)) {
		$__finalCompiled .= '
		<a role="button" class="samOverlayCloseButton" data-xf-click="sam-close">
			' . 'Close ad & play' . '
		</a>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'carousel_container' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'package' => '!',
		'adUnit' => '!',
		'firstAd' => '!',
		'carousel' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="sam-swiper-container swiper-container"' . $__templater->filter($__templater->method($__vars['package'], 'getUnitStyle', array()), array(array('raw', array()),), true) . ' data-id="' . $__templater->escape($__vars['package']['package_id']) . '" data-options=\'' . $__templater->filter($__vars['package']['carousel_settings'], array(array('raw', array()),), true) . '\'>
		' . $__templater->escape($__vars['adUnit']) . '
		';
	if ($__vars['package']['settings']['carousel']['arrows']) {
		$__finalCompiled .= '
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		';
	}
	$__finalCompiled .= '
		';
	if ($__vars['package']['settings']['carousel']['bullets']) {
		$__finalCompiled .= '
			<div class="swiper-pagination"></div>
		';
	}
	$__finalCompiled .= '
	</div>
	' . $__templater->callMacro(null, 'advertise_here', array(
		'ad' => $__vars['firstAd'],
		'carousel' => $__vars['carousel'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'xf_post_layout' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'package' => '!',
		'content' => '!',
		'position' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['isProfilePost'] = ($__templater->func('contains', array($__vars['position'], 'profile_post_', ), false) ? true : false);
	$__finalCompiled .= '
	';
	$__vars['userAvatar'] = $__templater->method($__vars['package'], 'getPostLayoutSetting', array('avatar', '', ));
	$__finalCompiled .= '
	';
	$__vars['userName'] = $__templater->filter($__templater->method($__vars['package'], 'getPostLayoutSetting', array('username', )), array(array('raw', array()),), false);
	$__finalCompiled .= '
	';
	$__vars['userTitle'] = $__templater->filter($__templater->method($__vars['package'], 'getPostLayoutSetting', array('title', )), array(array('raw', array()),), false);
	$__finalCompiled .= '
	<article class="message message--' . ($__vars['isProfilePost'] ? 'simple' : 'post') . '">
		<div class="message-inner">
			<div class="message-cell message-cell--user">
				<section class="message-user">
					<div class="message-avatar message-avatar--online">
						<div class="message-avatar-wrapper">
							';
	if (!$__templater->test($__vars['userAvatar'], 'empty', array())) {
		$__finalCompiled .= '
								<a class="avatar avatar--' . ($__vars['isProfilePost'] ? 's' : 'm') . '">
									<img src="' . $__templater->escape($__vars['userAvatar']) . '" width="96" height="96" loading="lazy"> 
								</a>
							';
	} else {
		$__finalCompiled .= '
								<a class="avatar avatar--' . ($__vars['isProfilePost'] ? 's' : 'm') . ' avatar--default avatar--default--dynamic" style="background-color: #cc9933; color: #3d2e0f">
									<span role="img">A</span> 
								</a>
							';
	}
	$__finalCompiled .= '
						</div>
					</div>
					';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
								';
	if ($__vars['userName']) {
		$__compilerTemp1 .= '
									<h4 class="message-name">
										<span class="username">' . $__templater->filter($__vars['userName'], array(array('raw', array()),), true) . '</span>
									</h4>
								';
	}
	$__compilerTemp1 .= '
								';
	if ($__vars['userTitle']) {
		$__compilerTemp1 .= '
									<h5 class="userTitle message-userTitle" dir="auto">' . $__templater->filter($__vars['userTitle'], array(array('raw', array()),), true) . '</h5>
								';
	}
	$__compilerTemp1 .= '
							';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
						<div class="message-userDetails">
							' . $__compilerTemp1 . '
						</div>
					';
	}
	$__finalCompiled .= '
				</section>
				<span class="message-userArrow"></span>
			</div>
			<div class="message-cell message-cell--main">
				<div class="message-main">
					<div class="message-content">
						<div class="message-userContent">
							<article class="message-body">
								<div class="bbWrapper">' . $__templater->escape($__vars['content']) . '</div>
							</article>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);