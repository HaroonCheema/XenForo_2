<?php
// FROM HASH: a8b0ad21f2d70d32762867ab2ae4a9e1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('sc_item', $__vars['item'], 'escaped', ), true) . ($__vars['item']['meta_title'] ? $__templater->escape($__vars['item']['meta_title']) : $__templater->escape($__vars['item']['title'])));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	if (!$__templater->method($__vars['item'], 'isSearchEngineIndexable', array())) {
		$__finalCompiled .= '
	';
		$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['item']['meta_description']) {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['meta_description'], 320, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	} else if ($__vars['item']['description']) {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['description'], 256, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['message'], 256, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'metadata', array(
		'title' => ($__vars['item']['og_title'] ? $__vars['item']['og_title'] : ($__vars['item']['meta_title'] ? $__vars['item']['meta_title'] : $__vars['item']['title'])),
		'description' => $__vars['descSnippet'],
		'type' => 'article',
		'shareUrl' => $__templater->func('link', array('canonical:showcase', $__vars['item'], ), false),
		'canonicalUrl' => $__templater->func('link', array('canonical:showcase', $__vars['item'], array('page' => (($__vars['page'] > 1) ? $__vars['page'] : null), ), ), false),
		'imageUrl' => ($__vars['item']['CoverImage'] ? $__templater->func('link', array('canonical:showcase/cover-image', $__vars['item'], ), false) : ($__vars['item']['Category']['content_image_url'] ? $__templater->func('base_url', array($__vars['item']['Category']['content_image_url'], true, ), false) : '')),
		'twitterCard' => 'summary_large_image',
	), $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__vars['item']['meta_title']) {
		$__compilerTemp1 .= '
			"headline": "' . $__templater->filter($__vars['item']['meta_title'], array(array('escape', array('json', )),), true) . '",
		';
	} else {
		$__compilerTemp1 .= '
			"headline": "' . $__templater->filter($__vars['item']['title'], array(array('escape', array('json', )),), true) . '",
		';
	}
	$__compilerTemp2 = '';
	if ($__vars['item']['og_title']) {
		$__compilerTemp2 .= '
			"alternativeHeadline": "' . $__templater->filter($__vars['item']['og_title'], array(array('escape', array('json', )),), true) . '",
		';
	} else {
		$__compilerTemp2 .= '
			"alternativeHeadline": "' . $__templater->filter($__vars['item']['title'], array(array('escape', array('json', )),), true) . '",
		';
	}
	$__compilerTemp3 = '';
	if ($__vars['item']['cover_image_id'] AND $__vars['item']['CoverImage']) {
		$__compilerTemp3 .= '
			"thumbnailUrl": "' . $__templater->filter($__templater->method($__vars['item']['CoverImage'], 'getThumbnailUrlFull', array()), array(array('escape', array('json', )),), true) . '",
		';
	} else if ($__vars['item']['Category']['content_image_url']) {
		$__compilerTemp3 .= '
			"thumbnailUrl": "' . $__templater->filter($__templater->func('base_url', array($__vars['item']['Category']['content_image_url'], true, ), false), array(array('escape', array('json', )),), true) . '",
		';
	}
	$__compilerTemp4 = '';
	if ($__vars['item']['rating_count']) {
		$__compilerTemp4 .= '"aggregateRating": {
			"@type": "AggregateRating",
			"ratingCount": "' . $__templater->filter($__vars['item']['rating_count'], array(array('escape', array('json', )),), true) . '",
			"ratingValue": "' . $__templater->filter($__vars['item']['rating_avg'], array(array('escape', array('json', )),), true) . '"
		},';
	}
	$__compilerTemp5 = '';
	if ($__templater->method($__vars['item'], 'hasViewableDiscussion', array())) {
		$__compilerTemp5 .= '
			"discussionUrl": "' . $__templater->filter($__templater->func('link', array('canonical:threads', $__vars['item']['Discussion'], ), false), array(array('escape', array('json', )),), true) . '",
		';
	}
	$__templater->setPageParam('ldJsonHtml', '
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "CreativeWorkSeries",
		"@id": "' . $__templater->filter($__templater->func('link', array('canonical:showcase', $__vars['item'], ), false), array(array('escape', array('json', )),), true) . '",
		"name": "' . $__templater->filter($__vars['item']['title'], array(array('escape', array('json', )),), true) . '",
		' . $__compilerTemp1 . '
		' . $__compilerTemp2 . '		
		"description": "' . $__templater->filter($__vars['descSnippet'], array(array('escape', array('json', )),), true) . '",
		' . $__compilerTemp3 . '
		"dateCreated": "' . $__templater->filter($__templater->func('date', array($__vars['item']['create_date'], 'c', ), false), array(array('escape', array('json', )),), true) . '",
		"dateModified": "' . $__templater->filter($__templater->func('date', array($__vars['item']['last_update'], 'c', ), false), array(array('escape', array('json', )),), true) . '",
		' . $__compilerTemp4 . '
		' . $__compilerTemp5 . '
		"author": {
			"@type": "Person",
			"name": "' . $__templater->filter(($__vars['item']['User'] ? $__vars['item']['User']['username'] : $__vars['item']['username']), array(array('escape', array('json', )),), true) . '"
		}
	}
	</script>
');
	$__finalCompiled .= '

';
	$__compilerTemp6 = $__vars;
	$__compilerTemp6['pageSelected'] = 'overview';
	$__templater->wrapTemplate('xa_sc_item_wrapper', $__compilerTemp6);
	$__finalCompiled .= '

' . $__templater->callMacro('lightbox_macros', 'setup', array(
		'canViewAttachments' => $__templater->method($__vars['item'], 'canViewItemAttachments', array()),
	), $__vars) . '

