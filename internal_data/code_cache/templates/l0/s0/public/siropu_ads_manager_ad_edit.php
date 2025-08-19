<?php
// FROM HASH: dae2a69cbcc3cb0a6b2afd75257598c0
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
			' . $__templater->escape($__vars['package']['title']) . '
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
	$__templater->breadcrumbs($__templater->method($__vars['package'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	$__compilerTemp2 = '';
	if ($__vars['xf']['visitor']['is_admin']) {
		$__compilerTemp2 .= '
		' . $__templater->button('Edit package', array(
			'href' => $__templater->func('link_type', array('admin', 'ads-manager/packages/edit', $__vars['package'], ), false),
			'icon' => 'edit',
			'class' => 'button--link',
		), '', array(
		)) . '
	';
	}
	$__compilerTemp3 = '';
	if ($__templater->method($__vars['ad'], 'isUpdate', array()) AND $__templater->method($__vars['ad'], 'canDelete', array())) {
		$__compilerTemp3 .= '
		' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/ads/delete', $__vars['ad'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
	';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__compilerTemp2 . '
	' . $__compilerTemp3 . '
');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('siropu_ads_manager_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp4 = '';
	if (!$__vars['ad']['Forum']) {
		$__compilerTemp4 .= '
		.samPrefixId, .samCustomFields
		{
			display: none;
		}
	';
	}
	$__templater->inlineCss('
	.noEmptySlotsError
	{
		color: orangered;
		font-size: 12px;
	}
	.samFile
	{
		margin-bottom: 10px;
	}
	' . $__compilerTemp4 . '
');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/create.js',
		'min' => '1',
	));
	$__templater->inlineJs('
	jQuery.extend(XF.phrases, {
		siropu_ads_manager_please_set_keywords: "' . $__templater->filter('Please set your keywords first.', array(array('escape', array('js', )),), false) . '",
		siropu_ads_manager_you_can_still_create_ad: "' . $__templater->filter('However, you can still create an ad and once approved and the invoice is paid, your ad will be added to the queue until a slot becomes available.', array(array('escape', array('js', )),), false) . '"
	});
');
	$__finalCompiled .= '

';
	if (($__vars['package']['empty_slot_count'] == 0) AND $__templater->method($__vars['ad'], 'isInsert', array())) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important blockMessage--iconic">
		' . 'We are sorry, currently there are no empty slots available.' . ' ' . 'However, you can still create an ad and once approved and the invoice is paid, your ad will be added to the queue until a slot becomes available.' . '
	</div>

	';
		if (!$__templater->method($__vars['package'], 'isCostPer', array(array('cpm', 'cpc', ), ))) {
			$__finalCompiled .= '
		<div class="blockMessage blockMessage--important">
			<b>' . 'Time to wait' . $__vars['xf']['language']['label_separator'] . '</b> ' . $__templater->escape($__templater->method($__vars['package'], 'getTimeToWait', array())) . '
		</div>
	';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__vars['customCosts'] = $__vars['package']['cost_custom'];
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('', array(
		'label' => 'Package',
		'html' => $__templater->escape($__vars['package']['title']),
		'explain' => $__templater->filter($__vars['package']['description'], array(array('raw', array()),), true),
	)) . '

			';
	if ($__vars['package']['empty_slot_count']) {
		$__finalCompiled .= '
				';
		$__compilerTemp5 = '';
		if ($__templater->method($__vars['ad'], 'isInsert', array()) AND $__vars['pendingAdCount']) {
			$__compilerTemp5 .= '
						';
			if ($__vars['pendingAdCount'] > 1) {
				$__compilerTemp5 .= '
							' . 'Please note that there are <b>' . $__templater->escape($__vars['pendingAdCount']) . '</b> ads that haven\'t been approved yet.' . '
						';
			} else {
				$__compilerTemp5 .= '
							' . 'Please note that there is one ad that hasn\'t been approved yet.' . '
						';
			}
			$__compilerTemp5 .= '
					';
		}
		$__vars['emptySlotExplain'] = $__templater->preEscaped('
					' . $__compilerTemp5 . '
				');
		$__finalCompiled .= '
				' . $__templater->formRow('', array(
			'label' => 'Empty slots',
			'html' => $__templater->escape($__vars['package']['empty_slot_count']),
			'explain' => $__templater->escape($__vars['emptySlotExplain']),
		)) . '	
			';
	}
	$__finalCompiled .= '

			';
	if ($__vars['package']['guidelines']) {
		$__finalCompiled .= '
				' . $__templater->formRow('', array(
			'label' => 'Guidelines',
			'html' => $__templater->filter($__vars['package']['guidelines'], array(array('raw', array()),), true),
		)) . '
			';
	}
	$__finalCompiled .= '

			' . $__templater->formRow('', array(
		'label' => 'Cost',
		'html' => $__templater->escape($__vars['package']['cost']) . ' ' . ($__templater->method($__vars['package'], 'isFree', array()) ? (('(' . $__templater->escape($__templater->method($__vars['package'], 'getMinimumLength', array()))) . ')') : ''),
		'explain' => (($__templater->method($__vars['ad'], 'isKeyword', array()) AND (!$__templater->method($__vars['package'], 'isCpc', array()) OR $__templater->method($__vars['package'], 'isCpm', array()))) ? 'The cost is per keyword phrase.' : ''),
	)) . '

			<hr class="formRowSep" />
		</div>
	</div>
