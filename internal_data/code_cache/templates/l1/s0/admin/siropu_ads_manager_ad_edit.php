<?php
// FROM HASH: c8dab1a7f9925cfb8af2b3f7a6340fb8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['ad'], 'isInsert', array())) {
		$__compilerTemp1 .= '
		';
		if ($__templater->method($__vars['ad'], 'isCode', array())) {
			$__compilerTemp1 .= '
			' . 'Create code ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isBanner', array())) {
			$__compilerTemp1 .= '
			' . 'Create banner ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isText', array())) {
			$__compilerTemp1 .= '
			' . 'Create text ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isLink', array())) {
			$__compilerTemp1 .= '
			' . 'Create link ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isKeyword', array())) {
			$__compilerTemp1 .= '
			' . 'Create keyword ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isAffiliate', array())) {
			$__compilerTemp1 .= '
			' . 'Create affiliate link ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isThread', array())) {
			$__compilerTemp1 .= '
			' . 'Create promo thread ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isSticky', array())) {
			$__compilerTemp1 .= '
			' . 'Create sticky thread ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isResource', array())) {
			$__compilerTemp1 .= '
			' . 'Create featured resource ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isPopup', array())) {
			$__compilerTemp1 .= '
			' . 'Create popup ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isBackground', array())) {
			$__compilerTemp1 .= '
			' . 'Create background ad' . '
		';
		} else if ($__templater->method($__vars['ad'], 'isCustom', array())) {
			$__compilerTemp1 .= '
			' . 'Create custom service ad' . '
		';
		}
		$__compilerTemp1 .= '
	';
	} else {
		$__compilerTemp1 .= '
		' . 'Edit ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']) . '
	';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['ad'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['ad'], 'isUpdate', array())) {
		$__compilerTemp2 = '';
		if ($__vars['ad']['Package']) {
			$__compilerTemp2 .= '
		' . $__templater->button('Edit package', array(
				'href' => $__templater->func('link', array('ads-manager/packages/edit', $__vars['ad']['Package'], ), false),
				'icon' => 'edit',
			), '', array(
			)) . '
	';
		}
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__compilerTemp2 . '
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/ads/delete', $__vars['ad'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__templater->includeCss('siropu_ads_manager_admin.less');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/admin.js',
		'min' => '1',
	));
	$__templater->inlineJs('
	jQuery.extend(XF.phrases, {
		siropu_ads_manager_incompatible_user_criteria: "' . $__templater->filter('Incompatible user criteria. A user cannot be a guest and have other statuses at the same time.', array(array('escape', array('js', )),), false) . '"
	});
');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/create.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	if ($__vars['ad']['Extra']['purchase']) {
		$__finalCompiled .= '
	';
		if ($__templater->method($__vars['ad'], 'isPending', array())) {
			$__finalCompiled .= '
		<div class="blockMessage blockMessage--important blockMessage--iconic">
			' . 'This ad requires your approval. Please <a href="' . $__templater->func('link', array('ads-manager/ads/details', $__vars['ad'], ), true) . '">click here</a> to see ad details and approve or reject the ad.' . '
		</div>
	';
		} else if ($__templater->method($__vars['ad'], 'isApproved', array()) AND $__vars['ad']['Invoices']) {
			$__finalCompiled .= '
		<div class="blockMessage blockMessage--important blockMessage--iconic">
			' . 'If you want to enable this ad manually, go to <a href="' . $__templater->func('link', array('ads-manager/invoices', ), true) . '">Invoices</a> and change the status of the invoice for this ad to "Completed".' . '
		</div>
	';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp3 = '';
	if (!$__templater->method($__vars['ad'], 'hasNoCriteria', array())) {
		$__compilerTemp3 .= '
					' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'position_tabs', array(), $__vars) . '
					' . $__templater->callMacro('helper_criteria', 'user_tabs', array(), $__vars) . '
					' . $__templater->callMacro('helper_criteria', 'page_tabs', array(), $__vars) . '
					' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'device_tabs', array(), $__vars) . '
					' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'geo_tabs', array(), $__vars) . '
				';
	}
	$__compilerTemp4 = '';
	if (!$__templater->method($__vars['ad'], 'hasNoCriteria', array())) {
		$__compilerTemp4 .= '
					';
		if (!$__templater->method($__vars['ad'], 'isOfType', array(array('keyword', 'affiliate', 'popup', 'background', ), ))) {
			$__compilerTemp4 .= '
						' . $__templater->formSelectRow(array(
				'name' => 'settings[unit_alignment]',
				'value' => $__vars['ad']['settings']['unit_alignment'],
			), array(array(
				'label' => 'Auto',
				'_type' => 'option',
			),
			array(
				'value' => 'center',
				'label' => 'Center',
				'_type' => 'option',
			),
			array(
				'value' => 'left',
				'label' => 'Left',
				'_type' => 'option',
			),
			array(
				'value' => 'right',
				'label' => 'Right',
				'_type' => 'option',
			)), array(
				'label' => 'Alignment',
				'explain' => 'Set display alignment for this ad.',
			)) . '

						';
			$__compilerTemp5 = array(array(
				'label' => 'Auto',
				'_type' => 'option',
			));
			$__compilerTemp6 = $__templater->method($__vars['xf']['samAdmin'], 'getAdSizes', array());
			if ($__templater->isTraversable($__compilerTemp6)) {
				foreach ($__compilerTemp6 AS $__vars['sizes']) {
					$__compilerTemp5[] = array(
						'label' => $__vars['sizes']['group'],
						'_type' => 'optgroup',
						'options' => array(),
					);
					end($__compilerTemp5); $__compilerTemp7 = key($__compilerTemp5);
					if ($__templater->isTraversable($__vars['sizes']['sizes'])) {
						foreach ($__vars['sizes']['sizes'] AS $__vars['size']) {
							$__compilerTemp5[$__compilerTemp7]['options'][] = array(
								'value' => $__vars['size'],
								'label' => $__templater->escape($__vars['size']),
								'_type' => 'option',
							);
						}
					}
				}
			}
			$__compilerTemp4 .= $__templater->formSelectRow(array(
				'name' => 'settings[unit_size]',
				'value' => $__vars['ad']['settings']['unit_size'],
			), $__compilerTemp5, array(
				'label' => 'Size',
				'explain' => 'Set the width and height for this ad.',
			)) . '
					';
		}
		$__compilerTemp4 .= '

					' . $__templater->formTextBoxRow(array(
			'name' => 'settings[inline_style]',
			'value' => $__vars['ad']['settings']['inline_style'],
		), array(
			'label' => 'Inline style',
			'explain' => 'This option allows you to style the ad using CSS.
<p>Example:</p>
<code><span style="font-weight: bold;">font-weight: bold;</span> <span style="color: brown; ">color: brown;</span> <span style="font-style: italic;">font-style: italic;</span></code>',
		)) . '

					' . $__templater->formTextBoxRow(array(
			'name' => 'settings[css_class]',
			'value' => $__vars['ad']['settings']['css_class'],
		), array(
			'label' => 'CSS class',
			'explain' => 'This option allows you to set a custom CSS class.',
		)) . '

					<hr class="formRowSep" />
				';
	}
	$__compilerTemp8 = $__templater->mergeChoiceOptions(array(), $__vars['hours']);
	$__compilerTemp9 = $__templater->mergeChoiceOptions(array(), $__vars['minutes']);
	$__compilerTemp10 = $__templater->mergeChoiceOptions(array(), $__vars['hours']);
	$__compilerTemp11 = $__templater->mergeChoiceOptions(array(), $__vars['minutes']);
	$__compilerTemp12 = '';
	if (!$__templater->method($__vars['ad'], 'hasNoCriteria', array())) {
		$__compilerTemp12 .= '
					<hr class="formRowSep" />
					';
		$__vars['viewCountMethod'] = $__vars['xf']['options']['siropuAdsManagerViewCountMethod'];
		$__compilerTemp12 .= '
					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[count_views]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['count_views'],
			'label' => (($__vars['viewCountMethod'] == 'view') ? 'Count views' : 'Count impressions'),
			'_dependent' => array($__templater->formNumberBox(array(
			'name' => 'view_limit',
			'value' => $__vars['ad']['view_limit'],
			'units' => (($__vars['viewCountMethod'] == 'view') ? 'View limit' : 'Impression limit'),
			'size' => '5',
			'min' => '0',
		)), $__templater->formNumberBox(array(
			'name' => 'view_count',
			'value' => $__vars['ad']['view_count'],
			'units' => (($__vars['viewCountMethod'] == 'view') ? 'View count' : 'Impression count'),
			'size' => '5',
			'min' => '0',
		))),
			'_type' => 'option',
		)), array(
			'explain' => 'If a view/impression limit is set, the ad will become inactive once the limit is reached.',
		)) . '

					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[count_clicks]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['count_clicks'],
			'label' => 'Count clicks',
			'_dependent' => array($__templater->formNumberBox(array(
			'name' => 'click_limit',
			'value' => $__vars['ad']['click_limit'],
			'units' => 'Click limit',
			'size' => '5',
			'min' => '0',
		)), $__templater->formNumberBox(array(
			'name' => 'click_count',
			'value' => $__vars['ad']['click_count'],
			'units' => 'Click count',
			'size' => '5',
			'min' => '0',
		))),
			'_type' => 'option',
		)), array(
			'explain' => 'If a click limit is set, the ad will become inactive once the limit is reached.',
		)) . '

					<hr class="formRowSep" />

					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[daily_stats]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['daily_stats'],
			'label' => 'Daily statistics',
			'_type' => 'option',
		),
		array(
			'name' => 'settings[click_stats]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['click_stats'],
			'label' => 'Click statistics',
			'_type' => 'option',
		),
		array(
			'name' => 'settings[ga_stats]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['ga_stats'],
			'label' => 'Google Analytics statistics' . ' <a href="' . $__templater->func('link', array('ads-manager/help/google-analytics', ), true) . '" title="' . $__templater->filter('What\'s this?', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" data-xf-click="overlay"><i class="fa fa-question-circle" aria-hidden="true"></i></a>',
			'_type' => 'option',
		)), array(
			'label' => 'Enable statistics',
		)) . '

					<hr class="formRowSep" />

					' . $__templater->formRadioRow(array(
			'name' => 'settings[rel]',
			'value' => ($__vars['ad']['settings']['rel'] ?: 'nofollow'),
		), array(array(
			'value' => 'nofollow',
			'label' => 'Nofollow <a href="https://support.google.com/webmasters/answer/96569?hl=en" title="' . $__templater->filter('What\'s this?', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i></a>',
			'_type' => 'option',
		),
		array(
			'value' => 'ugc',
			'label' => 'UGC <a href="https://support.google.com/webmasters/answer/96569?hl=en" title="' . $__templater->filter('What\'s this?', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i></a>',
			'_type' => 'option',
		),
		array(
			'value' => 'sponsored',
			'label' => 'Sponsored <a href="https://support.google.com/webmasters/answer/96569?hl=en" title="' . $__templater->filter('What\'s this?', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i></a>',
			'_type' => 'option',
		),
		array(
			'value' => 'custom',
			'label' => 'Custom',
			'_dependent' => array('
								' . $__templater->formTextBox(array(
			'name' => 'settings[rel_custom]',
			'value' => $__vars['ad']['settings']['rel_custom'],
		)) . '
							'),
			'_type' => 'option',
		)), array(
			'label' => 'Rel attribute',
		)) . '

					<hr class="formRowSep" />

					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[target_blank]',
			'value' => '1',
			'selected' => ($__templater->method($__vars['ad'], 'isInsert', array()) ? 1 : $__vars['ad']['settings']['target_blank']),
			'label' => 'Open in a new tab',
			'_type' => 'option',
		),
		array(
			'name' => 'settings[hide_from_robots]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['hide_from_robots'],
			'label' => 'Hide from robots',
			'_type' => 'option',
		)), array(
		)) . '

					<hr class="formRowSep" />

					';
		if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'code', ), ))) {
			$__compilerTemp12 .= '
						' . $__templater->formCheckBoxRow(array(
			), array(array(
				'label' => 'Enable click fraud protection',
				'name' => 'settings[click_fraud][enabled]',
				'value' => '1',
				'selected' => $__vars['ad']['settings']['click_fraud']['enabled'],
				'data-hide' => 'true',
				'_dependent' => array('
									<dl class="inputLabelPair">
										<dt><label for="slidesToShow">' . 'Hide ad after' . '</label></dt>
										<dd>' . $__templater->formNumberBox(array(
				'name' => 'settings[click_fraud][click_limit]',
				'value' => $__vars['ad']['settings']['click_fraud']['click_limit'],
				'min' => '1',
				'units' => 'Clicks',
			)) . '</dd>
									</dl>
									<dl class="inputLabelPair">
										<dt><label for="slidesToShow">' . 'Hide ad for' . '</label></dt>
										<dd>' . $__templater->formNumberBox(array(
				'name' => 'settings[click_fraud][block_time]',
				'value' => $__vars['ad']['settings']['click_fraud']['block_time'],
				'min' => '0',
				'units' => 'Hours',
			)) . '</dd>
									</dl>
								'),
				'_type' => 'option',
			)), array(
				'explain' => 'This option is intended to be used with third-party ads such as AdSense. You can enable click fraud protection if you want to prevent click abuse, by hidding the ad after it has been clicked x times by the same visitor.',
			)) . '

						<hr class="formRowSep" />
					';
		}
		$__compilerTemp12 .= '

					';
		if ($__templater->method($__vars['ad'], 'isOfType', array(array('keyword', 'affiliate', ), ))) {
			$__compilerTemp12 .= '
						';
			$__compilerTemp13 = array(array(
				'name' => 'settings[post_type][thread]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['ad'], 'isInsert', array()) ? 1 : $__vars['ad']['settings']['post_type']['thread']),
				'label' => 'Discussion threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_poll]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['ad'], 'isInsert', array()) ? 1 : $__vars['ad']['settings']['post_type']['thread_poll']),
				'label' => 'Poll threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_article]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['ad'], 'isInsert', array()) ? 1 : $__vars['ad']['settings']['post_type']['thread_article']),
				'label' => 'Article threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_question]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['ad'], 'isInsert', array()) ? 1 : $__vars['ad']['settings']['post_type']['thread_question']),
				'label' => 'Question threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_suggestion]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['ad'], 'isInsert', array()) ? 1 : $__vars['ad']['settings']['post_type']['thread_suggestion']),
				'label' => 'Suggestion threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][conversation]',
				'value' => '1',
				'selected' => $__vars['ad']['settings']['post_type']['conversation'],
				'label' => 'Conversation messages',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][profile]',
				'value' => '1',
				'selected' => $__vars['ad']['settings']['post_type']['profile'],
				'label' => 'Profile posts',
				'_type' => 'option',
			));
			if ($__templater->func('is_addon_active', array('XFRM', ), false)) {
				$__compilerTemp13[] = array(
					'name' => 'settings[post_type][resource]',
					'value' => '1',
					'selected' => $__vars['ad']['settings']['post_type']['resource'],
					'label' => 'Resource description',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('Siropu/Chat', ), false)) {
				$__compilerTemp13[] = array(
					'name' => 'settings[post_type][chat]',
					'value' => '1',
					'selected' => $__vars['ad']['settings']['post_type']['chat'],
					'label' => 'Chat room messages',
					'_type' => 'option',
				);
				$__compilerTemp13[] = array(
					'name' => 'settings[post_type][chat_conv]',
					'value' => '1',
					'selected' => $__vars['ad']['settings']['post_type']['chat_conv'],
					'label' => 'Chat conversation messages',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('XenAddons/AMS', ), false)) {
				$__compilerTemp13[] = array(
					'name' => 'settings[post_type][ams_article]',
					'value' => '1',
					'selected' => $__vars['ad']['settings']['post_type']['ams_article'],
					'label' => 'AMS articles',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('XenAddons/Showcase', ), false)) {
				$__compilerTemp13[] = array(
					'name' => 'settings[post_type][showcase_item]',
					'value' => '1',
					'selected' => $__vars['ad']['settings']['post_type']['showcase_item'],
					'label' => 'Showcase item',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('DBTech/eCommerce', ), false)) {
				$__compilerTemp13[] = array(
					'name' => 'settings[post_type][dbtech_product_desc]',
					'value' => '1',
					'selected' => $__vars['ad']['settings']['post_type']['dbtech_product_desc'],
					'label' => 'DBTech eCommerce product description',
					'_type' => 'option',
				);
				$__compilerTemp13[] = array(
					'name' => 'settings[post_type][dbtech_product_spec]',
					'value' => '1',
					'selected' => $__vars['ad']['settings']['post_type']['dbtech_product_spec'],
					'label' => 'DBTech eCommerce product specifications',
					'_type' => 'option',
				);
			}
			$__compilerTemp12 .= $__templater->formCheckBoxRow(array(
			), $__compilerTemp13, array(
				'label' => 'Enable in',
			)) . '

						';
			if ($__templater->method($__vars['ad'], 'isKeyword', array())) {
				$__compilerTemp12 .= '
							' . $__templater->formNumberBoxRow(array(
					'name' => 'settings[keyword_limit]',
					'value' => $__vars['ad']['settings']['keyword_limit'],
					'size' => '5',
					'min' => '0',
				), array(
					'label' => 'Keyword post replace limit',
					'explain' => 'The maximum number of keywords in a post that can be turned into ads. Set to 0 for unlimited.',
				)) . '
							' . $__templater->formNumberBoxRow(array(
					'name' => 'settings[keyword_page_limit]',
					'value' => $__vars['ad']['settings']['keyword_page_limit'],
					'size' => '5',
					'min' => '0',
				), array(
					'label' => 'Keyword page replace limit',
					'explain' => 'The maximum number of keywords in a page that can be turned into ads. Set to 0 for unlimited.',
				)) . '

							' . $__templater->formCheckBoxRow(array(
				), array(array(
					'name' => 'settings[tooltip_title]',
					'selected' => $__vars['ad']['settings']['tooltip_title'],
					'label' => 'Display title as a tooltip',
					'_type' => 'option',
				),
				array(
					'name' => 'settings[overlay]',
					'selected' => $__vars['ad']['settings']['overlay'],
					'label' => 'Open in overlay (Internal links only)',
					'_type' => 'option',
				)), array(
				)) . '
						';
			}
			$__compilerTemp12 .= '
					';
		} else {
			$__compilerTemp12 .= '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'settings[display_after]',
				'value' => $__vars['ad']['settings']['display_after'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Display after x seconds',
				'explain' => 'If set, the ad will be displayed with a delay of x seconds.',
			)) . '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'settings[hide_after]',
				'value' => $__vars['ad']['settings']['hide_after'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Hide after x seconds',
				'explain' => 'If set, the ad will be hidden after x seconds of display.',
			)) . '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'settings[display_frequency]',
				'value' => $__vars['ad']['settings']['display_frequency'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Display every x minutes',
				'explain' => 'If set, a user will be able to view the ad every x minutes.',
				'hint' => 'Frequency cap',
			)) . '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'display_order',
				'value' => $__vars['ad']['display_order'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Display order',
				'explain' => 'Set the order of this ad in relation to the other ads in the same position.',
			)) . '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'display_priority',
				'value' => $__vars['ad']['display_priority'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Display priority',
				'explain' => 'Set the priority of this ad in relation to the other ads in the same position. The higher the priority, the higher the chance of being displayed first. This option only works with packages and random ordering.',
			)) . '
					';
		}
		$__compilerTemp12 .= '
				';
	}
	$__compilerTemp14 = '';
	if ($__templater->method($__vars['ad'], 'isPopup', array())) {
		$__compilerTemp14 .= '
					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[hide_close_button]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['hide_close_button'],
			'label' => 'Disable overlay close button',
			'_type' => 'option',
		)), array(
		)) . '
				';
	}
	$__compilerTemp15 = '';
	if ($__templater->method($__vars['ad'], 'isEmbeddable', array()) AND ((!$__vars['ad']['Extra']) OR ($__vars['ad']['Extra']['purchase'] == 0))) {
		$__compilerTemp15 .= '
					<hr class="formRowSep" />

					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'advertiser_list',
			'value' => '1',
			'selected' => $__vars['ad']['Extra'] AND $__vars['ad']['Extra']['advertiser_list'],
			'label' => 'Display in advertiser list',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to display the ad in the advertiser list.',
		)) . '
				';
	}
	$__compilerTemp16 = '';
	if (!$__templater->method($__vars['ad'], 'hasNoCriteria', array())) {
		$__compilerTemp16 .= '
				' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'position_panes', array(
			'criteria' => $__templater->method($__vars['positionCriteria'], 'getCriteriaForTemplate', array()),
			'data' => $__templater->method($__vars['positionCriteria'], 'getExtraTemplateData', array()),
		), $__vars) . '

				' . $__templater->callMacro('helper_criteria', 'user_panes', array(
			'criteria' => $__templater->method($__vars['userCriteria'], 'getCriteriaForTemplate', array()),
			'data' => $__templater->method($__vars['userCriteria'], 'getExtraTemplateData', array()),
		), $__vars) . '

				' . $__templater->callMacro('helper_criteria', 'page_panes', array(
			'criteria' => $__templater->method($__vars['pageCriteria'], 'getCriteriaForTemplate', array()),
			'data' => $__templater->method($__vars['pageCriteria'], 'getExtraTemplateData', array()),
		), $__vars) . '

				' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'device_panes', array(
			'criteria' => $__templater->method($__vars['deviceCriteria'], 'getCriteriaForTemplate', array()),
			'data' => $__templater->method($__vars['deviceCriteria'], 'getExtraTemplateData', array()),
		), $__vars) . '

				' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'geo_panes', array(
			'criteria' => $__templater->method($__vars['geoCriteria'], 'getCriteriaForTemplate', array()),
			'data' => $__templater->method($__vars['geoCriteria'], 'getExtraTemplateData', array()),
		), $__vars) . '
			';
	}
	$__compilerTemp17 = '';
	if ($__templater->method($__vars['ad'], 'isInsert', array())) {
		$__compilerTemp17 .= '
			' . $__templater->formHiddenVal('type', $__vars['ad']['type'], array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
			<span class="hScroller-scroll">
				<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('basic', ), true) . '">' . 'Basic information' . '</a>
				<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('settings', ), true) . '">' . 'Settings' . '</a>
				' . $__compilerTemp3 . '
			</span>
		</h2>

		<ul class="tabPanes block-body">
			<li role="tabpanel" id="' . $__templater->func('unique_id', array('basic', ), true) . '">
				' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'basic_info', array(
		'ad' => $__vars['ad'],
		'packages' => $__vars['packages'],
		'attachmentData' => $__vars['attachmentData'],
	), $__vars) . '
			</li>
			<li role="tabpanel" id="' . $__templater->func('unique_id', array('settings', ), true) . '">
				' . $__compilerTemp4 . '

				' . $__templater->formRow('
					<div class="inputGroup inputGroup--auto">
						' . $__templater->formDateInput(array(
		'name' => 'start_date',
		'value' => ($__vars['ad']['start_date'] ? $__templater->func('date', array($__vars['ad']['start_date'], 'picker', ), false) : ''),
	)) . '
						<span class="inputGroup-text">' . 'Time' . $__vars['xf']['language']['label_separator'] . '</span>
						' . $__templater->formSelect(array(
		'name' => 'start_date_hour',
		'value' => ($__vars['ad']['start_date'] ? $__vars['startHour'] : '00'),
	), $__compilerTemp8) . '
						<span class="inputGroup-text">:</span>
						' . $__templater->formSelect(array(
		'name' => 'start_date_minute',
		'value' => ($__vars['ad']['start_date'] ? $__templater->func('date', array($__vars['ad']['start_date'], 'i', ), false) : '00'),
	), $__compilerTemp9) . '
					</div>
				', array(
		'label' => 'Start date',
	)) . '

				' . $__templater->formRow('
					<div class="inputGroup inputGroup--auto">
						' . $__templater->formDateInput(array(
		'name' => 'end_date',
		'value' => ($__vars['ad']['end_date'] ? $__templater->func('date', array($__vars['ad']['end_date'], 'picker', ), false) : ''),
	)) . '
						<span class="inputGroup-text">' . 'Time' . $__vars['xf']['language']['label_separator'] . '</span>
						' . $__templater->formSelect(array(
		'name' => 'end_date_hour',
		'value' => ($__vars['ad']['end_date'] ? $__vars['endHour'] : '00'),
	), $__compilerTemp10) . '
						<span class="inputGroup-text">:</span>
						' . $__templater->formSelect(array(
		'name' => 'end_date_minute',
		'value' => ($__vars['ad']['end_date'] ? $__templater->func('date', array($__vars['ad']['end_date'], 'i', ), false) : '00'),
	), $__compilerTemp11) . '
					</div>
				', array(
		'label' => 'End date',
	)) . '

				' . $__compilerTemp12 . '

				' . $__compilerTemp14 . '

				' . $__compilerTemp15 . '
			</li>

			' . $__compilerTemp16 . '
		</ul>
		' . $__compilerTemp17 . '

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/save', $__vars['ad'], ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);