<div class="block">
	';
	$__compilerTemp7 = '';
	$__compilerTemp7 .= '
				' . $__templater->callMacro('xa_sc_item_wrapper_macros', 'action_buttons', array(
		'item' => $__vars['item'],
		'showPostAnUpdateButton' => true,
		'showRateButton' => true,
	), $__vars) . '
			';
	if (strlen(trim($__compilerTemp7)) > 0) {
		$__finalCompiled .= '
		<div class="block-outer">
			<div class="block-outer-opposite">
			' . $__compilerTemp7 . '
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
	
	';
	if ($__vars['poll']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('poll_macros', 'poll_block', array(
			'poll' => $__vars['poll'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	
	<div class="block-container">
		<div class="block-body lbContainer js-itemBody"
			data-xf-init="lightbox"
			data-lb-id="item-' . $__templater->escape($__vars['item']['item_id']) . '"
			data-lb-caption-desc="' . ($__vars['item']['User'] ? $__templater->escape($__vars['item']['User']['username']) : $__templater->escape($__vars['item']['username'])) . ' &middot; ' . $__templater->func('date_time', array($__vars['item']['create_date'], ), true) . '"
			id="js-itemBody-' . $__templater->escape($__vars['item']['item_id']) . '">

			<div class="itemBody">
				<article class="itemBody-main js-lbContainer"
					data-lb-id="item-' . $__templater->escape($__vars['item']['item_id']) . '"
					data-lb-caption-desc="' . ($__vars['item']['User'] ? $__templater->escape($__vars['item']['User']['username']) : $__templater->escape($__vars['item']['username'])) . ' &middot; ' . $__templater->func('date_time', array($__vars['item']['create_date'], ), true) . '">

					';
	if (($__vars['xf']['options']['xaScGalleryLocation'] == 'above_item') AND $__vars['item']['attach_count']) {
		$__finalCompiled .= '
						';
		$__compilerTemp8 = '';
		$__compilerTemp8 .= '
									';
		if ($__templater->isTraversable($__vars['item']['Attachments'])) {
			foreach ($__vars['item']['Attachments'] AS $__vars['attachment']) {
				if ($__vars['attachment']['has_thumbnail'] AND (!$__templater->method($__vars['item'], 'isAttachmentEmbedded', array($__vars['attachment'], )))) {
					$__compilerTemp8 .= '
										' . $__templater->callMacro('attachment_macros', 'attachment_list_item', array(
						'attachment' => $__vars['attachment'],
						'canView' => $__templater->method($__vars['item'], 'canViewItemAttachments', array()),
					), $__vars) . '
									';
				}
			}
		}
		$__compilerTemp8 .= '
								';
		if (strlen(trim($__compilerTemp8)) > 0) {
			$__finalCompiled .= '
							';
			$__templater->includeCss('attachments.less');
			$__finalCompiled .= '
							<ul class="attachmentList itemBody-attachments">
								' . $__compilerTemp8 . '
							</ul>
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					' . $__templater->callAdsMacro('sc_item_view_above_item_sections_content', array(
		'item' => $__vars['item'],
	), $__vars) . '
					
					';
	if (($__vars['item']['description'] != '') AND $__vars['xf']['options']['xaScDisplayDescriptionItemDetails']) {
		$__finalCompiled .= '
						<div class="bbWrapper itemBody-description">
							' . $__templater->func('snippet', array($__vars['item']['description'], 255, array('stripBbCode' => true, ), ), true) . '
						</div>
					';
	}
	$__finalCompiled .= '					

					';
	if (!$__templater->method($__vars['item'], 'canViewFullItem', array())) {
		$__finalCompiled .= '
						<h3>' . $__templater->escape($__vars['category']['title_s1']) . '</h3>

						' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'section_1',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => 'itemBody-fields itemBody-fields--before',
		), $__vars) . '

						' . $__templater->func('bb_code', array($__vars['trimmedItem'], 'sc_item', $__vars['item'], ), true) . '

						<div class="block-rowMessage block-rowMessage--important">
							' . 'You do not have permission to view the full content of this item.' . '
							';
		if (!$__vars['xf']['visitor']['user_id']) {
			$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('login', ), true) . '" data-xf-click="overlay">' . 'Log in or register now.' . '</a>
							';
		}
		$__finalCompiled .= '
						</div>
					';
	} else {
		$__finalCompiled .= '
						<h3>' . $__templater->escape($__vars['category']['title_s1']) . '</h3>

						' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'section_1',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => 'itemBody-fields itemBody-fields--before',
		), $__vars) . '

						' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
			'position' => 'sc_item_above_content',
		), $__vars) . '
' . $__templater->filter($__templater->func('bb_code', array($__vars['item']['message'], 'sc_item', $__vars['item'], ), false), array(array('sam_keyword_ads', array('showcase_item', $__vars['xf']['samFilterAds'], $__vars['item'], $__vars['item']['User'] AND $__templater->method($__vars['item']['User'], 'isMemberOf', array($__vars['xf']['options']['siropuAdsManagerUserGroupPostExceptions'], )), )),), true) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
			'position' => 'sc_item_below_content',
		), $__vars) . '

						';
		if ($__vars['xf']['options']['xaScSectionsDisplayType'] == 'stacked') {
			$__finalCompiled .= '
							';
			if ($__vars['category']['title_s2']) {
				$__finalCompiled .= '
								';
				$__compilerTemp9 = '';
				$__compilerTemp9 .= '
										' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
					'type' => 'sc_items',
					'group' => 'section_2',
					'onlyInclude' => $__vars['category']['field_cache'],
					'set' => $__vars['item']['custom_fields'],
					'wrapperClass' => 'itemBody-fields itemBody-fields--before',
				), $__vars) . '

										';
				if ($__vars['category']['editor_s2'] AND ($__vars['item']['message_s2'] != '')) {
					$__compilerTemp9 .= '
											' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_above_s2_content',
					), $__vars) . '
' . $__templater->filter($__templater->func('bb_code', array($__vars['item']['message_s2'], 'sc_item', $__vars['item'], ), false), array(array('sam_keyword_ads', array('showcase_item', $__vars['xf']['samFilterAds'], $__vars['item'], $__vars['item']['User'] AND $__templater->method($__vars['item']['User'], 'isMemberOf', array($__vars['xf']['options']['siropuAdsManagerUserGroupPostExceptions'], )), )),), true) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_below_s2_content',
					), $__vars) . '
										';
				}
				$__compilerTemp9 .= '
									';
				if (strlen(trim($__compilerTemp9)) > 0) {
					$__finalCompiled .= '
									<h3>' . $__templater->escape($__vars['category']['title_s2']) . '</h3>
									' . $__compilerTemp9 . '
								';
				}
				$__finalCompiled .= '
							';
			}
			$__finalCompiled .= '

							';
			if ($__vars['category']['title_s3']) {
				$__finalCompiled .= '
								';
				$__compilerTemp10 = '';
				$__compilerTemp10 .= '
										' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
					'type' => 'sc_items',
					'group' => 'section_3',
					'onlyInclude' => $__vars['category']['field_cache'],
					'set' => $__vars['item']['custom_fields'],
					'wrapperClass' => 'itemBody-fields itemBody-fields--before',
				), $__vars) . '

										';
				if ($__vars['category']['editor_s3'] AND ($__vars['item']['message_s3'] != '')) {
					$__compilerTemp10 .= '
											' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_above_s3_content',
					), $__vars) . '
' . $__templater->filter($__templater->func('bb_code', array($__vars['item']['message_s3'], 'sc_item', $__vars['item'], ), false), array(array('sam_keyword_ads', array('showcase_item', $__vars['xf']['samFilterAds'], $__vars['item'], $__vars['item']['User'] AND $__templater->method($__vars['item']['User'], 'isMemberOf', array($__vars['xf']['options']['siropuAdsManagerUserGroupPostExceptions'], )), )),), true) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_below_s3_content',
					), $__vars) . '
										';
				}
				$__compilerTemp10 .= '
									';
				if (strlen(trim($__compilerTemp10)) > 0) {
					$__finalCompiled .= '
									<h3>' . $__templater->escape($__vars['category']['title_s3']) . '</h3>
									' . $__compilerTemp10 . '
								';
				}
				$__finalCompiled .= '
							';
			}
			$__finalCompiled .= '

							';
			if ($__vars['category']['title_s4']) {
				$__finalCompiled .= '
								';
				$__compilerTemp11 = '';
				$__compilerTemp11 .= '
										' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
					'type' => 'sc_items',
					'group' => 'section_4',
					'onlyInclude' => $__vars['category']['field_cache'],
					'set' => $__vars['item']['custom_fields'],
					'wrapperClass' => 'itemBody-fields itemBody-fields--before',
				), $__vars) . '

										';
				if ($__vars['category']['editor_s4'] AND ($__vars['item']['message_s4'] != '')) {
					$__compilerTemp11 .= '
											' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_above_s4_content',
					), $__vars) . '
' . $__templater->filter($__templater->func('bb_code', array($__vars['item']['message_s4'], 'sc_item', $__vars['item'], ), false), array(array('sam_keyword_ads', array('showcase_item', $__vars['xf']['samFilterAds'], $__vars['item'], $__vars['item']['User'] AND $__templater->method($__vars['item']['User'], 'isMemberOf', array($__vars['xf']['options']['siropuAdsManagerUserGroupPostExceptions'], )), )),), true) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_below_s4_content',
					), $__vars) . '
										';
				}
				$__compilerTemp11 .= '
									';
				if (strlen(trim($__compilerTemp11)) > 0) {
					$__finalCompiled .= '
									<h3>' . $__templater->escape($__vars['category']['title_s4']) . '</h3>
									' . $__compilerTemp11 . '
								';
				}
				$__finalCompiled .= '
							';
			}
			$__finalCompiled .= '

							';
			if ($__vars['category']['title_s5']) {
				$__finalCompiled .= '
								';
				$__compilerTemp12 = '';
				$__compilerTemp12 .= '
										' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
					'type' => 'sc_items',
					'group' => 'section_5',
					'onlyInclude' => $__vars['category']['field_cache'],
					'set' => $__vars['item']['custom_fields'],
					'wrapperClass' => 'itemBody-fields itemBody-fields--before',
				), $__vars) . '

										';
				if ($__vars['category']['editor_s5'] AND ($__vars['item']['message_s5'] != '')) {
					$__compilerTemp12 .= '
											' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_above_s5_content',
					), $__vars) . '