</div>

';
	$__vars['minPurchase'] = $__vars['package']['min_purchase'];
	$__finalCompiled .= '
';
	$__vars['maxPurchase'] = $__vars['package']['max_purchase'];
	$__finalCompiled .= '
';
	$__vars['costPer'] = $__vars['package']['cost_per'];
	$__finalCompiled .= '

';
	$__compilerTemp6 = '';
	if (!$__templater->method($__vars['ad'], 'hasNoCriteria', array())) {
		$__compilerTemp6 .= '
					';
		if ($__templater->method($__vars['ad'], 'canUseDeviceCriteria', array())) {
			$__compilerTemp6 .= '
						' . $__templater->callMacro('siropu_ads_manager_helper_criteria', 'device_tabs', array(), $__vars) . '
					';
		}
		$__compilerTemp6 .= '
					';
		if ($__templater->method($__vars['ad'], 'canUseGeoCriteria', array())) {
			$__compilerTemp6 .= '
						' . $__templater->callMacro('siropu_ads_manager_helper_criteria', 'geo_tabs', array(), $__vars) . '
					';
		}
		$__compilerTemp6 .= '
				';
	}
	$__compilerTemp7 = '';
	if ($__templater->method($__vars['ad'], 'isCode', array())) {
		$__compilerTemp7 .= '
					' . $__templater->formCodeEditorRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'class' => 'codeEditor--short',
			'mode' => 'html',
		), array(
			'label' => 'Code',
			'explain' => 'Paste your ad code here (AdSense, affiliate banners, etc).',
		)) . '
				';
	}
	$__compilerTemp8 = '';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'text', 'background', ), ))) {
		$__compilerTemp8 .= '
					';
		$__compilerTemp9 = '';
		$__compilerTemp10 = '';
		$__compilerTemp10 .= '
										';
		if ($__templater->method($__vars['ad'], 'canUseExternalBanners', array())) {
			$__compilerTemp10 .= '
											<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('bannerUrl', ), true) . '">' . 'Use from URL' . '</a>
										';
		}
		$__compilerTemp10 .= '
										';
		if ($__templater->method($__vars['ad'], 'canUseCustomBannerCode', array()) AND (!$__templater->method($__vars['ad'], 'isBackground', array()))) {
			$__compilerTemp10 .= '
											<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('bannerHtml', ), true) . '">' . 'Custom HTML' . '</a>
										';
		}
		$__compilerTemp10 .= '
									';
		if (strlen(trim($__compilerTemp10)) > 0) {
			$__compilerTemp9 .= '
							<h2 class="block-tabHeader tabs tabs--standalone hScroller" data-xf-init="tabs h-scroller" role="tablist" style="margin-bottom: 10px;">
								<span class="hScroller-scroll">
									<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('bannerUpload', ), true) . '">' . 'Upload from device' . '</a>
									' . $__compilerTemp10 . '
								</span>
							</h2>
						';
		}
		$__compilerTemp11 = '';
		if ($__templater->isTraversable($__vars['ad']['banner_file'])) {
			foreach ($__vars['ad']['banner_file'] AS $__vars['file']) {
				$__compilerTemp11 .= '
										<li class="samFile">
											';
				$__vars['bannerFile'] = $__templater->method($__vars['ad'], 'getAbsoluteFilePath', array($__vars['file'], ));
				$__compilerTemp11 .= '
										<li class="samFile">
											';
				if ($__templater->method($__vars['ad'], 'isFlash', array($__vars['file'], ))) {
					$__compilerTemp11 .= '
												' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'flash_banner', array(
						'ad' => $__vars['ad'],
						'file' => $__vars['bannerFile'],
					), $__vars) . '
											';
				} else if ($__templater->method($__vars['ad'], 'isMp4', array($__vars['file'], ))) {
					$__compilerTemp11 .= '
												' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'mp4_banner', array(
						'ad' => $__vars['ad'],
						'file' => $__vars['bannerFile'],
					), $__vars) . '
											';
				} else {
					$__compilerTemp11 .= '
												<img src="' . $__templater->escape($__vars['bannerFile']) . '">
											';
				}
				$__compilerTemp11 .= '
											<br>
											' . $__templater->button('Delete', array(
					'data-xf-click' => 'siropu-ads-manager-delete-file',
					'data-post-url' => $__templater->func('link', array('ads-manager/ads/delete-file', $__vars['ad'], ), false),
					'data-file' => $__vars['file'],
					'fa' => 'fas fa-trash',
				), '', array(
				)) . '
										</li>
									';
			}
		}
		$__compilerTemp12 = '';
		if ($__templater->method($__vars['ad'], 'canUseExternalBanners', array())) {
			$__compilerTemp12 .= '
								<li role="tabpanel" id="' . $__templater->func('unique_id', array('bannerUrl', ), true) . '">
									<ul class="listPlain inputGroup-container">
										';
			if ($__templater->isTraversable($__vars['ad']['banner_url'])) {
				foreach ($__vars['ad']['banner_url'] AS $__vars['url']) {
					$__compilerTemp12 .= '
											<li class="inputGroup">
												' . $__templater->formTextBox(array(
						'name' => 'banner_url[]',
						'type' => 'url',
						'dir' => 'ltr',
						'value' => $__vars['url'],
						'placeholder' => 'URL',
					)) . '
											</li>
										';
				}
			}
			$__compilerTemp12 .= '
										<li class="inputGroup" data-xf-init="field-adder" data-increment-format="banner_url[]">
											' . $__templater->formTextBox(array(
				'name' => 'banner_url[]',
				'type' => 'url',
				'dir' => 'ltr',
				'placeholder' => 'URL',
			)) . '
										</li>
									</ul>
									<dfn class="inputChoices-explain inputChoices-explain--after">' . 'If multiple URLs are provided, they will rotate randomly on each page load.' . '</dfn>
								</li>
							';
		}
		$__compilerTemp13 = '';
		if ($__templater->method($__vars['ad'], 'canUseCustomBannerCode', array()) AND (!$__templater->method($__vars['ad'], 'isBackground', array()))) {
			$__compilerTemp13 .= '
								<li role="tabpanel" id="' . $__templater->func('unique_id', array('bannerHtml', ), true) . '">
									' . $__templater->formTextArea(array(
				'name' => 'content_2',
				'value' => $__vars['ad']['content_2'],
				'rows' => '5',
			)) . '
									<dfn class="inputChoices-explain inputChoices-explain--after">' . 'This option allows you to build your own banner code using HTML/JavaScript.' . '</dfn>
								</li>
							';
		}
		$__compilerTemp8 .= $__templater->formRow('
						' . $__compilerTemp9 . '

						<ul class="tabPanes">
							<li role="tabpanel" class="is-active" id="' . $__templater->func('unique_id', array('bannerUpload', ), true) . '">
								<ul class="listPlain samFileList">
									' . $__compilerTemp11 . '
								</ul>
								' . $__templater->formUpload(array(
			'name' => 'upload[]',
			'accept' => '.gif,.jpeg,.jpg,.jpe,.png,.svg,.webp,.swf,.mp4',
			'multiple' => 'true',
		)) . '
								<dfn class="inputChoices-explain inputChoices-explain--after">' . 'If multiple files are provided, they will rotate randomly on each page load.' . '</dfn>
							</li>

							' . $__compilerTemp12 . '

							' . $__compilerTemp13 . '
						</ul>
					', array(
			'label' => ($__templater->method($__vars['ad'], 'isBackground', array()) ? 'Background image' : 'Banner file'),
		)) . '
				';
	}
	$__compilerTemp14 = '';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'text', ), ))) {
		$__compilerTemp14 .= '
					' . $__templater->formTextBoxRow(array(
			'name' => 'content_4',
			'value' => $__vars['ad']['content_4'],
			'maxlength' => '50',
		), array(
			'hint' => 'Optional',
			'label' => 'Alt text',
			'explain' => 'The alt attribute provides alternative information for an image if a user for some reason cannot view it (because of slow connection, an error in the src attribute, or if the user uses a screen reader).',
		)) . '
				';
	}
	$__compilerTemp15 = '';
	if ($__templater->method($__vars['ad'], 'isKeyword', array())) {
		$__compilerTemp15 .= '
					';
		if ($__templater->method($__vars['ad'], 'canEditKeywords', array())) {
			$__compilerTemp15 .= '
						';
			$__compilerTemp16 = '';
			if (!$__templater->test($__vars['package']['cost_custom'], 'empty', array())) {
				$__compilerTemp16 .= '
								<div class="block">
									<div class="block-container">
										<div class="block-body">
											';
				$__compilerTemp17 = '';
				if ($__templater->isTraversable($__vars['package']['cost_custom'])) {
					foreach ($__vars['package']['cost_custom'] AS $__vars['keyword'] => $__vars['cost']) {
						$__compilerTemp17 .= '
													' . $__templater->dataRow(array(
						), array(array(
							'data-cost-premium' => $__vars['cost'],
							'_type' => 'cell',
							'html' => $__templater->escape($__vars['keyword']),
						),
						array(
							'_type' => 'cell',
							'html' => $__templater->filter($__vars['cost'], array(array('currency', array($__vars['package']['cost_currency'], )),), true),
						))) . '
												';
					}
				}
				$__compilerTemp16 .= $__templater->dataList('
												' . $__templater->dataRow(array(
					'rowtype' => 'header',
				), array(array(
					'_type' => 'cell',
					'html' => 'Premium keywords',
				),
				array(
					'_type' => 'cell',
					'html' => 'Cost',
				))) . '
												' . $__compilerTemp17 . '
											', array(
					'data-xf-init' => 'responsive-data-list',
				)) . '
										</div>
									</div>
								</div>
							';
			}
			$__compilerTemp15 .= $__templater->formRow('
							' . $__compilerTemp16 . '

							' . $__templater->formTextArea(array(
				'name' => 'content_1',
				'value' => $__vars['ad']['content_1'],
				'rows' => '3',
				'placeholder' => 'Enter keyword(s)',
			)) . '

							<dfn class="inputChoices-explain inputChoices-explain--after">
								' . 'The keyword you want to target.' . '
							</dfn>
						', array(
				'label' => 'Keyword',
			)) . '

						';
			if ($__vars['package']['cost_exclusive'] > 0) {
				$__compilerTemp15 .= '
							' . $__templater->formCheckBoxRow(array(
				), array(array(
					'name' => 'exclusive_use',
					'value' => '1',
					'checked' => ($__vars['extra'] AND ($__vars['extra']['exclusive_use'] == 1)),
					'data-cost-exclusive' => $__vars['package']['cost_exclusive'],
					'label' => 'Exclusive keyword use' . ' (' . $__templater->filter($__vars['package']['cost_exclusive'], array(array('currency', array($__vars['package']['cost_currency'], )),), true) . ' / ' . 'Keyword' . ')',
					'_type' => 'option',
				)), array(
					'explain' => 'This option allows you to use keywords exclusively.',
				)) . '
						';
			}
			$__compilerTemp15 .= '
					';
		} else {
			$__compilerTemp15 .= '
						';
			$__compilerTemp18 = '';
			$__compilerTemp19 = $__templater->method($__vars['ad'], 'getKeywords', array());
			if ($__templater->isTraversable($__compilerTemp19)) {
				foreach ($__compilerTemp19 AS $__vars['keyword']) {
					$__compilerTemp18 .= '
									<li>' . $__templater->escape($__vars['keyword']) . '</li>
								';
				}
			}
			$__compilerTemp15 .= $__templater->formRow('
							<ol class="listPlain">
								' . $__compilerTemp18 . '
							</ol>
						', array(
				'label' => 'Keywords',
			)) . '
					';
		}
		$__compilerTemp15 .= '
				';
	}
	$__compilerTemp20 = '';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('text', 'link', ), )) OR ($__templater->method($__vars['ad'], 'isKeyword', array()) AND $__vars['xf']['options']['siropuAdsManagerKeywordDescription'])) {
		$__compilerTemp20 .= '
					' . $__templater->formTextBoxRow(array(
			'name' => 'title',
			'value' => $__vars['ad']['title'],
			'maxlength' => ($__templater->method($__vars['ad'], 'isKeyword', array()) ? $__vars['xf']['options']['siropuAdsManagerKeywordDescription'] : $__vars['xf']['options']['siropuAdsManagerMaxAdTitleLength']),
		), array(
			'label' => 'Title',
			'explain' => ($__templater->method($__vars['ad'], 'isKeyword', array()) ? '(Optional) If a title is provided, it will be displayed when hovering over the keyword.' : 'The title of the link that can be clicked on.'),
		)) . '
				';
	}
	$__compilerTemp21 = '';
	if ($__templater->method($__vars['ad'], 'isText', array())) {
		$__compilerTemp21 .= '
					' . $__templater->formTextAreaRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'maxlength' => $__vars['xf']['options']['siropuAdsManagerMaxAdDescriptionLength'],
			'rows' => '3',
		), array(
			'label' => 'Description',
		)) . '
				';
	}
	$__compilerTemp22 = '';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'text', 'link', 'keyword', 'background', ), ))) {
		$__compilerTemp22 .= '
					' . $__templater->formTextBoxRow(array(
			'name' => 'target_url',
			'type' => 'url',
			'dir' => 'ltr',
			'value' => $__vars['ad']['target_url'],
			'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'target_url', ), false),
		), array(
			'label' => 'Target URL',
			'explain' => 'The address of the website you want to link to.',
		)) . '
				';
	}
	$__compilerTemp23 = '';
	if ($__templater->method($__vars['ad'], 'isSticky', array())) {
		$__compilerTemp23 .= '
					';
		if ($__templater->method($__vars['ad'], 'isInsert', array())) {
			$__compilerTemp23 .= '
						';
			$__compilerTemp24 = array(array(
				'_type' => 'option',
			));
			if ($__templater->isTraversable($__vars['forums'])) {
				foreach ($__vars['forums'] AS $__vars['forum']) {
					$__compilerTemp24[] = array(
						'value' => $__vars['forum']['node_id'],
						'data-cost-custom' => $__vars['customCosts'][$__vars['forum']['node_id']],
						'label' => '
									' . $__templater->escape($__vars['forum']['title']) . ($__vars['customCosts'][$__vars['forum']['node_id']] ? ((((' (' . $__templater->filter($__vars['customCosts'][$__vars['forum']['node_id']], array(array('currency', array($__vars['package']['cost_currency'], )),), true)) . ' / ') . $__templater->escape($__templater->method($__vars['package'], 'getCostPerPhrase', array()))) . ')') : '') . '
								',
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp23 .= $__templater->formSelectRow(array(
				'name' => 'forum',
				'data-xf-init' => 'siropu-ads-manager-select-item',
				'data-fetch' => 'threads',
			), $__compilerTemp24, array(
				'label' => 'Select forum',
			)) . '

						' . $__templater->formSelectRow(array(
				'name' => 'item_id',
				'disabled' => 'disabled',
			), array(), array(
				'label' => 'Select thread',
			)) . '
					';
		} else {
			$__compilerTemp23 .= '
						' . $__templater->formRow('
							<a href="' . $__templater->func('link', array('threads', $__vars['ad']['Thread'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Thread']['title']) . '</a>
						', array(
				'label' => 'Thread',
			)) . '
					';
		}
		$__compilerTemp23 .= '
				';
	}
	$__compilerTemp25 = '';
	if ($__templater->method($__vars['ad'], 'isThread', array())) {
		$__compilerTemp25 .= '
					';
		if ($__vars['ad']['Thread']) {
			$__compilerTemp25 .= '
						' . $__templater->formRow('
							<a href="' . $__templater->func('link', array('forums', $__vars['ad']['Forum'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Forum']['title']) . '</a>
						', array(
				'label' => 'Forum',
			)) . '
						' . $__templater->formRow('
							<a href="' . $__templater->func('link', array('threads', $__vars['ad']['Thread'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Thread']['title']) . '</a>
						', array(
				'label' => 'Thread',
			)) . '
					';
		} else if ($__templater->method($__vars['ad'], 'canEditEssentialData', array())) {
			$__compilerTemp25 .= '
						';
			$__compilerTemp26 = array(array(
				'_type' => 'option',
			));
			if ($__templater->isTraversable($__vars['forums'])) {
				foreach ($__vars['forums'] AS $__vars['forum']) {
					$__compilerTemp26[] = array(
						'value' => $__vars['forum']['node_id'],
						'data-cost-custom' => $__vars['customCosts'][$__vars['forum']['node_id']],
						'label' => '
									' . $__templater->escape($__vars['forum']['title']) . ($__vars['customCosts'][$__vars['forum']['node_id']] ? ((((' (' . $__templater->filter($__vars['customCosts'][$__vars['forum']['node_id']], array(array('currency', array($__vars['package']['cost_currency'], )),), true)) . ' / ') . $__templater->escape($__templater->method($__vars['package'], 'getCostPerPhrase', array()))) . ')') : '') . '
								',
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp25 .= $__templater->formSelectRow(array(
				'name' => 'content_1',
				'value' => $__vars['ad']['content_1'],
				'data-xf-init' => 'siropu-ads-manager-select-forum',
			), $__compilerTemp26, array(
				'label' => 'Select forum',
			)) . '

						';
			if ($__vars['xf']['options']['siropuAdsManagerEnableCustomThreadPrefix']) {
				$__compilerTemp25 .= '
							';
				$__compilerTemp27 = array();
				if ($__vars['ad']['Forum']) {
					$__compilerTemp27[] = array(
						'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
						'_type' => 'option',
					);
					$__compilerTemp28 = $__templater->method($__vars['ad']['Forum'], 'getPrefixes', array());
					if ($__templater->isTraversable($__compilerTemp28)) {
						foreach ($__compilerTemp28 AS $__vars['prefix']) {
							if ($__vars['xf']['options']['siropuAdsManagerStickyThreadPrefix'] != $__vars['prefix']['prefix_id']) {
								$__compilerTemp27[] = array(
									'value' => $__vars['prefix']['prefix_id'],
									'label' => $__templater->escape($__vars['prefix']['title']),
									'_type' => 'option',
								);
							}
						}
					}
				}
				$__compilerTemp25 .= $__templater->formSelectRow(array(
					'name' => 'prefix_id',
					'value' => ($__vars['extra'] ? $__vars['extra']['prefix_id'] : 0),
				), $__compilerTemp27, array(
					'label' => 'Thread prefix',
					'rowclass' => 'samPrefixId',
				)) . '
						';
			}
			$__compilerTemp25 .= '

						' . $__templater->formTextBoxRow(array(
				'name' => 'content_2',
				'value' => $__vars['ad']['content_2'],
			), array(
				'label' => 'Thread title',
			)) . '

						<div data-xf-init="attachment-manager">
							' . $__templater->formEditorRow(array(
				'name' => 'content',
				'value' => $__vars['ad']['content_3'],
			), array(
				'label' => 'Thread content',
			)) . '
							';
			if ($__vars['attachmentData']) {
				$__compilerTemp25 .= '
								' . $__templater->formRow('
									' . $__templater->callMacro('helper_attach_upload', 'upload_block', array(
					'attachmentData' => $__vars['attachmentData'],
				), $__vars) . '
								', array(
				)) . '
							';
			}
			$__compilerTemp25 .= '
						</div>

						';
			if ($__vars['extra'] AND $__vars['extra']['custom_fields']) {
				$__compilerTemp25 .= '
							' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
					'type' => 'threads',
					'set' => $__templater->method($__vars['extra'], 'getCustomFields', array()),
					'onlyInclude' => $__vars['ad']['Forum']['field_cache'],
				), $__vars) . '
						';
			}
			$__compilerTemp25 .= '

						' . $__templater->formRow('', array(
				'rowclass' => 'samCustomFields',
			)) . '

						';
			if ($__vars['package']['cost_sticky'] > 0) {
				$__compilerTemp25 .= '
							' . $__templater->formCheckBoxRow(array(
				), array(array(
					'name' => 'sticky',
					'value' => '1',
					'checked' => ($__vars['extra'] AND ($__vars['extra']['is_sticky'] == 1)),
					'data-cost-sticky' => $__vars['package']['cost_sticky'],
					'data-xf-init' => 'siropu-ads-manager-can-stick-thread',
					'label' => 'Stick thread' . ' (' . $__templater->filter($__vars['package']['cost_sticky'], array(array('currency', array($__vars['package']['cost_currency'], )),), true) . ')',
					'_type' => 'option',
				)), array(
					'explain' => 'Sticky threads are displayed at the top of the thread list based on the last post date.',
				)) . '
						';
			}
			$__compilerTemp25 .= '
					';
		} else {
			$__compilerTemp25 .= '
						' . $__templater->formRow('
							<a href="' . $__templater->func('link', array('forums', $__vars['ad']['Forum'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Forum']['title']) . '</a>
						', array(
				'label' => 'Forum',
			)) . '

						';
			if ($__vars['extra']['ThreadPrefix']) {
				$__compilerTemp25 .= '
							' . $__templater->formRow('', array(
					'label' => 'Prefix',
					'html' => $__templater->escape($__vars['extra']['ThreadPrefix']['title']),
				)) . '
						';
			}
			$__compilerTemp25 .= '

						';
			if ($__vars['extra']['custom_fields']) {
				$__compilerTemp25 .= '
							' . $__templater->formRow('
								' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
					'type' => 'threads',
					'group' => 'before',
					'set' => $__templater->method($__vars['extra'], 'getCustomFields', array()),
					'onlyInclude' => $__vars['ad']['Forum']['field_cache'],
				), $__vars) . '
							', array(
					'label' => 'Custom fields',
				)) . '
						';
			}
			$__compilerTemp25 .= '

						' . $__templater->formRow('', array(
				'label' => 'Thread title',
				'html' => $__templater->escape($__vars['ad']['content_2']),
			)) . '
						' . $__templater->formRow('', array(
				'label' => 'Thread content',
				'html' => $__templater->func('bb_code', array($__vars['ad']['content_3'], 'post', $__vars['ad'], ), true),
			)) . '
					';
		}
		$__compilerTemp25 .= '
				';
	}
	$__compilerTemp29 = '';
	if ($__templater->method($__vars['ad'], 'isResource', array())) {
		$__compilerTemp29 .= '
					';
		if ($__templater->method($__vars['ad'], 'isInsert', array())) {
			$__compilerTemp29 .= '
						';
			$__compilerTemp30 = array(array(
				'_type' => 'option',
			));
			if ($__templater->isTraversable($__vars['categories'])) {
				foreach ($__vars['categories'] AS $__vars['category']) {
					$__compilerTemp30[] = array(
						'value' => $__vars['category']['resource_category_id'],
						'data-cost-custom' => $__vars['customCosts'][$__vars['category']['resource_category_id']],
						'label' => '
									' . $__templater->escape($__vars['category']['title']) . ($__vars['customCosts'][$__vars['category']['resource_category_id']] ? ((((' (' . $__templater->filter($__vars['customCosts'][$__vars['category']['resource_category_id']], array(array('currency', array($__vars['package']['cost_currency'], )),), true)) . ' / ') . $__templater->escape($__templater->method($__vars['package'], 'getCostPerPhrase', array()))) . ')') : '') . '
								',
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp29 .= $__templater->formSelectRow(array(
				'data-xf-init' => 'siropu-ads-manager-select-item',
				'data-fetch' => 'resources',
			), $__compilerTemp30, array(
				'label' => 'Select category',
			)) . '

						' . $__templater->formSelectRow(array(
				'name' => 'item_id',
				'disabled' => 'disabled',
			), array(), array(
				'label' => 'Select resource',
			)) . '
					';
		} else {
			$__compilerTemp29 .= '
						' . $__templater->formRow('
							<a href="' . $__templater->func('link', array('resources', $__vars['ad']['Resource'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Resource']['title']) . '</a>
						', array(
				'label' => 'Resource',
			)) . '
					';
		}
		$__compilerTemp29 .= '
				';
	}
	$__compilerTemp31 = '';
	if ($__templater->method($__vars['ad'], 'isPopup', array())) {
		$__compilerTemp31 .= '
					' . $__templater->formTextBoxRow(array(
			'name' => 'title',
			'value' => $__vars['ad']['title'],
			'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'title', ), false),
		), array(
			'label' => 'Popup title',
			'explain' => 'The title of the popup.',
		)) . '

					' . $__templater->formTextAreaRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'rows' => '3',
		), array(
			'label' => 'Popup content',
			'explain' => 'The content that will be displayed inside the popup.' . ' ' . 'Allowed HTML tags: ' . $__templater->filter('<br>, <p>, <span>, <b>, <i>, <em>, <a>, <ul>, <ol>, <li>', array(array('for_attr', array()),), true) . '',
		)) . '
				';
	}
	$__compilerTemp32 = '';
	if ($__templater->method($__vars['ad'], 'isCustom', array())) {
		$__compilerTemp32 .= '
					' . $__templater->formTextAreaRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'rows' => '10',
		), array(
			'label' => 'Ad details',
			'explain' => 'Please provide the ad details based on the package specifications.',
		)) . '
				';
	}
	$__compilerTemp33 = '';
	if ($__templater->method($__vars['ad'], 'canEditEssentialData', array())) {
		$__compilerTemp33 .= '
					<hr class="formRowSep" />

					';
		if ($__vars['minPurchase'] < $__vars['maxPurchase']) {
			$__compilerTemp33 .= '
						';
			$__compilerTemp34 = '';
			if ($__vars['package']['discount']) {
				$__compilerTemp34 .= '
								';
				$__compilerTemp35 = array();
				$__compilerTemp36 = $__templater->method($__vars['package'], 'getDiscountSorted', array());
				if ($__templater->isTraversable($__compilerTemp36)) {
					foreach ($__compilerTemp36 AS $__vars['purchase'] => $__vars['discount']) {
						$__compilerTemp35[] = array(
							'data-discount' => $__vars['discount'],
							'data-purchase' => $__vars['purchase'],
							'checked' => ($__vars['extra'] AND ($__vars['extra']['purchase'] == $__vars['purchase'])),
							'label' => $__templater->escape($__vars['purchase']) . ' ' . $__templater->escape($__templater->method($__vars['package'], 'getCostPerPhrase', array($__vars['purchase'], ))) . ' (' . $__templater->escape($__vars['discount']) . '% ' . 'Discount' . ')',
							'_type' => 'option',
						);
					}
				}
				$__compilerTemp34 .= $__templater->formRadio(array(
					'name' => 'discount',
					'style' => 'margin-bottom: 10px;',
				), $__compilerTemp35) . '
							';
			}
			$__compilerTemp33 .= $__templater->formRow('
							' . $__compilerTemp34 . '
							' . $__templater->formNumberBox(array(
				'name' => 'purchase',
				'step' => (($__vars['costPer'] == 'cpm') ? 1000 : (($__vars['costPer'] == 'cpc') ? $__vars['minPurchase'] : 1)),
				'value' => ($__vars['extra'] ? $__vars['extra']['purchase'] : $__vars['minPurchase']),
				'size' => '5',
				'min' => $__vars['minPurchase'],
				'max' => $__vars['maxPurchase'],
				'units' => $__templater->method($__vars['package'], 'getCostPerPhrase', array(2, )),
			)) . '
						', array(
				'label' => 'Purchase',
				'explain' => 'You can choose a value between ' . $__templater->escape($__vars['minPurchase']) . ' and ' . $__templater->escape($__vars['maxPurchase']) . '.',
			)) . '
					';
		}
		$__compilerTemp33 .= '

					';
		if (!$__templater->method($__vars['package'], 'isFree', array())) {
			$__compilerTemp33 .= '
						';
			if (!$__templater->test($__vars['usablePromoCodes'], 'empty', array())) {
				$__compilerTemp33 .= '
							' . $__templater->formCheckBoxRow(array(
					'data-xf-init' => 'siropu-ads-manager-apply-promo-code',
				), array(array(
					'label' => 'Do you have a promo code?',
					'checked' => $__vars['promoCode'],
					'data-hide' => 'true',
					'_dependent' => array('
										<div class="inputGroup inputGroup--auto">
											' . $__templater->formTextBox(array(
					'name' => 'promo_code',
					'value' => ($__vars['promoCode'] ? $__vars['promoCode']['promo_code'] : ''),
					'placeholder' => 'Enter promo code',
					'autocomplete' => 'off',
					'data-discount-type' => ($__vars['promoCode'] ? $__vars['promoCode']['type'] : ''),
					'data-discount-value' => ($__vars['promoCode'] ? $__vars['promoCode']['value'] : ''),
				)) . '
											<span class="inputGroup-splitter"></span>
											' . $__templater->button('Apply', array(
				), '', array(
				)) . '
										</div>
									'),
					'_type' => 'option',
				)), array(
				)) . '
						';
			}
			$__compilerTemp33 .= '

						<hr class="formRowSep" />

						';
			$__vars['totalCost'] = ($__vars['package']['cost_amount'] * (($__vars['costPer'] == 'cpm') ? ($__vars['minPurchase'] / 1000) : $__vars['minPurchase']));
			$__compilerTemp33 .= '

						' . $__templater->formRow('
							<span id="samTotalCost" data-cost-amount="' . $__templater->escape($__vars['totalCost']) . '">' . $__templater->escape($__vars['totalCost']) . ' ' . $__templater->escape($__vars['package']['cost_currency']) . '</span>
						', array(
				'label' => 'Total cost',
				'style' => 'font-weight: bold;',
			)) . '
					';
		}
		$__compilerTemp33 .= '
				';
	}
	$__compilerTemp37 = '';
	if (!$__templater->method($__vars['ad'], 'hasNoCriteria', array())) {
		$__compilerTemp37 .= '
				';
		if ($__templater->method($__vars['ad'], 'canUseDeviceCriteria', array())) {
			$__compilerTemp37 .= '
					' . $__templater->callMacro('siropu_ads_manager_helper_criteria', 'device_panes', array(
				'criteria' => $__templater->method($__vars['deviceCriteria'], 'getCriteriaForTemplate', array()),
				'data' => $__templater->method($__vars['deviceCriteria'], 'getExtraTemplateData', array()),
			), $__vars) . '
				';
		}
		$__compilerTemp37 .= '

				';
		if ($__templater->method($__vars['ad'], 'canUseGeoCriteria', array())) {
			$__compilerTemp37 .= '
					' . $__templater->callMacro('siropu_ads_manager_helper_criteria', 'geo_panes', array(
				'criteria' => $__templater->method($__vars['geoCriteria'], 'getCriteriaForTemplate', array()),
				'data' => $__templater->method($__vars['geoCriteria'], 'getExtraTemplateData', array()),
			), $__vars) . '
				';
		}
		$__compilerTemp37 .= '
			';
	}
	$__vars['canBypassApproval'] = ($__templater->method($__vars['xf']['visitor'], 'canBypassApprovalSiropuAdsManager', array()) OR $__templater->method($__vars['ad']['Package'], 'getSetting', array('no_approval', )));
	$__compilerTemp38 = '';
	if ((!$__vars['canBypassApproval']) OR (!$__templater->method($__vars['ad'], 'isUpdate', array()) AND $__templater->method($__vars['xf']['visitor'], 'canEditWithoutApprovalSiropuAdsManager', array()))) {
		$__compilerTemp38 .= '
			<div class="block-footer">
				' . $__templater->fontAwesome('fas fa-info-circle', array(
		)) . '
				';
		if ($__templater->method($__vars['package'], 'isFree', array())) {
			$__compilerTemp38 .= '
					' . 'Please note that ads are reviewed by administrators and require their approval. Once approved, the ad will become active if there are ad spaces available, else the ad will be queued.' . '
				';
		} else {
			$__compilerTemp38 .= '
					' . 'Please note that ads are reviewed by administrators and require their approval. Once approved, an invoice will be generated for you to pay.' . '
				';
		}
		$__compilerTemp38 .= '
			</div>
		';
	}
	$__compilerTemp39 = '';
	if ($__templater->method($__vars['ad'], 'isInsert', array()) AND $__vars['xf']['options']['siropuAdsManagerTermsAndConditions']) {
		$__compilerTemp39 .= '
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'terms_agreement',
			'value' => '1',
			'label' => 'I agree with the <a href="' . $__templater->func('link', array('ads-manager/terms-and-conditions', ), true) . '" data-xf-click="overlay">Terms and Conditions</a>',
			'_type' => 'option',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
			<span class="hScroller-scroll">
				<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('basic_information', ), true) . '">' . 'Basic information' . '</a>
				' . $__compilerTemp6 . '
				<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('options', ), true) . '">' . 'Options' . '</a>
			</span>
		</h2>

		<ul class="tabPanes block-body">
			<li role="tabpanel" class="is-active" id="' . $__templater->func('unique_id', array('basic_information', ), true) . '">
				' . $__templater->formTextBoxRow(array(
		'name' => 'name',
		'value' => $__vars['ad']['name'],
		'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'name', ), false),
	), array(
		'label' => 'Ad name',
	)) . '

				' . $__compilerTemp7 . '

				' . $__compilerTemp8 . '

				' . $__compilerTemp14 . '

				' . $__compilerTemp15 . '

				' . $__compilerTemp20 . '

				' . $__compilerTemp21 . '

				' . $__compilerTemp22 . '

				' . $__compilerTemp23 . '

				' . $__compilerTemp25 . '

				' . $__compilerTemp29 . '

				' . $__compilerTemp31 . '

				' . $__compilerTemp32 . '
		
				' . $__compilerTemp33 . '
			</li>

			' . $__compilerTemp37 . '

			<li role="tabpanel" id="' . $__templater->func('unique_id', array('options', ), true) . '">
				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'alert_notification',
		'value' => '1',
		'checked' => ($__templater->method($__vars['ad'], 'isInsert', array()) OR ($__vars['extra']['alert_notification'] == 1)),
		'label' => 'Receive alert notifications',
		'_type' => 'option',
	)), array(
		'explain' => 'You will receive alert notifications in your user account about your ad status.',
	)) . '

				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'email_notification',
		'value' => '1',
		'checked' => ($__templater->method($__vars['ad'], 'isInsert', array()) OR ($__vars['extra']['email_notification'] == 1)),
		'label' => 'Receive email notifications',
		'_type' => 'option',
	)), array(
		'explain' => 'You will receive email notifications in your inbox about your ad status.',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formTextAreaRow(array(
		'name' => 'notes',
		'value' => $__vars['extra']['notes'],
	), array(
		'label' => 'Notes',
		'explain' => 'Information that you may want to provide for this ad.',
	)) . '
			</li>
		</ul>

		' . '' . '

		' . $__compilerTemp38 . '

		' . $__templater->formHiddenVal('package_id', $__vars['ad']['package_id'], array(
	)) . '
		' . $__templater->formSubmitRow(array(
		'name' => 'save',
		'icon' => 'save',
	), array(
		'html' => '
				' . $__compilerTemp39 . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/save', $__vars['ad'], ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
		'data-ad-type' => $__vars['ad']['type'],
		'data-ad-id' => $__vars['ad']['ad_id'],
		'data-cost-amount' => $__vars['package']['cost_amount'],
		'data-cost-currency' => $__vars['package']['cost_currency'],
		'data-cost-per' => $__vars['costPer'],
		'data-min-purchase' => $__vars['minPurchase'],
		'data-xf-init' => 'siropu-ads-manager-create',
	));
	return $__finalCompiled;
}
);