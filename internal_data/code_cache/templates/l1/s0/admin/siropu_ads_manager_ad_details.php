<?php
// FROM HASH: d5bd724b14fa50b7d86457996d474478
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Ad details' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['ad']['Extra']['last_change'] != $__vars['ad']['create_date']) {
		$__compilerTemp1 .= '
				' . $__templater->formRow('', array(
			'label' => 'Last modified',
			'html' => $__templater->func('date_time', array($__vars['ad']['Extra']['last_change'], ), true),
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__vars['ad']['Package']) {
		$__compilerTemp2 .= '
					<a href="' . $__templater->func('link', array('ads-manager/packages/edit', $__vars['ad']['Package'], ), true) . '">' . $__templater->escape($__vars['ad']['Package']['title']) . '</a>
				';
	} else {
		$__compilerTemp2 .= '
					' . 'None' . '
				';
	}
	$__compilerTemp3 = '';
	if ($__templater->method($__vars['ad'], 'isEmbeddable', array())) {
		$__compilerTemp3 .= '
				';
		$__compilerTemp4 = '';
		if ($__templater->isTraversable($__vars['positions'])) {
			foreach ($__vars['positions'] AS $__vars['position']) {
				$__compilerTemp4 .= '
							<li>
								<a href="' . $__templater->func('link', array('ads-manager/positions/edit', $__vars['position'], ), true) . '">
									' . $__templater->escape($__vars['position']['title']);
				if ($__templater->method($__vars['position'], 'isDynamic', array())) {
					$__compilerTemp4 .= ' (' . $__templater->escape($__templater->method($__vars['ad'], 'getItemId', array(true, ))) . ')';
				}
				$__compilerTemp4 .= '
								</a>
							</li>
						';
			}
		}
		$__compilerTemp3 .= $__templater->formRow('
					<ol class="listPlain">
						' . $__compilerTemp4 . '
					</ol>
				', array(
			'label' => 'Positions',
		)) . '
			';
	}
	$__compilerTemp5 = '';
	if ($__templater->method($__vars['ad'], 'isCode', array())) {
		$__compilerTemp5 .= '
				' . $__templater->formRow('', array(
			'label' => 'Code',
			'html' => ($__templater->method($__vars['ad'], 'isCallback', array()) ? $__templater->filter($__vars['ad']['callback'], array(array('raw', array()),), true) : $__templater->filter($__vars['ad']['content_1'], array(array('raw', array()),), true)),
			'hint' => ($__templater->method($__vars['ad'], 'isCallback', array()) ? 'Callback' : ''),
		)) . '
			';
	} else if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'background', ), ))) {
		$__compilerTemp5 .= '
				';
		$__compilerTemp6 = '';
		if ($__vars['ad']['content_2']) {
			$__compilerTemp6 .= '
						' . $__templater->filter($__vars['ad']['content_2'], array(array('raw', array()),), true) . '
					';
		} else {
			$__compilerTemp6 .= '
						<ol class="' . (($__templater->func('count', array($__vars['ad']['banners'], ), false) > 1) ? '' : 'listPlain') . '">
							';
			if ($__templater->isTraversable($__vars['ad']['banners'])) {
				foreach ($__vars['ad']['banners'] AS $__vars['banner']) {
					$__compilerTemp6 .= '
								<li><img src="' . $__templater->escape($__vars['banner']) . '"></li>
							';
				}
			}
			$__compilerTemp6 .= '
						</ol>
					';
		}
		$__compilerTemp5 .= $__templater->formRow('
					' . $__compilerTemp6 . '
				', array(
			'label' => ($__templater->method($__vars['ad'], 'isBackground', array()) ? 'Background image' : 'Banner'),
		)) . '

				';
		if ($__vars['ad']['content_4']) {
			$__compilerTemp5 .= '
					' . $__templater->formRow('', array(
				'label' => 'Alt text',
				'html' => $__templater->escape($__vars['ad']['content_4']),
			)) . '
				';
		}
		$__compilerTemp5 .= '
			';
	} else if ($__templater->method($__vars['ad'], 'isLink', array())) {
		$__compilerTemp5 .= '
				' . $__templater->formRow('', array(
			'label' => 'Link title',
			'html' => $__templater->escape($__vars['ad']['title']),
		)) . '
			';
	} else if ($__templater->method($__vars['ad'], 'isText', array())) {
		$__compilerTemp5 .= '
				' . $__templater->formRow('', array(
			'label' => 'Title',
			'html' => $__templater->escape($__vars['ad']['title']),
		)) . '
				' . $__templater->formRow('', array(
			'label' => 'Description',
			'html' => $__templater->escape($__vars['ad']['content_1']),
		)) . '

				';
		if ($__templater->method($__vars['ad'], 'hasBanner', array())) {
			$__compilerTemp5 .= '
					';
			$__compilerTemp7 = '';
			if ($__vars['ad']['content_2']) {
				$__compilerTemp7 .= '
							' . $__templater->filter($__vars['ad']['content_2'], array(array('raw', array()),), true) . '
						';
			} else {
				$__compilerTemp7 .= '
							<ol class="' . (($__templater->func('count', array($__vars['ad']['banners'], ), false) > 1) ? '' : 'listPlain') . '">
								';
				if ($__templater->isTraversable($__vars['ad']['banners'])) {
					foreach ($__vars['ad']['banners'] AS $__vars['banner']) {
						$__compilerTemp7 .= '
									<li><img src="' . $__templater->escape($__vars['banner']) . '"></li>
								';
					}
				}
				$__compilerTemp7 .= '
							</ol>
						';
			}
			$__compilerTemp5 .= $__templater->formRow('
						' . $__compilerTemp7 . '
					', array(
				'label' => 'Banner',
			)) . '
				';
		}
		$__compilerTemp5 .= '

				';
		if ($__vars['ad']['content_4']) {
			$__compilerTemp5 .= '
					' . $__templater->formRow('', array(
				'label' => 'Alt text',
				'html' => $__templater->escape($__vars['ad']['content_4']),
			)) . '
				';
		}
		$__compilerTemp5 .= '
			';
	} else if ($__templater->method($__vars['ad'], 'isKeyword', array())) {
		$__compilerTemp5 .= '
				';
		$__compilerTemp8 = '';
		if ($__vars['ad']['item_array']) {
			$__compilerTemp8 .= '
							';
			if ($__templater->isTraversable($__vars['ad']['item_array'])) {
				foreach ($__vars['ad']['item_array'] AS $__vars['item']) {
					$__compilerTemp8 .= '
								<li>' . $__templater->escape($__vars['item']['k']) . ' => <a href="' . $__templater->escape($__vars['item']['u']) . '" target="_blank">' . $__templater->escape($__vars['item']['u']) . '</a></li>
							';
				}
			}
			$__compilerTemp8 .= '
						';
		} else {
			$__compilerTemp8 .= '
							';
			$__compilerTemp9 = $__templater->method($__vars['ad'], 'getKeywords', array());
			if ($__templater->isTraversable($__compilerTemp9)) {
				foreach ($__compilerTemp9 AS $__vars['keyword']) {
					$__compilerTemp8 .= '
								<li>
									' . $__templater->escape($__vars['keyword']) . '
									';
					if ($__vars['ad']['Package']['cost_custom'] AND $__templater->method($__vars['ad']['Package'], 'getItemCustomCost', array($__vars['keyword'], ))) {
						$__compilerTemp8 .= '
										<span style="color: gray;">(' . 'Premium keyword' . ')</span>
									';
					}
					$__compilerTemp8 .= '
								</li>
							';
				}
			}
			$__compilerTemp8 .= '
						';
		}
		$__compilerTemp5 .= $__templater->formRow('
					<ol class="listPlain">
						' . $__compilerTemp8 . '
					</ol>
				', array(
			'label' => 'Keywords',
		)) . '

				';
		$__compilerTemp10 = '';
		if ($__vars['ad']['Extra']['exclusive_use']) {
			$__compilerTemp10 .= '
						<span style="font-weight: bold; color: green;">' . 'Yes' . '</span>
					';
		} else {
			$__compilerTemp10 .= '
						<span style="font-weight: bold; color: gray;">' . 'No' . '</span>
					';
		}
		$__compilerTemp5 .= $__templater->formRow('
					' . $__compilerTemp10 . '
				', array(
			'label' => 'Exclusive keywords',
		)) . '

				';
		if ($__vars['ad']['title']) {
			$__compilerTemp5 .= '
					' . $__templater->formRow('', array(
				'label' => 'Link title',
				'html' => $__templater->escape($__vars['ad']['title']),
			)) . '
				';
		}
		$__compilerTemp5 .= '
			';
	} else if ($__templater->method($__vars['ad'], 'isThread', array())) {
		$__compilerTemp5 .= '
				' . $__templater->formRow('
					<a href="' . $__templater->func('link_type', array('public', 'forums', $__vars['ad']['Forum'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Forum']['title']) . '</a>
				', array(
			'label' => 'Forum',
		)) . '
				';
		if ($__vars['ad']['Thread']) {
			$__compilerTemp5 .= '
					' . $__templater->formRow('
						<a href="' . $__templater->func('link_type', array('public', 'threads', $__vars['ad']['Thread'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Thread']['title']) . '</a>
					', array(
				'label' => 'Thread',
			)) . '
				';
		} else {
			$__compilerTemp5 .= '
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
		$__compilerTemp5 .= '

				';
		$__compilerTemp11 = '';
		if ($__vars['ad']['Extra']['ThreadPrefix']) {
			$__compilerTemp11 .= '
						' . $__templater->escape($__vars['ad']['Extra']['ThreadPrefix']['title']) . '
					';
		} else {
			$__compilerTemp11 .= '
						' . 'None' . '
					';
		}
		$__compilerTemp5 .= $__templater->formRow('
					' . $__compilerTemp11 . '
				', array(
			'label' => 'Prefix',
		)) . '

				';
		if ($__vars['ad']['Extra']['custom_fields']) {
			$__compilerTemp5 .= '
					' . $__templater->formRow('
						' . $__templater->callMacro('public:custom_fields_macros', 'custom_fields_view', array(
				'type' => 'threads',
				'group' => 'before',
				'set' => $__templater->method($__vars['ad']['Extra'], 'getCustomFields', array()),
				'onlyInclude' => $__vars['ad']['Forum']['field_cache'],
			), $__vars) . '
					', array(
				'label' => 'Custom fields',
			)) . '
				';
		}
		$__compilerTemp5 .= '

				';
		$__compilerTemp12 = '';
		if ($__vars['ad']['Extra']['is_sticky']) {
			$__compilerTemp12 .= '
						<span style="font-weight: bold; color: green;">' . 'Yes' . '</span>
					';
		} else {
			$__compilerTemp12 .= '
						<span style="font-weight: bold; color: gray;">' . 'No' . '</span>
					';
		}
		$__compilerTemp5 .= $__templater->formRow('
					' . $__compilerTemp12 . '
				', array(
			'label' => 'Stick thread',
		)) . '

				';
		if (!$__templater->test($__vars['attachments'], 'empty', array())) {
			$__compilerTemp5 .= '
					';
			$__templater->includeCss('public:attachments.less');
			$__compilerTemp13 = '';
			if ($__templater->isTraversable($__vars['attachments'])) {
				foreach ($__vars['attachments'] AS $__vars['attachment']) {
					$__compilerTemp13 .= '
									' . $__templater->callMacro('public:attachment_macros', 'attachment_list_item', array(
						'attachment' => $__vars['attachment'],
						'canView' => true,
					), $__vars) . '
								';
				}
			}
			$__compilerTemp5 .= $__templater->formRow('
						' . '' . '
							<ul class="attachmentList resourceBody-attachments">
								' . $__compilerTemp13 . '
							</ul>
					', array(
				'label' => 'Attachments',
			)) . '
				';
		}
		$__compilerTemp5 .= '
			';
	} else if ($__templater->method($__vars['ad'], 'isSticky', array())) {
		$__compilerTemp5 .= '
				' . $__templater->formRow('
					<a href="' . $__templater->func('link_type', array('public', 'threads', $__vars['ad']['Thread'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Thread']['title']) . '</a>
				', array(
			'label' => 'Thread',
		)) . '
				' . $__templater->formRow('
					<a href="' . $__templater->func('link_type', array('public', 'forums', $__vars['ad']['Thread']['Forum'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Thread']['Forum']['title']) . '</a>
				', array(
			'label' => 'Forum',
		)) . '
			';
	} else if ($__templater->method($__vars['ad'], 'isResource', array())) {
		$__compilerTemp5 .= '
				' . $__templater->formRow('
					<a href="' . $__templater->func('link_type', array('public', 'resources', $__vars['ad']['Resource'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Resource']['title']) . '</a>
				', array(
			'label' => 'Resource',
		)) . '
				' . $__templater->formRow('
					<a href="' . $__templater->func('link_type', array('public', 'resources/categories', $__vars['ad']['Resource']['Category'], ), true) . '" target="_blank">' . $__templater->escape($__vars['ad']['Resource']['Category']['title']) . '</a>
				', array(
			'label' => 'Category',
		)) . '
			';
	}
	$__compilerTemp14 = '';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'text', 'link', 'keyword', 'background', ), ))) {
		$__compilerTemp14 .= '
				';
		$__compilerTemp15 = '';
		if ($__vars['ad']['target_url']) {
			$__compilerTemp15 .= '
						<a href="' . $__templater->escape($__vars['ad']['target_url']) . '" target="_blank">' . $__templater->escape($__vars['ad']['target_url']) . '</a>
					';
		} else {
			$__compilerTemp15 .= '
						' . 'N/A' . '
					';
		}
		$__compilerTemp14 .= $__templater->formRow('
					' . $__compilerTemp15 . '
				', array(
			'label' => 'Target URL',
		)) . '
			';
	}
	$__compilerTemp16 = '';
	if ($__templater->method($__vars['ad'], 'isPopup', array())) {
		$__compilerTemp16 .= '
				';
		if ($__vars['ad']['title']) {
			$__compilerTemp16 .= '
					' . $__templater->formRow('', array(
				'label' => 'Popup title',
				'html' => $__templater->escape($__vars['ad']['title']),
			)) . '
				';
		}
		$__compilerTemp16 .= '
				';
		if ($__vars['ad']['content_1']) {
			$__compilerTemp16 .= '
					' . $__templater->formRow('', array(
				'label' => 'Popup content',
				'html' => $__templater->filter($__vars['ad']['content_1'], array(array('raw', array()),), true),
			)) . '
				';
		}
		$__compilerTemp16 .= '
				';
		if ($__vars['ad']['content_2']) {
			$__compilerTemp16 .= '
					' . $__templater->formRow('', array(
				'label' => 'Custom popup code',
				'html' => $__templater->escape($__vars['ad']['content_2']),
			)) . '
				';
		}
		$__compilerTemp16 .= '
				';
		if ($__vars['ad']['target_url']) {
			$__compilerTemp16 .= '
					' . $__templater->formRow('', array(
				'label' => 'Popup window URL',
				'html' => $__templater->escape($__vars['ad']['target_url']),
			)) . '
				';
		}
		$__compilerTemp16 .= '
				';
		if ($__vars['ad']['content_3']) {
			$__compilerTemp16 .= '
					' . $__templater->formRow('', array(
				'label' => 'Popup window features',
				'html' => $__templater->escape($__vars['ad']['content_3']),
			)) . '
				';
		}
		$__compilerTemp16 .= '
			';
	}
	$__compilerTemp17 = '';
	if ($__templater->method($__vars['ad'], 'isCustom', array())) {
		$__compilerTemp17 .= '
				' . $__templater->formRow('', array(
			'label' => 'Ad details',
			'html' => $__templater->escape($__vars['ad']['content_1']),
		)) . '
			';
	}
	$__compilerTemp18 = '';
	if ($__vars['ad']['Extra']['purchase'] AND $__vars['ad']['Package']) {
		$__compilerTemp18 .= '
				';
		$__vars['cost'] = $__templater->method($__vars['ad'], 'getCost', array());
		$__compilerTemp18 .= '

				<hr class="formRowSep" />

				' . $__templater->formRow('
					' . $__templater->escape($__vars['ad']['Extra']['purchase']) . ' ' . $__templater->escape($__templater->method($__vars['ad']['Package'], 'getCostPerPhrase', array($__vars['ad']['Extra']['purchase'], ))) . '
				', array(
			'label' => 'Purchase',
		)) . '

				' . $__templater->formRow('', array(
			'label' => 'Cost',
			'html' => $__templater->filter($__vars['cost']['totalCost'], array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true),
		)) . '

				';
		if ($__vars['cost']['discountAmount']) {
			$__compilerTemp18 .= '
					';
			$__compilerTemp19 = '';
			if ($__vars['cost']['discountPercent'] >= 100) {
				$__compilerTemp19 .= '
							100%
						';
			} else {
				$__compilerTemp19 .= '
							' . $__templater->filter($__vars['cost']['discountAmount'], array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true) . ' (' . $__templater->escape($__vars['cost']['discountPercent']) . '%)
						';
			}
			$__compilerTemp18 .= $__templater->formRow('
						' . $__compilerTemp19 . '
					', array(
				'label' => 'Discount',
			)) . '

					';
			if ($__vars['ad']['Extra']['promo_code']) {
				$__compilerTemp18 .= '
						';
				$__compilerTemp20 = '';
				if ($__vars['ad']['Extra']['PromoCode']) {
					$__compilerTemp20 .= '
								<a href="' . $__templater->func('link', array('ads-manager/promo-codes/edit', $__vars['ad']['Extra']['PromoCode'], ), true) . '" data-xf-init="overlay">' . $__templater->escape($__vars['ad']['Extra']['promo_code']) . '</a>
							';
				} else {
					$__compilerTemp20 .= '
								' . $__templater->escape($__vars['ad']['Extra']['promo_code']) . '
							';
				}
				$__compilerTemp18 .= $__templater->formRow('
							' . $__compilerTemp20 . '
						', array(
					'label' => 'Promo code',
				)) . '
					';
			}
			$__compilerTemp18 .= '

					' . $__templater->formRow('', array(
				'label' => 'Total cost',
				'html' => $__templater->filter($__vars['cost']['costDiscounted'], array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true),
			)) . '
				';
		}
		$__compilerTemp18 .= '
			';
	}
	$__compilerTemp21 = '';
	if ($__vars['ad']['Extra']['notes']) {
		$__compilerTemp21 .= '
				' . $__templater->formRow('', array(
			'label' => 'Notes',
			'html' => $__templater->escape($__vars['ad']['Extra']['notes']),
		)) . '
				<hr class="formRowSep" />
			';
	}
	$__compilerTemp22 = '';
	if ($__templater->method($__vars['ad'], 'isRejected', array()) AND $__vars['ad']['Extra']['reject_reason']) {
		$__compilerTemp22 .= '
				' . $__templater->formRow('', array(
			'label' => 'Reject reason',
			'html' => $__templater->escape($__vars['ad']['Extra']['reject_reason']),
		)) . '

				<hr class="formRowSep" />
			';
	}
	$__compilerTemp23 = '';
	if ($__vars['ad']['start_date']) {
		$__compilerTemp23 .= '
				' . $__templater->formRow('', array(
			'label' => 'Start date',
			'html' => $__templater->func('date_time', array($__vars['ad']['start_date'], ), true),
		)) . '
			';
	}
	$__compilerTemp24 = '';
	if ($__vars['ad']['end_date']) {
		$__compilerTemp24 .= '
				' . $__templater->formRow('', array(
			'label' => 'End date',
			'html' => $__templater->func('date_time', array($__vars['ad']['end_date'], ), true),
		)) . '
			';
	}
	$__compilerTemp25 = '';
	if ($__vars['ad']['view_limit']) {
		$__compilerTemp25 .= '
				' . $__templater->formRow('', array(
			'label' => 'View limit',
			'html' => $__templater->escape($__vars['ad']['view_limit']),
		)) . '
			';
	}
	$__compilerTemp26 = '';
	if ($__vars['ad']['click_limit']) {
		$__compilerTemp26 .= '
				' . $__templater->formRow('', array(
			'label' => 'Click limit',
			'html' => $__templater->escape($__vars['ad']['click_limit']),
		)) . '
			';
	}
	$__compilerTemp27 = '';
	if (!$__templater->test($__vars['blockedIps'], 'empty', array())) {
		$__compilerTemp27 .= '
				';
		$__compilerTemp28 = '';
		if ($__templater->isTraversable($__vars['blockedIps'])) {
			foreach ($__vars['blockedIps'] AS $__vars['entry']) {
				$__compilerTemp28 .= '
							' . $__templater->dataRow(array(
					'delete' => $__templater->func('link', array('ads-manager/ads/deblock-ip', $__vars['ad'], array('ip' => $__templater->filter($__vars['entry']['ip'], array(array('ip', array()),), false), ), ), false),
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->filter($__vars['entry']['ip'], array(array('ip', array()),), true),
				),
				array(
					'_type' => 'cell',
					'html' => ($__templater->escape($__vars['entry']['page_url']) ?: 'N/A'),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_time', array($__vars['entry']['log_date'], ), true),
				))) . '
						';
			}
		}
		$__compilerTemp27 .= $__templater->formRow('
					' . $__templater->dataList('
						' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'IP',
		),
		array(
			'_type' => 'cell',
			'html' => 'Page URL',
		),
		array(
			'_type' => 'cell',
			'html' => 'Date',
		),
		array(
			'_type' => 'cell',
			'html' => '',
		))) . '
						' . $__compilerTemp28 . '
					', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				', array(
			'label' => 'Blocked IPs',
		)) . '
			';
	}
	$__compilerTemp29 = '';
	if ($__vars['ad']['Extra']['active_since']) {
		$__compilerTemp29 .= '
				' . $__templater->formRow('', array(
			'label' => 'Active since',
			'html' => $__templater->func('date_time', array($__vars['ad']['Extra']['active_since'], ), true),
		)) . '
			';
	} else if ($__vars['ad']['Extra']['last_active']) {
		$__compilerTemp29 .= '
				' . $__templater->formRow('', array(
			'label' => 'Last active',
			'html' => $__templater->func('date_time', array($__vars['ad']['Extra']['last_active'], ), true),
		)) . '
			';
	}
	$__compilerTemp30 = '';
	if ($__vars['ad']['Extra']['prev_status']) {
		$__compilerTemp30 .= '
				' . $__templater->formRow('', array(
			'label' => 'Previous status',
			'html' => $__templater->func('sam_status_phrase', array($__vars['ad']['Extra']['prev_status'], ), true),
		)) . '
			';
	}
	$__compilerTemp31 = '';
	if ($__templater->method($__vars['ad'], 'isPendingApproval', array())) {
		$__compilerTemp31 .= '
			<div class="block-footer">
				<i class="fa fa-info" aria-hidden="true"></i> ' . 'Approving the ad will automatically generate a new invoice for the advertiser if there are slots available, else the ad will be added to the queue.' . '
			</div>
		';
	}
	$__compilerTemp32 = '';
	if ($__templater->method($__vars['ad'], 'isPendingApproval', array())) {
		$__compilerTemp32 .= '
					' . $__templater->button('Approve', array(
			'type' => 'submit',
			'class' => 'button--primary',
			'fa' => 'fa-thumbs-up',
		), '', array(
		)) . '
					' . $__templater->button('Reject' . $__vars['xf']['language']['ellipsis'], array(
			'href' => $__templater->func('link', array('ads-manager/ads/reject', $__vars['ad'], ), false),
			'overlay' => 'true',
			'fa' => 'fa-thumbs-down',
		), '', array(
		)) . '
				';
	}
	$__compilerTemp33 = '';
	if ($__vars['ad']['Extra']['purchase']) {
		$__compilerTemp33 .= '
					' . $__templater->button('Send message', array(
			'href' => $__templater->func('link', array('ads-manager/ads/message', $__vars['ad'], ), false),
			'overlay' => 'true',
			'fa' => 'fa-comment',
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . $__templater->func('username_link', array($__vars['ad']['User'], true, array(
		'defaultname' => $__vars['ad']['username'],
	))) . '
			', array(
		'label' => 'Created by',
	)) . '

			' . $__templater->formRow('
				' . $__templater->func('date_dynamic', array($__vars['ad']['create_date'], array(
	))) . '
			', array(
		'label' => 'Creation date',
	)) . '

			' . $__compilerTemp1 . '

			' . $__templater->formRow('
				' . $__compilerTemp2 . '
			', array(
		'label' => 'Package',
	)) . '

			' . $__templater->formRow('', array(
		'label' => 'Type',
		'html' => $__templater->func('sam_type_phrase', array($__vars['ad']['type'], ), true),
	)) . '

			' . $__compilerTemp3 . '

			<hr class="formRowSep" />

			' . $__compilerTemp5 . '

			' . $__compilerTemp14 . '

			' . $__compilerTemp16 . '

			' . $__compilerTemp17 . '

			<hr class="formRowSep" />

			' . $__compilerTemp18 . '

			<hr class="formRowSep" />

			' . $__compilerTemp21 . '

			' . $__compilerTemp22 . '

			' . $__compilerTemp23 . '

			' . $__compilerTemp24 . '

			' . $__compilerTemp25 . '

			' . $__compilerTemp26 . '

			<hr class="formRowSep" />

			' . $__compilerTemp27 . '

			' . $__compilerTemp29 . '

			' . $__compilerTemp30 . '
		</div>

		' . $__compilerTemp31 . '

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
	), array(
		'html' => '
				' . $__compilerTemp32 . '
				' . $__compilerTemp33 . '
				' . $__templater->button('', array(
		'href' => $__templater->func('link', array('ads-manager/ads/edit', $__vars['ad'], ), false),
		'icon' => 'edit',
		'overlay' => 'true',
	), '', array(
	)) . '
				' . $__templater->button('', array(
		'href' => $__templater->func('link', array('ads-manager/ads/delete', $__vars['ad'], ), false),
		'icon' => 'delete',
		'overlay' => 'true',
	), '', array(
	)) . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/approve', $__vars['ad'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);