' . $__templater->filter($__templater->func('bb_code', array($__vars['item']['message_s5'], 'sc_item', $__vars['item'], ), false), array(array('sam_keyword_ads', array('showcase_item', $__vars['xf']['samFilterAds'], $__vars['item'], $__vars['item']['User'] AND $__templater->method($__vars['item']['User'], 'isMemberOf', array($__vars['xf']['options']['siropuAdsManagerUserGroupPostExceptions'], )), )),), true) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_below_s5_content',
					), $__vars) . '
										';
				}
				$__compilerTemp12 .= '
									';
				if (strlen(trim($__compilerTemp12)) > 0) {
					$__finalCompiled .= '
									<h3>' . $__templater->escape($__vars['category']['title_s5']) . '</h3>
									' . $__compilerTemp12 . '
								';
				}
				$__finalCompiled .= '
							';
			}
			$__finalCompiled .= '

							';
			if ($__vars['category']['title_s6']) {
				$__finalCompiled .= '
								';
				$__compilerTemp13 = '';
				$__compilerTemp13 .= '
										' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
					'type' => 'sc_items',
					'group' => 'section_6',
					'onlyInclude' => $__vars['category']['field_cache'],
					'set' => $__vars['item']['custom_fields'],
					'wrapperClass' => 'itemBody-fields itemBody-fields--before',
				), $__vars) . '

										';
				if ($__vars['category']['editor_s6'] AND ($__vars['item']['message_s6'] != '')) {
					$__compilerTemp13 .= '
											' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_above_s6_content',
					), $__vars) . '
' . $__templater->filter($__templater->func('bb_code', array($__vars['item']['message_s6'], 'sc_item', $__vars['item'], ), false), array(array('sam_keyword_ads', array('showcase_item', $__vars['xf']['samFilterAds'], $__vars['item'], $__vars['item']['User'] AND $__templater->method($__vars['item']['User'], 'isMemberOf', array($__vars['xf']['options']['siropuAdsManagerUserGroupPostExceptions'], )), )),), true) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
						'position' => 'sc_item_below_s6_content',
					), $__vars) . '
										';
				}
				$__compilerTemp13 .= '
									';
				if (strlen(trim($__compilerTemp13)) > 0) {
					$__finalCompiled .= '
									<h3>' . $__templater->escape($__vars['category']['title_s6']) . '</h3>
									' . $__compilerTemp13 . '
								';
				}
				$__finalCompiled .= '
							';
			}
			$__finalCompiled .= '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					' . $__templater->callAdsMacro('sc_item_view_below_item_sections_content', array(
		'item' => $__vars['item'],
	), $__vars) . '

					';
	if (($__vars['xf']['options']['xaScGalleryLocation'] == 'below_item') AND $__vars['item']['attach_count']) {
		$__finalCompiled .= '
						';
		$__compilerTemp14 = '';
		$__compilerTemp14 .= '
									';
		if ($__templater->isTraversable($__vars['item']['Attachments'])) {
			foreach ($__vars['item']['Attachments'] AS $__vars['attachment']) {
				if ($__vars['attachment']['has_thumbnail'] AND (!$__templater->method($__vars['item'], 'isAttachmentEmbedded', array($__vars['attachment'], )))) {
					$__compilerTemp14 .= '
										' . $__templater->callMacro('attachment_macros', 'attachment_list_item', array(
						'attachment' => $__vars['attachment'],
						'canView' => $__templater->method($__vars['item'], 'canViewItemAttachments', array()),
					), $__vars) . '
									';
				}
			}
		}
		$__compilerTemp14 .= '
								';
		if (strlen(trim($__compilerTemp14)) > 0) {
			$__finalCompiled .= '
							';
			$__templater->includeCss('attachments.less');
			$__finalCompiled .= '
							<ul class="attachmentList itemBody-attachments">
								' . $__compilerTemp14 . '
							</ul>
						';
		}
		$__finalCompiled .= '
					';
	} else if ($__vars['item']['attach_count'] AND (($__vars['xf']['options']['xaScGalleryLocation'] == 'own_tab') OR ($__vars['xf']['options']['xaScGalleryLocation'] == 'no_gallery'))) {
		$__finalCompiled .= '
						';
		$__compilerTemp15 = '';
		$__compilerTemp15 .= '
									';
		if ($__templater->isTraversable($__vars['item']['Attachments'])) {
			foreach ($__vars['item']['Attachments'] AS $__vars['attachment']) {
				if ($__vars['attachment']['has_thumbnail'] AND (!$__templater->method($__vars['item'], 'isAttachmentEmbedded', array($__vars['attachment'], )))) {
					$__compilerTemp15 .= '
										' . $__templater->callMacro('attachment_macros', 'attachment_list_item', array(
						'attachment' => $__vars['attachment'],
						'canView' => $__templater->method($__vars['item'], 'canViewItemAttachments', array()),
					), $__vars) . '
									';
				}
			}
		}
		$__compilerTemp15 .= '
								';
		if (strlen(trim($__compilerTemp15)) > 0) {
			$__finalCompiled .= '
							';
			$__templater->includeCss('attachments.less');
			$__finalCompiled .= '
							<ul class="attachmentList itemBody-attachments" style="display:none;">
								' . $__compilerTemp15 . '
							</ul>
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					';
	if (($__vars['xf']['options']['xaScFilesLocation'] == 'below_item') AND $__vars['item']['attach_count']) {
		$__finalCompiled .= '
						';
		$__compilerTemp16 = '';
		$__compilerTemp16 .= '
									';
		if ($__templater->isTraversable($__vars['item']['Attachments'])) {
			foreach ($__vars['item']['Attachments'] AS $__vars['attachment']) {
				$__compilerTemp16 .= '
										';
				if ($__vars['attachment']['has_thumbnail'] OR $__vars['attachment']['is_video']) {
					$__compilerTemp16 .= '
											' . '
										';
				} else {
					$__compilerTemp16 .= '
											' . $__templater->callMacro('attachment_macros', 'attachment_list_item', array(
						'attachment' => $__vars['attachment'],
						'canView' => $__templater->method($__vars['item'], 'canViewItemAttachments', array()),
					), $__vars) . '
										';
				}
				$__compilerTemp16 .= '
									';
			}
		}
		$__compilerTemp16 .= '
								';
		if (strlen(trim($__compilerTemp16)) > 0) {
			$__finalCompiled .= '
							';
			$__templater->includeCss('attachments.less');
			$__finalCompiled .= '
							<h3>' . 'Downloads' . '</h3>
							<ul class="attachmentList itemBody-attachments">
								' . $__compilerTemp16 . '
							</ul>
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					';
	$__compilerTemp17 = '';
	$__compilerTemp17 .= '
								';
	$__compilerTemp18 = '';
	$__compilerTemp18 .= '
										' . $__templater->func('react', array(array(
		'content' => $__vars['item'],
		'link' => 'showcase/react',
		'list' => '< .js-itemBody | .js-reactionsList',
	))) . '
									';
	if (strlen(trim($__compilerTemp18)) > 0) {
		$__compilerTemp17 .= '
									<div class="actionBar-set actionBar-set--external">
									' . $__compilerTemp18 . '
									</div>
								';
	}
	$__compilerTemp17 .= '

								';
	$__compilerTemp19 = '';
	$__compilerTemp19 .= '
										';
	if ($__templater->method($__vars['item'], 'canReport', array())) {
		$__compilerTemp19 .= '
											<a href="' . $__templater->func('link', array('showcase/report', $__vars['item'], ), true) . '"
												class="actionBar-action actionBar-action--report" 
												data-xf-click="overlay">' . 'Report' . '</a>
										';
	}
	$__compilerTemp19 .= '

										';
	$__vars['hasActionBarMenu'] = false;
	$__compilerTemp19 .= '
										';
	if ($__templater->method($__vars['item'], 'canEdit', array())) {
		$__compilerTemp19 .= '
											<a href="' . $__templater->func('link', array('showcase/edit', $__vars['item'], ), true) . '"
												class="actionBar-action actionBar-action--edit actionBar-action--menuItem">' . 'Edit' . '</a>
											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp19 .= '
										';
	}
	$__compilerTemp19 .= '
										';
	if ($__vars['item']['edit_count'] AND $__templater->method($__vars['item'], 'canViewHistory', array())) {
		$__compilerTemp19 .= '
											<a href="' . $__templater->func('link', array('showcase/history', $__vars['item'], ), true) . '" 
												class="actionBar-action actionBar-action--history actionBar-action--menuItem"
												data-xf-click="toggle"
												data-target="#js-itemBody-' . $__templater->escape($__vars['item']['item_id']) . ' .js-historyTarget"
												data-menu-closer="true">' . 'History' . '</a>
											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp19 .= '
										';
	}
	$__compilerTemp19 .= '
										';
	if ($__templater->method($__vars['item'], 'canDelete', array('soft', ))) {
		$__compilerTemp19 .= '
											<a href="' . $__templater->func('link', array('showcase/delete', $__vars['item'], ), true) . '"
												class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
												data-xf-click="overlay">' . 'Delete' . '</a>
											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp19 .= '
										';
	}
	$__compilerTemp19 .= '
										';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewIps', array()) AND $__vars['item']['ip_id']) {
		$__compilerTemp19 .= '
											<a href="' . $__templater->func('link', array('showcase/ip', $__vars['item'], ), true) . '"
												class="actionBar-action actionBar-action--ip actionBar-action--menuItem"
												data-xf-click="overlay">' . 'IP' . '</a>
											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp19 .= '
										';
	}
	$__compilerTemp19 .= '
										';
	if ($__templater->method($__vars['item'], 'canWarn', array())) {
		$__compilerTemp19 .= '
											<a href="' . $__templater->func('link', array('showcase/warn', $__vars['item'], ), true) . '"
												class="actionBar-action actionBar-action--warn actionBar-action--menuItem">' . 'Warn' . '</a>
											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp19 .= '
										';
	} else if ($__vars['item']['warning_id'] AND $__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array())) {
		$__compilerTemp19 .= '
											<a href="' . $__templater->func('link', array('warnings', array('warning_id' => $__vars['item']['warning_id'], ), ), true) . '"
												class="actionBar-action actionBar-action--warn actionBar-action--menuItem"
												data-xf-click="overlay">' . 'View warning' . '</a>
											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp19 .= '
										';
	}
	$__compilerTemp19 .= '

										';
	if ($__vars['hasActionBarMenu']) {
		$__compilerTemp19 .= '
											<a class="actionBar-action actionBar-action--menuTrigger"
												data-xf-click="menu"
												title="' . 'More options' . '"
												role="button"
												tabindex="0"
												aria-expanded="false"
												aria-haspopup="true">&#8226;&#8226;&#8226;</a>

											<div class="menu" data-menu="menu" aria-hidden="true" data-menu-builder="actionBar">
												<div class="menu-content">
													<h4 class="menu-header">' . 'More options' . '</h4>
													<div class="js-menuBuilderTarget"></div>
												</div>
											</div>
										';
	}
	$__compilerTemp19 .= '
									';
	if (strlen(trim($__compilerTemp19)) > 0) {
		$__compilerTemp17 .= '
									<div class="actionBar-set actionBar-set--internal">
									' . $__compilerTemp19 . '
									</div>
								';
	}
	$__compilerTemp17 .= '
							';
	if (strlen(trim($__compilerTemp17)) > 0) {
		$__finalCompiled .= '
						<div class="actionBar">
							' . $__compilerTemp17 . '
						</div>
					';
	}
	$__finalCompiled .= '

					<div class="reactionsBar js-reactionsList ' . ($__vars['item']['reactions'] ? 'is-active' : '') . '">
						' . $__templater->func('reactions', array($__vars['item'], 'showcase/reactions', array())) . '
					</div>

					<div class="js-historyTarget toggleTarget" data-href="trigger-href"></div>
				</article>
			</div>
		</div>
	</div>
