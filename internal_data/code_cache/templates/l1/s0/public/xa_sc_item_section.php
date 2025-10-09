<?php
// FROM HASH: edad8d4bbdef1bf5d059e17a9f55bd8e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('sc_item', $__vars['item'], 'escaped', ), true) . ($__vars['item']['meta_title'] ? $__templater->escape($__vars['item']['meta_title']) : $__templater->escape($__vars['item']['title'])) . ' - ' . $__templater->escape($__vars['sectionTitle']));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	if (($__vars['sectionId'] == 2) AND ($__vars['item']['message_s2'] != '')) {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['message_s2'], 250, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	} else if (($__vars['sectionId'] == 3) AND ($__vars['item']['message_s3'] != '')) {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['message_s3'], 250, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	} else if (($__vars['sectionId'] == 4) AND ($__vars['item']['message_s4'] != '')) {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['message_s4'], 250, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	} else if (($__vars['sectionId'] == 5) AND ($__vars['item']['message_s5'] != '')) {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['message_s5'], 250, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	} else if (($__vars['sectionId'] == 6) AND ($__vars['item']['message_s6'] != '')) {
		$__finalCompiled .= '
	';
		$__vars['descSnippet'] = $__templater->func('snippet', array($__vars['item']['message_s6'], 250, array('stripBbCode' => true, ), ), false);
		$__finalCompiled .= '