</div>

';
	if ($__vars['item']['location'] AND ($__templater->method($__vars['item'], 'canViewItemMap', array()) AND ($__vars['category']['allow_location'] AND (($__vars['xf']['options']['xaScLocationDisplayType'] == 'map_below_content') AND $__vars['xf']['options']['xaScGoogleMapsEmbedApiKey'])))) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h3 class="block-header">' . 'Location' . '</h3>
			<div class="block-body block-row contentRow-lesser">
				<p class="mapLocationName"><a href="' . $__templater->func('link', array('misc/location-info', '', array('location' => $__vars['item']['location'], ), ), true) . '" rel="nofollow" target="_blank" class="">' . $__templater->escape($__vars['item']['location']) . '</a></p>
			</div>	
			<div class="block-body block-row">
				<div class="mapContainer">
					<iframe
						width="100%" height="200" frameborder="0" style="border: 0"
						src="https://www.google.com/maps/embed/v1/place?key=' . $__templater->escape($__vars['xf']['options']['xaScGoogleMapsEmbedApiKey']) . '&q=' . $__templater->filter($__vars['item']['location'], array(array('censor', array()),), true) . ($__vars['xf']['options']['xaScLocalizeGoogleMaps'] ? ('&language=' . $__templater->filter($__vars['xf']['language']['language_code'], array(array('substr', array()),), true)) : '') . '">
					</iframe>
				</div>
			</div>	
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp20 = '';
	$__compilerTemp20 .= '
				' . $__templater->callMacro('share_page_macros', 'buttons', array(
		'iconic' => true,
		'label' => 'Share' . ':',
	), $__vars) . '

				' . '
			';
	if (strlen(trim($__compilerTemp20)) > 0) {
		$__finalCompiled .= '
	<div class="block">
		<div class="blockMessage blockMessage--none">
			' . $__compilerTemp20 . '
		</div>
	</div>	
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['item'], 'canViewUpdates', array()) AND !$__templater->test($__vars['latestUpdates'], 'empty', array())) {
		$__finalCompiled .= '
	';
		if ($__vars['canInlineModUpdates']) {
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => 'xf/inline_mod.js',
				'min' => '1',
			));
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '

	<div class="block block--messages"
		data-xf-init="' . ($__vars['canInlineModUpdates'] ? 'inline-mod' : '') . '"
		data-type="sc_update"
		data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">

		';
		$__compilerTemp21 = '';
		$__compilerTemp21 .= '
							';
		if ($__vars['canInlineModUpdates']) {
			$__compilerTemp21 .= '
								' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
							';
		}
		$__compilerTemp21 .= '
						';
		if (strlen(trim($__compilerTemp21)) > 0) {
			$__finalCompiled .= '
			<div class="block-outer">
				<div class="block-outer-opposite">
					<div class="buttonGroup">
						' . $__compilerTemp21 . '
					</div>
				</div>
			</div>
		';
		}
		$__finalCompiled .= '

		<div class="block-container"
			data-xf-init="lightbox"
			data-lb-id="item-' . $__templater->escape($__vars['item']['item_id']) . '"
			data-lb-universal="' . $__templater->escape($__vars['xf']['options']['lightBoxUniversal']) . '">

			<h3 class="block-header"><a href="' . $__templater->func('link', array('showcase/updates', $__vars['item'], ), true) . '">' . 'Latest updates' . '</a></h3>
			<div class="block-body">
			';
		if ($__templater->isTraversable($__vars['latestUpdates'])) {
			foreach ($__vars['latestUpdates'] AS $__vars['update']) {
				$__finalCompiled .= '
				' . $__templater->callMacro('xa_sc_update_macros', 'update', array(
					'update' => $__vars['update'],
					'item' => $__vars['item'],
					'showAttachments' => true,
				), $__vars) . '
			';
			}
		}
		$__finalCompiled .= '
			</div>
			<div class="block-footer">
				<span class="block-footer-controls">' . $__templater->button('Read more' . $__vars['xf']['language']['ellipsis'], array(
			'class' => 'button--link',
			'href' => $__templater->func('link', array('showcase/updates', $__vars['item'], ), false),
		), '', array(
		)) . '</span>
			</div>
		</div>
		
		<div class="block-outer block-outer--after">
			' . $__templater->func('show_ignored', array(array(
			'wrapperclass' => 'block-outer-opposite',
		))) . '
		</div>		
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['item'], 'canViewReviews', array()) AND !$__templater->test($__vars['latestReviews'], 'empty', array())) {
		$__finalCompiled .= '
	';
		if ($__vars['canInlineModReviews']) {
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => 'xf/inline_mod.js',
				'min' => '1',
			));
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '

	<div class="block block--messages"
		data-xf-init="' . ($__vars['canInlineModReviews'] ? 'inline-mod' : '') . '"
		data-type="sc_rating"
		data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">

		';
		$__compilerTemp22 = '';
		$__compilerTemp22 .= '
							';
		if ($__vars['canInlineModReviews']) {
			$__compilerTemp22 .= '
								' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
							';
		}
		$__compilerTemp22 .= '
						';
		if (strlen(trim($__compilerTemp22)) > 0) {
			$__finalCompiled .= '
			<div class="block-outer">
				<div class="block-outer-opposite">
					<div class="buttonGroup">
						' . $__compilerTemp22 . '
					</div>
				</div>
			</div>
		';
		}
		$__finalCompiled .= '

		<div class="block-container"
			data-xf-init="lightbox"
			data-lb-id="item-' . $__templater->escape($__vars['item']['item_id']) . '"
			data-lb-universal="' . $__templater->escape($__vars['xf']['options']['lightBoxUniversal']) . '">

			<h3 class="block-header">' . 'Latest reviews' . '</h3>
			<div class="block-body">
			';
		if ($__templater->isTraversable($__vars['latestReviews'])) {
			foreach ($__vars['latestReviews'] AS $__vars['review']) {
				$__finalCompiled .= '
				' . $__templater->callMacro('xa_sc_review_macros', 'review', array(
					'review' => $__vars['review'],
					'item' => $__vars['item'],
					'showAttachments' => true,
				), $__vars) . '
			';
			}
		}
		$__finalCompiled .= '
			</div>
			<div class="block-footer">
				<span class="block-footer-controls">' . $__templater->button('Read more' . $__vars['xf']['language']['ellipsis'], array(
			'class' => 'button--link',
			'href' => $__templater->func('link', array('showcase/reviews', $__vars['item'], ), false),
		), '', array(
		)) . '</span>
			</div>
		</div>
		
		<div class="block-outer block-outer--after">
			' . $__templater->func('show_ignored', array(array(
			'wrapperclass' => 'block-outer-opposite',
		))) . '
		</div>		
	</div>