';
	} else {
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
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'metadata', array(
		'title' => ($__vars['item']['og_title'] ? $__vars['item']['og_title'] : ($__vars['item']['meta_title'] ? $__vars['item']['meta_title'] : $__vars['item']['title'])) . ' - ' . $__vars['sectionTitle'],
		'description' => $__vars['descSnippet'],
		'type' => 'article',
		'shareUrl' => $__templater->func('link', array('canonical:showcase', $__vars['item'], array('section' => $__vars['sectionId'], ), ), false),
		'canonicalUrl' => $__templater->func('link', array('canonical:showcase', $__vars['item'], array('section' => $__vars['sectionId'], ), ), false),
		'imageUrl' => ($__vars['item']['CoverImage'] ? $__templater->func('link', array('canonical:showcase/cover-image', $__vars['item'], ), false) : ($__vars['item']['Category']['content_image_url'] ? $__templater->func('base_url', array($__vars['item']['Category']['content_image_url'], true, ), false) : '')),
		'twitterCard' => 'summary_large_image',
	), $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__vars['item']['meta_title']) {
		$__compilerTemp1 .= '
			"headline": "' . $__templater->filter($__vars['item']['meta_title'], array(array('escape', array('json', )),), true) . ' - ' . $__templater->filter($__vars['sectionTitle'], array(array('escape', array('json', )),), true) . '",
		';
	} else {
		$__compilerTemp1 .= '
			"headline": "' . $__templater->filter($__vars['item']['title'], array(array('escape', array('json', )),), true) . ' - ' . $__templater->filter($__vars['sectionTitle'], array(array('escape', array('json', )),), true) . '",
		';
	}
	$__compilerTemp2 = '';
	if ($__vars['item']['og_title']) {
		$__compilerTemp2 .= '
			"alternativeHeadline": "' . $__templater->filter($__vars['item']['og_title'], array(array('escape', array('json', )),), true) . ' - ' . $__templater->filter($__vars['sectionTitle'], array(array('escape', array('json', )),), true) . '",
		';
	} else {
		$__compilerTemp2 .= '
			"alternativeHeadline": "' . $__templater->filter($__vars['item']['title'], array(array('escape', array('json', )),), true) . ' - ' . $__templater->filter($__vars['sectionTitle'], array(array('escape', array('json', )),), true) . '",
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
		"@id": "' . $__templater->filter($__templater->func('link', array('canonical:showcase', $__vars['item'], array('section' => $__vars['sectionId'], ), ), false), array(array('escape', array('json', )),), true) . '",
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
	$__compilerTemp6['pageSelected'] = 'section_' . $__vars['sectionId'];
	$__templater->wrapTemplate('xa_sc_item_wrapper', $__compilerTemp6);
	$__finalCompiled .= '

<div class="block">
	';
	$__compilerTemp7 = '';
	$__compilerTemp7 .= '
				' . $__templater->callMacro('xa_sc_item_wrapper_macros', 'action_buttons', array(
		'item' => $__vars['item'],
		'showRateButton' => 'true',
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
	<div class="block-container">
		<div class="block-body">
			<div class="itemBody">
				<article class="itemBody-main">
					' . $__templater->callAdsMacro('sc_item_view_above_item_sections_content', array(
		'item' => $__vars['item'],
	), $__vars) . '

					';
	if ($__vars['sectionId'] == 2) {
		$__finalCompiled .= '
						';
		$__compilerTemp8 = '';
		$__compilerTemp8 .= '
								' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'section_2',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => 'itemBody-fields itemBody-fields--before',
		), $__vars) . '

								';
		if ($__vars['category']['editor_s2'] AND ($__vars['item']['message_s2'] != '')) {
			$__compilerTemp8 .= '
									' . $__templater->func('bb_code', array($__vars['item']['message_s2'], 'sc_item', $__vars['item'], ), true) . '
								';
		}
		$__compilerTemp8 .= '
							';
		if (strlen(trim($__compilerTemp8)) > 0) {
			$__finalCompiled .= '
							' . $__compilerTemp8 . '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['sectionId'] == 3) {
		$__finalCompiled .= '
						';
		$__compilerTemp9 = '';
		$__compilerTemp9 .= '
								' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'section_3',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => 'itemBody-fields itemBody-fields--before',
		), $__vars) . '

								';
		if ($__vars['category']['editor_s3'] AND ($__vars['item']['message_s3'] != '')) {
			$__compilerTemp9 .= '
									' . $__templater->func('bb_code', array($__vars['item']['message_s3'], 'sc_item', $__vars['item'], ), true) . '
								';
		}
		$__compilerTemp9 .= '
							';
		if (strlen(trim($__compilerTemp9)) > 0) {
			$__finalCompiled .= '
							' . $__compilerTemp9 . '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['sectionId'] == 4) {
		$__finalCompiled .= '
						';
		$__compilerTemp10 = '';
		$__compilerTemp10 .= '
								' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'section_4',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => 'itemBody-fields itemBody-fields--before',
		), $__vars) . '

								';
		if ($__vars['category']['editor_s4'] AND ($__vars['item']['message_s4'] != '')) {
			$__compilerTemp10 .= '
									' . $__templater->func('bb_code', array($__vars['item']['message_s4'], 'sc_item', $__vars['item'], ), true) . '
								';
		}
		$__compilerTemp10 .= '
							';
		if (strlen(trim($__compilerTemp10)) > 0) {
			$__finalCompiled .= '
							' . $__compilerTemp10 . '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['sectionId'] == 5) {
		$__finalCompiled .= '
						';
		$__compilerTemp11 = '';
		$__compilerTemp11 .= '
								' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'section_5',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => 'itemBody-fields itemBody-fields--before',
		), $__vars) . '

								';
		if ($__vars['category']['editor_s5'] AND ($__vars['item']['message_s5'] != '')) {
			$__compilerTemp11 .= '
									' . $__templater->func('bb_code', array($__vars['item']['message_s5'], 'sc_item', $__vars['item'], ), true) . '
								';
		}
		$__compilerTemp11 .= '
							';
		if (strlen(trim($__compilerTemp11)) > 0) {
			$__finalCompiled .= '
							' . $__compilerTemp11 . '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['sectionId'] == 6) {
		$__finalCompiled .= '
						';
		$__compilerTemp12 = '';
		$__compilerTemp12 .= '
								' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
			'type' => 'sc_items',
			'group' => 'section_6',
			'onlyInclude' => $__vars['category']['field_cache'],
			'set' => $__vars['item']['custom_fields'],
			'wrapperClass' => 'itemBody-fields itemBody-fields--before',
		), $__vars) . '

								';
		if ($__vars['category']['editor_s6'] AND ($__vars['item']['message_s6'] != '')) {
			$__compilerTemp12 .= '
									' . $__templater->func('bb_code', array($__vars['item']['message_s6'], 'sc_item', $__vars['item'], ), true) . '
								';
		}
		$__compilerTemp12 .= '
							';
		if (strlen(trim($__compilerTemp12)) > 0) {
			$__finalCompiled .= '
							' . $__compilerTemp12 . '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					' . $__templater->callAdsMacro('sc_item_view_below_item_sections_content', array(
		'item' => $__vars['item'],
	), $__vars) . '
				</article>
			</div>
		</div>
	</div>
</div>

';
	$__compilerTemp13 = '';
	$__compilerTemp13 .= '
				' . $__templater->callMacro('share_page_macros', 'buttons', array(
		'iconic' => true,
		'label' => 'Share' . ':',
	), $__vars) . '
			';
	if (strlen(trim($__compilerTemp13)) > 0) {
		$__finalCompiled .= '
	<div class="block">
		<div class="blockMessage blockMessage--none">
			' . $__compilerTemp13 . '
		</div>
	</div>	
';
	}
	return $__finalCompiled;
}
);