';
	}
	$__finalCompiled .= '

';
	if (($__vars['xf']['options']['xaScMoreInCategoryLocation'] == 'below_item') AND !$__templater->test($__vars['categoryOthers'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h3 class="block-header"><a href="' . $__templater->func('link', array('showcase/categories', $__vars['item']['Category'], ), true) . '">' . 'More in ' . $__templater->escape($__vars['item']['Category']['title']) . '' . '</a></h3>
			<div class="block-body">
				';
		if (($__vars['xf']['options']['xaScMoreInCategoryLayoutType'] == 'item_view') AND $__templater->method($__vars['item'], 'canViewItemAttachments', array())) {
			$__finalCompiled .= '
					';
			if ($__templater->isTraversable($__vars['categoryOthers'])) {
				foreach ($__vars['categoryOthers'] AS $__vars['categoryOther']) {
					$__finalCompiled .= '
						' . $__templater->callMacro('xa_sc_item_list_macros', 'item_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['categoryOther'],
					), $__vars) . '
					';
				}
			}
			$__finalCompiled .= '
				';
		} else if (($__vars['xf']['options']['xaScMoreInCategoryLayoutType'] == 'grid_view') AND $__templater->method($__vars['item'], 'canViewItemAttachments', array())) {
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc.less');
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc_grid_view_layout.less');
			$__finalCompiled .= '

					<div class="gridContainerScGridView">		
						<ul class="sc-grid-view">
							';
			if ($__templater->isTraversable($__vars['categoryOthers'])) {
				foreach ($__vars['categoryOthers'] AS $__vars['categoryOther']) {
					$__finalCompiled .= '
								' . $__templater->callMacro('xa_sc_item_list_macros', 'grid_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['categoryOther'],
					), $__vars) . '
							';
				}
			}
			$__finalCompiled .= '
						</ul>
					</div>
				';
		} else if (($__vars['xf']['options']['xaScMoreInCategoryLayoutType'] == 'tile_view') AND $__templater->method($__vars['item'], 'canViewItemAttachments', array())) {
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc.less');
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc_tile_view_layout.less');
			$__finalCompiled .= '

					<div class="gridContainerScTileView">		
						<ul class="sc-tile-view">
							';
			if ($__templater->isTraversable($__vars['categoryOthers'])) {
				foreach ($__vars['categoryOthers'] AS $__vars['categoryOther']) {
					$__finalCompiled .= '
								' . $__templater->callMacro('xa_sc_item_list_macros', 'tile_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['categoryOther'],
					), $__vars) . '
							';
				}
			}
			$__finalCompiled .= '
						</ul>
					</div>							
				';
		} else {
			$__finalCompiled .= '
					<div class="structItemContainer structItemContainerScListView">
						';
			if ($__templater->isTraversable($__vars['categoryOthers'])) {
				foreach ($__vars['categoryOthers'] AS $__vars['categoryOther']) {
					$__finalCompiled .= '
							' . $__templater->callMacro('xa_sc_item_list_macros', 'list_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['categoryOther'],
					), $__vars) . '
						';
				}
			}
			$__finalCompiled .= '
					</div>
				';
		}
		$__finalCompiled .= '
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	if (($__vars['xf']['options']['xaScMoreFromAuthorLocation'] == 'below_item') AND !$__templater->test($__vars['authorOthers'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h3 class="block-header"><a href="' . $__templater->func('link', array('showcase/authors', $__vars['item']['User'], ), true) . '">' . 'More from ' . $__templater->escape($__vars['item']['User']['username']) . '' . '</a></h3>
			<div class="block-body">
				';
		if (($__vars['xf']['options']['xaScMoreFromAuthorLayoutType'] == 'item_view') AND $__templater->method($__vars['item'], 'canViewItemAttachments', array())) {
			$__finalCompiled .= '
					';
			if ($__templater->isTraversable($__vars['authorOthers'])) {
				foreach ($__vars['authorOthers'] AS $__vars['authorOther']) {
					$__finalCompiled .= '
						' . $__templater->callMacro('xa_sc_item_list_macros', 'item_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['authorOther'],
					), $__vars) . '
					';
				}
			}
			$__finalCompiled .= '
				';
		} else if (($__vars['xf']['options']['xaScMoreFromAuthorLayoutType'] == 'grid_view') AND $__templater->method($__vars['item'], 'canViewItemAttachments', array())) {
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc.less');
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc_grid_view_layout.less');
			$__finalCompiled .= '

					<div class="gridContainerScGridView">		
						<ul class="sc-grid-view">
							';
			if ($__templater->isTraversable($__vars['authorOthers'])) {
				foreach ($__vars['authorOthers'] AS $__vars['authorOther']) {
					$__finalCompiled .= '
								' . $__templater->callMacro('xa_sc_item_list_macros', 'grid_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['authorOther'],
					), $__vars) . '
							';
				}
			}
			$__finalCompiled .= '
						</ul>
					</div>
				';
		} else if (($__vars['xf']['options']['xaScMoreFromAuthorLayoutType'] == 'tile_view') AND $__templater->method($__vars['item'], 'canViewItemAttachments', array())) {
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc.less');
			$__finalCompiled .= '
					';
			$__templater->includeCss('xa_sc_tile_view_layout.less');
			$__finalCompiled .= '

					<div class="gridContainerScTileView">		
						<ul class="sc-tile-view">
							';
			if ($__templater->isTraversable($__vars['authorOthers'])) {
				foreach ($__vars['authorOthers'] AS $__vars['authorOther']) {
					$__finalCompiled .= '
								' . $__templater->callMacro('xa_sc_item_list_macros', 'tile_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['authorOther'],
					), $__vars) . '
							';
				}
			}
			$__finalCompiled .= '
						</ul>
					</div>							
				';
		} else {
			$__finalCompiled .= '
					<div class="structItemContainer structItemContainerScListView">
						';
			if ($__templater->isTraversable($__vars['authorOthers'])) {
				foreach ($__vars['authorOthers'] AS $__vars['authorOther']) {
					$__finalCompiled .= '
							' . $__templater->callMacro('xa_sc_item_list_macros', 'list_view_layout', array(
						'allowInlineMod' => false,
						'item' => $__vars['authorOther'],
					), $__vars) . '
						';
				}
			}
			$__finalCompiled .= '
					</div>
				';
		}
		$__finalCompiled .= '		
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['item'], 'canViewComments', array())) {
		$__finalCompiled .= '
	<div class="columnContainer"
		data-xf-init="lightbox"
		data-lb-id="item-' . $__templater->escape($__vars['item']['item_id']) . '"
		data-lb-universal="' . $__templater->escape($__vars['xf']['options']['lightBoxUniversal']) . '">

		<span class="u-anchorTarget" id="comments"></span>
		
		<div class="columnContainer-comments">
			' . $__templater->callMacro('xa_sc_comment_macros', 'comment_list', array(
			'comments' => $__vars['comments'],
			'attachmentData' => $__vars['attachmentData'],
			'content' => $__vars['item'],
			'linkPrefix' => 'showcase/item-comments',
			'link' => 'showcase',
			'page' => $__vars['page'],
			'perPage' => $__vars['perPage'],
			'totalItems' => $__vars['totalItems'],
			'pageNavHash' => $__vars['pageNavHash'],
			'canInlineMod' => $__vars['canInlineModComments'],
		), $__vars) . '
		</div>
	</div>	
';
	}
	$__finalCompiled .= '

';
	if ($__vars['item']['cover_image_id'] AND $__vars['xf']['options']['xaScDisplayCoverImageSidebar']) {
		$__finalCompiled .= '
	';
		$__compilerTemp23 = '';
		if ($__templater->method($__vars['item'], 'canViewItemAttachments', array())) {
			$__compilerTemp23 .= '
					<div class="block-body block-row block-row--minor lbContainer js-itemCIBody"
						data-xf-init="lightbox"
						data-lb-id="item-' . $__templater->escape($__vars['item']['item_id']) . '"
						data-lb-caption-desc="' . ($__vars['item']['User'] ? $__templater->escape($__vars['item']['User']['username']) : $__templater->escape($__vars['item']['username'])) . ' &middot; ' . $__templater->func('date_time', array($__vars['item']['create_date'], ), true) . '">
				
						' . $__templater->callMacro('lightbox_macros', 'setup', array(
				'canViewAttachments' => 'true',
			), $__vars) . '
						<div class="itemCIBody">
							<div class="js-lbContainer">
								<div class="item-container-image js-itemContainerImage">
									<a href="' . $__templater->func('link', array('attachments', $__vars['item']['CoverImage'], ), true) . '" target="_blank" class="js-lbImage">
										<img src="' . $__templater->func('link', array('showcase/cover-image', $__vars['item'], ), true) . '" class="js-itemImage" />
									</a>
								</div>

								';
			if ($__vars['item']['attach_count'] > 1) {
				$__compilerTemp23 .= '
									';
				$__compilerTemp24 = '';
				$__compilerTemp24 .= '
												';
				if ($__templater->isTraversable($__vars['item']['Attachments'])) {
					foreach ($__vars['item']['Attachments'] AS $__vars['attachment']) {
						if ($__vars['attachment']['has_thumbnail']) {
							$__compilerTemp24 .= '
													';
							if ($__vars['attachment']['attachment_id'] == $__vars['item']['cover_image_id']) {
								$__compilerTemp24 .= '
													';
							} else {
								$__compilerTemp24 .= '
														' . $__templater->callMacro('attachment_macros', 'attachment_list_item', array(
									'attachment' => $__vars['attachment'],
									'canView' => $__templater->method($__vars['item'], 'canViewItemAttachments', array()),
								), $__vars) . '
													';
							}
							$__compilerTemp24 .= '
												';
						}
					}
				}
				$__compilerTemp24 .= '
											';
				if (strlen(trim($__compilerTemp24)) > 0) {
					$__compilerTemp23 .= '
										';
					$__templater->includeCss('attachments.less');
					$__compilerTemp23 .= '
										<ul class="attachmentList itemBody-attachments" style="display:none;">
											' . $__compilerTemp24 . '
										</ul>
									';
				}
				$__compilerTemp23 .= '
								';
			}
			$__compilerTemp23 .= '
							</div>
						</div>
					</div>
				';
		} else {
			$__compilerTemp23 .= '
					<div class="block-body block-row block-row--minor">
						<div style="text-align: center;">
							' . $__templater->func('sc_item_thumbnail', array($__vars['item'], ), true) . '
						</div>
					</div>
				';
		}
		$__templater->modifySidebarHtml('coverImageSidebar', '
		<div class="block">
			<div class="block-container">
				' . $__compilerTemp23 . '		
			</div>
		</div>
	', 'replace');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp25 = '';
	if ($__vars['item']['view_count']) {
		$__compilerTemp25 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Views' . '</dt>
						<dd>' . $__templater->filter($__vars['item']['view_count'], array(array('number', array()),), true) . '</dd>
					</dl>
				';
	}
	$__compilerTemp26 = '';
	if ($__vars['item']['watch_count']) {
		$__compilerTemp26 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Watchers' . '</dt>
						<dd>' . $__templater->filter($__vars['item']['watch_count'], array(array('number', array()),), true) . '</dd>
					</dl>
				';
	}
	$__compilerTemp27 = '';
	if ($__vars['item']['comment_count']) {
		$__compilerTemp27 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Comments' . '</dt>
						<dd>' . $__templater->filter($__vars['item']['comment_count'], array(array('number', array()),), true) . '</dd>
					</dl>
				';
	}
	$__compilerTemp28 = '';
	if ($__vars['item']['review_count']) {
		$__compilerTemp28 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Reviews' . '</dt>
						<dd>' . $__templater->filter($__vars['item']['review_count'], array(array('number', array()),), true) . '</dd>
					</dl>
				';
	}
	$__compilerTemp29 = '';
	if ($__vars['item']['update_count']) {
		$__compilerTemp29 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Updates' . '</dt>
						<dd>' . $__templater->filter($__vars['item']['update_count'], array(array('number', array()),), true) . '</dd>
					</dl>
				';
	}
	$__compilerTemp30 = '';
	if ($__vars['item']['last_update']) {
		$__compilerTemp30 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Last update' . '</dt>
						<dd>' . $__templater->func('date_dynamic', array($__vars['item']['last_update'], array(
		))) . '</dd>
					</dl>
				';
	}
	$__compilerTemp31 = '';
	if ($__vars['item']['author_rating'] AND $__vars['category']['allow_author_rating']) {
		$__compilerTemp31 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Author rating' . '</dt>
						<dd>
							' . $__templater->callMacro('rating_macros', 'stars', array(
			'rating' => $__vars['item']['author_rating'],
			'class' => 'ratingStars--scAuthorRating',
		), $__vars) . '
						</dd>
					</dl>
				';
	}
	$__compilerTemp32 = '';
	if ($__vars['item']['rating_count'] AND $__vars['item']['rating_avg']) {
		$__compilerTemp32 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Rating' . '</dt>
						<dd>
							' . $__templater->callMacro('rating_macros', 'stars_text', array(
			'rating' => $__vars['item']['rating_avg'],
			'count' => $__vars['item']['rating_count'],
			'rowClass' => 'ratingStarsRow--textBlock',
		), $__vars) . '
						</dd>
					</dl>
				';
	}
	$__compilerTemp33 = '';
	if ($__vars['item']['location'] AND ($__vars['category']['allow_location'] AND (($__vars['xf']['options']['xaScLocationDisplayType'] == 'link') OR (!$__templater->method($__vars['item'], 'canViewItemMap', array()))))) {
		$__compilerTemp33 .= '
					<dl class="pairs pairs--justified">
						<dt>' . 'Location' . '</dt>
						<dd>
							<a href="' . $__templater->func('link', array('misc/location-info', '', array('location' => $__vars['item']['location'], ), ), true) . '" rel="nofollow" target="_blank" class="">' . $__templater->escape($__vars['item']['location']) . '</a>
						</dd>
					</dl>
				';
	}
	$__templater->modifySidebarHtml('infoSidebar', '
	<div class="block">
		<div class="block-container">
			<h3 class="block-minorHeader">' . ($__vars['item']['Category']['content_term'] ? '' . $__templater->escape($__vars['item']['Category']['content_term']) . ' information' : 'Spa information') . '</h3>
			<div class="block-body block-row block-row--minor">
				<dl class="pairs pairs--justified">
					<dt>' . 'Added by' . '</dt>
					<dd>' . $__templater->func('username_link', array($__vars['item']['User'], false, array(
		'defaultname' => $__vars['item']['username'],
	))) . '</dd>
				</dl>
				' . $__compilerTemp25 . '
				' . $__compilerTemp26 . '				
				' . $__compilerTemp27 . '
				' . $__compilerTemp28 . '
				' . $__compilerTemp29 . '
				' . $__compilerTemp30 . '
				' . $__compilerTemp31 . '
				' . $__compilerTemp32 . '

				' . $__compilerTemp33 . '
			</div>
		</div>
	</div>
', 'replace');
	$__finalCompiled .= '

';
	if ($__vars['item']['business_hours']) {
		$__finalCompiled .= '
	';
		$__templater->modifySidebarHtml('businessHours', '
		' . $__templater->callMacro('xa_sc_item_view_macros', 'business_hours', array(
			'item' => $__vars['item'],
			'category' => $__vars['category'],
		), $__vars) . '
	', 'replace');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['item'], 'canViewContributors', array()) AND !$__templater->test($__vars['contributors'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp34 = '';
		$__compilerTemp35 = '';
		$__compilerTemp35 .= '
							';
		if ($__templater->isTraversable($__vars['contributors'])) {
			foreach ($__vars['contributors'] AS $__vars['contributor']) {
				if (!$__vars['contributor']['is_co_owner']) {
					$__compilerTemp35 .= '
								<li>
									<div class="contentRow">
										<div class="contentRow-figure">
											' . $__templater->func('avatar', array($__vars['contributor']['User'], 'xxs', false, array(
					))) . '
										</div>

										<div class="contentRow-main contentRow-main--close">
											' . $__templater->func('username_link', array($__vars['contributor']['User'], true, array(
					))) . '
											<div class="contentRow-minor">
												' . $__templater->func('user_title', array($__vars['contributor']['User'], false, array(
					))) . '
											</div>
										</div>
									</div>
								</li>
							';
				}
			}
		}
		$__compilerTemp35 .= '
						';
		if (strlen(trim($__compilerTemp35)) > 0) {
			$__compilerTemp34 .= '
			<div class="block">
				<div class="block-container">
					<h3 class="block-minorHeader">
						';
			if ($__templater->method($__vars['item'], 'canManageContributors', array())) {
				$__compilerTemp34 .= '
							<a href="' . $__templater->func('link', array('showcase/manage-contributors', $__vars['item'], ), true) . '" data-xf-click="overlay">
								' . 'Contributors' . '
							</a>
						';
			} else {
				$__compilerTemp34 .= '
							' . 'Contributors' . '
						';
			}
			$__compilerTemp34 .= '
					</h3>
					<div class="block-body block-row block-row--minor">
						<ul class="itemSidebarList">
						' . $__compilerTemp35 . '
						</ul>
					</div>	
				</div>
			</div>
		';
		}
		$__templater->modifySidebarHtml('itemContributors', '	
		' . $__compilerTemp34 . '
	', 'replace');
		$__finalCompiled .= '	
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['item'], 'canViewFullItem', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp36 = '';
		$__compilerTemp37 = '';
		$__compilerTemp37 .= '
							' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'sidebar',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => '',
			'valueClass' => 'pairs pairs--justified',
		), $__vars) . '
						';
		if (strlen(trim($__compilerTemp37)) > 0) {
			$__compilerTemp36 .= '
			<div class="block">
				<div class="block-container">
					<h3 class="block-minorHeader">' . 'Additional information' . '</h3>
					<div class="block-body block-row block-row--minor">
						' . $__compilerTemp37 . '
					</div>	
				</div>
			</div>
		';
		}
		$__templater->modifySidebarHtml('additionalInfoSidebar', '
		' . $__compilerTemp36 . '
	', 'replace');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['item'], 'canViewFullItem', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp38 = $__templater->method($__vars['item'], 'getExtraFieldSidebarBlocks', array());
		if ($__templater->isTraversable($__compilerTemp38)) {
			foreach ($__compilerTemp38 AS $__vars['fieldId'] => $__vars['fieldValue']) {
				$__finalCompiled .= '
		';
				$__templater->modifySidebarHtml('customFieldOwnBlockSidebar-' . $__templater->escape($__vars['fieldId']), '
			<div class="block">
				<div class="block-container">
					<h3 class="block-minorHeader">' . $__templater->escape($__vars['fieldValue']) . '</h3>
					<div class="block-body block-row block-row--minor">

					' . $__templater->callMacro('custom_fields_macros', 'custom_field_value', array(
					'definition' => $__templater->method($__vars['item']->{'custom_fields'}, 'getDefinition', array($__vars['fieldId'], )),
					'value' => $__templater->method($__vars['item']->{'custom_fields'}, 'getFieldValue', array($__vars['fieldId'], )),
				), $__vars) . '
					</div>	
				</div>
			</div>
		', 'replace');
				$__finalCompiled .= '
	';
			}
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp39 = '';
	$__compilerTemp40 = '';
	$__compilerTemp40 .= '
					';
	if ($__templater->method($__vars['item'], 'hasViewableDiscussion', array())) {
		$__compilerTemp40 .= '
						' . $__templater->button('Join discussion', array(
			'href' => $__templater->func('link', array('threads', $__vars['item']['Discussion'], ), false),
			'class' => 'button--fullWidth',
		), '', array(
		)) . '
					';
	}
	$__compilerTemp40 .= '
				';
	if (strlen(trim($__compilerTemp40)) > 0) {
		$__compilerTemp39 .= '
		<div class="block">
			<div class="block-container">
				' . $__compilerTemp40 . '
			</div>
		</div>
	';
	}
	$__templater->modifySidebarHtml('discussionButtonSidebar', '
	' . $__compilerTemp39 . '	
', 'replace');
	$__finalCompiled .= '

';
	if ($__vars['item']['location'] AND ($__templater->method($__vars['item'], 'canViewItemMap', array()) AND ($__vars['category']['allow_location'] AND (($__vars['xf']['options']['xaScLocationDisplayType'] == 'map') AND $__vars['xf']['options']['xaScGoogleMapsEmbedApiKey'])))) {
		$__finalCompiled .= '
	';
		$__templater->modifySidebarHtml('locationSidebar', '
		<div class="block">
			<div class="block-container">
				<h3 class="block-minorHeader">' . 'Location' . '</h3>
				<div class="block-body block-row contentRow-lesser">
					<p class="mapLocationName"><a href="' . $__templater->func('link', array('misc/location-info', '', array('location' => $__vars['item']['location'], ), ), true) . '" rel="nofollow" target="_blank" class="">' . $__templater->escape($__vars['item']['location']) . '</a></p>
				</div>	
				<div class="block-body block-row">
					<div class="mapContainer">
						<iframe
							width="100%" height="200" frameborder="0" style="border: 0"
							src="https://www.google.com/maps/embed/v1/place?key=' . $__templater->escape($__vars['xf']['options']['xaScGoogleMapsEmbedApiKey']) . '&q=' . $__templater->filter($__vars['item']['location'], array(array('censor', array()),), true) . ($__vars['xf']['options']['xaScLocalizeGoogleMaps'] ? ('&language=' . $__templater->filter($__vars['xf']['language']['language_code'], array(array('substr', array()),), true)) : '') . '">
						</iframe>
					</div>
				</div>	
			</div>
		</div>
	', 'replace');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if (($__vars['xf']['options']['xaScFilesLocation'] == 'sidebar') AND $__vars['item']['attach_count']) {
		$__finalCompiled .= '
	';
		$__compilerTemp41 = '';
		$__compilerTemp42 = '';
		$__compilerTemp42 .= '
								';
		if ($__templater->isTraversable($__vars['item']['Attachments'])) {
			foreach ($__vars['item']['Attachments'] AS $__vars['attachment']) {
				$__compilerTemp42 .= '
									';
				if ($__vars['attachment']['has_thumbnail'] OR $__vars['attachment']['is_video']) {
					$__compilerTemp42 .= '
										' . '
									';
				} else {
					$__compilerTemp42 .= '
										' . $__templater->callMacro('attachment_macros', 'attachment_list_item', array(
						'attachment' => $__vars['attachment'],
						'canView' => $__templater->method($__vars['item'], 'canViewItemAttachments', array()),
					), $__vars) . '
									';
				}
				$__compilerTemp42 .= '
								';
			}
		}
		$__compilerTemp42 .= '
							';
		if (strlen(trim($__compilerTemp42)) > 0) {
			$__compilerTemp41 .= '
			<div class="block">
				<div class="block-container">
					<h3 class="block-minorHeader">' . 'Downloads' . '</h3>
					';
			$__templater->includeCss('attachments.less');
			$__compilerTemp41 .= '
					<div class="block-body block-row">
						<ul class="attachmentList itemBody-attachments">
							' . $__compilerTemp42 . '
						</ul>
					</div>
				</div>
			</div>
		';
		}
		$__templater->modifySidebarHtml('fileAttachmentsSidebar', '
		' . $__compilerTemp41 . '
	', 'replace');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if (($__vars['xf']['options']['xaScMoreInCategoryLocation'] == 'sidebar') AND !$__templater->test($__vars['categoryOthers'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp43 = '';
		if ($__templater->isTraversable($__vars['categoryOthers'])) {
			foreach ($__vars['categoryOthers'] AS $__vars['categoryOther']) {
				$__compilerTemp43 .= '
						<li>
							' . $__templater->callMacro('xa_sc_item_list_macros', 'item_simple', array(
					'item' => $__vars['categoryOther'],
					'withMeta' => false,
				), $__vars) . '
						</li>
					';
			}
		}
		$__templater->modifySidebarHtml('moreItemsInCategorySidebar', '
		<div class="block">
			<div class="block-container">
				<h3 class="block-minorHeader"><a href="' . $__templater->func('link', array('showcase/categories', $__vars['item']['Category'], ), true) . '">' . 'More in ' . $__templater->escape($__vars['item']['Category']['title']) . '' . '</a></h3>
				<div class="block-body block-row">
					<ul class="itemSidebarList">
					' . $__compilerTemp43 . '
					</ul>
				</div>
			</div>
		</div>
	', 'replace');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if (($__vars['xf']['options']['xaScMoreFromAuthorLocation'] == 'sidebar') AND !$__templater->test($__vars['authorOthers'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp44 = '';
		if ($__templater->isTraversable($__vars['authorOthers'])) {
			foreach ($__vars['authorOthers'] AS $__vars['authorOther']) {
				$__compilerTemp44 .= '
						<li>
							' . $__templater->callMacro('xa_sc_item_list_macros', 'item_simple', array(
					'item' => $__vars['authorOther'],
					'withMeta' => false,
				), $__vars) . '
						</li>
					';
			}
		}
		$__templater->modifySidebarHtml('moreItemsFromAuthorSidebar', '
		<div class="block">
			<div class="block-container">
				<h3 class="block-minorHeader"><a href="' . $__templater->func('link', array('showcase/authors', $__vars['item']['User'], ), true) . '">' . 'More from ' . $__templater->escape($__vars['item']['User']['username']) . '' . '</a></h3>
				<div class="block-body block-row">
					<ul class="itemSidebarList">
					' . $__compilerTemp44 . '
					</ul>
				</div>
			</div>
		</div>
	', 'replace');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp45 = '';
	$__compilerTemp46 = '';
	$__compilerTemp46 .= '
					<h3 class="block-minorHeader">' . ($__vars['item']['Category']['content_term'] ? 'Share this ' . $__templater->escape($__vars['item']['Category']['content_term']) . '' : 'Share this item') . '</h3>
					';
	$__compilerTemp47 = '';
	$__compilerTemp47 .= '
								' . $__templater->callMacro('share_page_macros', 'buttons', array(
		'iconic' => true,
	), $__vars) . '
							';
	if (strlen(trim($__compilerTemp47)) > 0) {
		$__compilerTemp46 .= '
						<div class="block-body block-row block-row--separated">
							' . $__compilerTemp47 . '
						</div>
					';
	}
	$__compilerTemp46 .= '
					';
	$__compilerTemp48 = '';
	$__compilerTemp48 .= '
								' . $__templater->callMacro('share_page_macros', 'share_clipboard_input', array(
		'label' => 'Copy URL BB code',
		'text' => '[URL="' . $__templater->func('link', array('canonical:showcase', $__vars['item'], ), false) . '"]' . $__vars['item']['title'] . '[/URL]',
	), $__vars) . '

								' . $__templater->callMacro('share_page_macros', 'share_clipboard_input', array(
		'label' => 'Copy SHOWCASE BB code',
		'text' => '[SHOWCASE=item, ' . $__vars['item']['item_id'] . '][/SHOWCASE]',
	), $__vars) . '
							';
	if (strlen(trim($__compilerTemp48)) > 0) {
		$__compilerTemp46 .= '
						<div class="block-body block-row block-row--separated">
							' . $__compilerTemp48 . '
						</div>
					';
	}
	$__compilerTemp46 .= '
				';
	if (strlen(trim($__compilerTemp46)) > 0) {
		$__compilerTemp45 .= '
		<div class="block">
			<div class="block-container">
				' . $__compilerTemp46 . '
			</div>
		</div>
	';
	}
	$__templater->modifySidebarHtml('shareSidebar', '
	' . $__compilerTemp45 . '
', 'replace');
	return $__finalCompiled;
}
);