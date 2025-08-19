<?php
// FROM HASH: db83a445b9f8cefb27b2ce8debd672b3
return array(
'macros' => array('basic_info_pane' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'package' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li role="tabpanel" class="is-active" id="basicInformation">
		' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['package']['title'],
	), array(
		'label' => 'Package title',
	)) . '

		';
	if ($__templater->method($__vars['package'], 'isOfType', array(array('code', 'banner', 'text', 'link', ), ))) {
		$__finalCompiled .= '
			' . $__templater->callMacro('siropu_ads_manager_position_macros', 'position_select', array(
			'entity' => $__vars['package'],
		), $__vars) . '
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->method($__vars['package'], 'isOfType', array(array('code', 'banner', 'text', ), ))) {
		$__finalCompiled .= '
			';
		if (!$__templater->method($__vars['package'], 'isText', array())) {
			$__finalCompiled .= '
				' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'settings[lazyload]',
				'value' => '1',
				'checked' => ($__vars['package']['settings']['lazyload'] == 1),
				'label' => 'Enable lazy loading',
				'data-hide' => 'true',
				'_dependent' => array('
							<label>' . 'Refresh every' . $__vars['xf']['language']['ellipsis'] . '</label>
							' . $__templater->formNumberBox(array(
				'name' => 'settings[refresh]',
				'value' => ($__vars['package']['settings']['refresh'] ?: 0),
				'units' => 'Seconds',
				'min' => '0',
			)) . '
						'),
				'_type' => 'option',
			)), array(
				'explain' => 'This option allows you to load the ad content after the page loads, when the ad container is in the view. The second option allows you to refresh the ad every x seconds after it has been loaded.',
			)) . '
			';
		}
		$__finalCompiled .= '

			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[lazyload_image]',
			'value' => '1',
			'checked' => ($__vars['package']['settings']['lazyload_image'] == 1),
			'label' => 'Enable image lazy loading',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to load the ad image after the page loads, when the ad container is in the view.',
		)) . '
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->method($__vars['package'], 'isCode', array())) {
		$__finalCompiled .= '
			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[no_wrapper]',
			'value' => '1',
			'checked' => ($__vars['package']['settings']['no_wrapper'] == 1),
			'label' => 'Display without wrapper',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to display the ad code without any div tags around the ad. Please note that this option doesn\'t work with lazy loading, AdBlock detection and most of the settings in the Settings tab. ',
		)) . '
		';
	}
	$__finalCompiled .= '

		';
	if (!$__templater->method($__vars['package'], 'hasNoCriteria', array())) {
		$__finalCompiled .= '
			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'bypass_inheritance',
			'value' => '1',
			'label' => 'Override ads inheritance setting',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to override the ad option "Inherit package setting" for all its ads. Please note that after saving the package, this option will remain unchecked.',
		)) . '
		';
	}
	$__finalCompiled .= '
	</li>
';
	return $__finalCompiled;
}
),
'advertising_pane' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'package' => '!',
		'advertiserCriteria' => '!',
		'advertiserUserGroups' => '!',
		'clone' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li role="tabpanel" id="advertising">
		';
	if ($__templater->method($__vars['package'], 'isOfType', array(array('banner', 'text', ), ))) {
		$__finalCompiled .= '
			';
		$__compilerTemp1 = array();
		$__compilerTemp2 = $__templater->method($__vars['xf']['samAdmin'], 'getAdSizes', array());
		if ($__templater->isTraversable($__compilerTemp2)) {
			foreach ($__compilerTemp2 AS $__vars['sizes']) {
				$__compilerTemp1[] = array(
					'label' => $__vars['sizes']['group'],
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
				if ($__templater->isTraversable($__vars['sizes']['sizes'])) {
					foreach ($__vars['sizes']['sizes'] AS $__vars['size']) {
						$__compilerTemp1[$__compilerTemp3]['options'][] = array(
							'value' => $__vars['size'],
							'label' => $__templater->escape($__vars['size']),
							'_type' => 'option',
						);
					}
				}
			}
		}
		$__finalCompiled .= $__templater->formSelectRow(array(
			'name' => 'settings[ad_allowed_sizes]',
			'value' => $__vars['package']['settings']['ad_allowed_sizes'],
			'multiple' => 'true',
		), $__compilerTemp1, array(
			'label' => 'Allowed ad sizes',
			'explain' => 'This option allows you to set which ad sizes are allowed for banner images. To allow any size, leave as is.',
		)) . '
		';
	}
	$__finalCompiled .= '

		' . $__templater->formNumberBoxRow(array(
		'name' => 'ad_allowed_limit',
		'value' => $__vars['package']['ad_allowed_limit'],
		'size' => '5',
		'min' => '1',
	), array(
		'label' => 'Maximum active ads allowed',
		'explain' => 'The maximum number of active ads this package can have.',
	)) . '

		<hr class="formRowSep" />

		';
	$__compilerTemp4 = array(array(
		'value' => 'day',
		'label' => 'Per day',
		'_type' => 'option',
	)
,array(
		'value' => 'week',
		'label' => 'Per week',
		'_type' => 'option',
	)
,array(
		'value' => 'month',
		'label' => 'Per month',
		'_type' => 'option',
	)
,array(
		'value' => 'year',
		'label' => 'Per year',
		'_type' => 'option',
	));
	if (!$__templater->method($__vars['package'], 'hasNoCriteria', array())) {
		$__compilerTemp4[] = array(
			'value' => 'cpm',
			'label' => 'Per view (CPM)',
			'_type' => 'option',
		);
		$__compilerTemp4[] = array(
			'value' => 'cpc',
			'label' => 'Per click (CPC)',
			'_type' => 'option',
		);
	}
	$__compilerTemp4[] = array(
		'value' => '',
		'label' => 'Lifetime',
		'_type' => 'option',
	);
	$__finalCompiled .= $__templater->formRow('
			<div class="inputGroup">
				' . $__templater->formTextBox(array(
		'name' => 'cost_amount',
		'value' => $__vars['package']['cost_amount'],
	)) . '
				<span class="inputGroup-text"></span>
				' . $__templater->callMacro('public:currency_macros', 'currency_list', array(
		'value' => ($__vars['package']['cost_currency'] ?: $__vars['xf']['options']['siropuAdsManagerPreferredCurrency']),
	), $__vars) . '
				<span class="inputGroup-text"></span>
				' . $__templater->formSelect(array(
		'name' => 'cost_per',
		'value' => $__vars['package']['cost_per'],
		'data-is-insert' => (($__templater->method($__vars['package'], 'isInsert', array()) AND (!$__vars['clone'])) ? 'true' : 'false'),
		'data-xf-init' => 'siropu-ads-manager-cost-per',
	), $__compilerTemp4) . '
			</div>
		', array(
		'label' => 'Ad cost',
	)) . '

		';
	if (!$__templater->method($__vars['package'], 'isXFItem', array())) {
		$__finalCompiled .= '
			' . $__templater->formRow('
				<div class="inputGroup">
					' . $__templater->formNumberBox(array(
			'name' => 'settings[cpm_distribution][length]',
			'value' => $__vars['package']['settings']['cpm_distribution']['length'],
			'min' => '0',
		)) . '
					<span class="inputGroup-text"></span>
					' . $__templater->formSelect(array(
			'name' => 'settings[cpm_distribution][unit]',
			'value' => $__vars['package']['settings']['cpm_distribution']['unit'],
		), array(array(
			'value' => 'days',
			'label' => 'Days',
			'_type' => 'option',
		),
		array(
			'value' => 'weeks',
			'label' => 'Weeks',
			'_type' => 'option',
		),
		array(
			'value' => 'month',
			'label' => 'Months',
			'_type' => 'option',
		))) . '
				</div>
			', array(
			'label' => 'Impressions distribution',
			'explain' => 'This option allows you to distribute impressions over a period of time.',
			'hint' => 'Optional',
			'rowclass' => 'samDistribution',
		)) . '
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->method($__vars['package'], 'isOfType', array(array('keyword', 'sticky', 'thread', 'resource', ), ))) {
		$__finalCompiled .= '
			';
		$__compilerTemp5 = '';
		if ($__templater->method($__vars['package'], 'isKeyword', array())) {
			$__compilerTemp5 .= '
					' . 'Custom keyword cost' . '
				';
		} else if ($__templater->method($__vars['package'], 'isOfType', array(array('sticky', 'thread', ), ))) {
			$__compilerTemp5 .= '
					' . 'Custom forum cost' . '
				';
		} else if ($__templater->method($__vars['package'], 'isResource', array())) {
			$__compilerTemp5 .= '
					' . 'Custom category cost' . '
				';
		}
		$__vars['customItemLabel'] = $__templater->preEscaped('
				' . $__compilerTemp5 . '
			');
		$__finalCompiled .= '
			';
		$__compilerTemp6 = '';
		if ($__templater->method($__vars['package'], 'isKeyword', array())) {
			$__compilerTemp6 .= '
					' . 'This option allows you to set different costs based on the keyword.' . '
				';
		} else if ($__templater->method($__vars['package'], 'isOfType', array(array('sticky', 'thread', ), ))) {
			$__compilerTemp6 .= '
					' . 'This option allows you to set custom costs based on the forum.' . '
				';
		} else if ($__templater->method($__vars['package'], 'isResource', array())) {
			$__compilerTemp6 .= '
					' . 'This option allows you to set different costs based on the category in which the resource will be featured.' . '
				';
		}
		$__vars['customItemExplain'] = $__templater->preEscaped('
				' . $__compilerTemp6 . '
			');
		$__finalCompiled .= '
			';
		$__compilerTemp7 = '';
		if ($__templater->method($__vars['package'], 'isKeyword', array())) {
			$__compilerTemp7 .= '
					' . 'Keyword' . '
				';
		} else if ($__templater->method($__vars['package'], 'isOfType', array(array('sticky', 'thread', ), ))) {
			$__compilerTemp7 .= '
					' . 'Forum ID' . '
				';
		} else if ($__templater->method($__vars['package'], 'isResource', array())) {
			$__compilerTemp7 .= '
					' . 'Category ID' . '
				';
		}
		$__vars['customItemPlaceholder'] = $__templater->preEscaped(trim('
				' . $__compilerTemp7 . '
				'));
		$__finalCompiled .= '
			';
		$__compilerTemp8 = '';
		if ($__templater->isTraversable($__vars['package']['cost_custom'])) {
			foreach ($__vars['package']['cost_custom'] AS $__vars['item'] => $__vars['cost']) {
				$__compilerTemp8 .= '
						<li class="inputGroup">
							' . $__templater->formTextBox(array(
					'name' => 'cost_custom[item][]',
					'value' => $__vars['item'],
					'placeholder' => $__vars['customItemPlaceholder'],
					'autocomplete' => 'off',
					'data-type' => $__vars['package']['type'],
					'data-xf-init' => 'siropu-ads-manager-select-item',
				)) . '
							<span class="inputGroup-splitter"></span>
							' . $__templater->formTextBox(array(
					'name' => 'cost_custom[cost][]',
					'value' => $__vars['cost'],
					'placeholder' => 'Cost',
				)) . '
						</li>
					';
			}
		}
		$__finalCompiled .= $__templater->formRow('
				<ul class="listPlain inputGroup-container">
					' . $__compilerTemp8 . '

					<li class="inputGroup" data-xf-init="field-adder">
						' . $__templater->formTextBox(array(
			'name' => 'cost_custom[item][]',
			'placeholder' => $__vars['customItemPlaceholder'],
			'autocomplete' => 'off',
			'data-type' => $__vars['package']['type'],
			'data-xf-init' => 'siropu-ads-manager-select-item',
		)) . '
						<span class="inputGroup-splitter"></span>
						' . $__templater->formTextBox(array(
			'name' => 'cost_custom[cost][]',
			'placeholder' => 'Cost',
		)) . '
					</li>
				</ul>
			', array(
			'label' => $__templater->escape($__vars['customItemLabel']),
			'explain' => $__templater->escape($__vars['customItemExplain']),
		)) . '
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->method($__vars['package'], 'isThread', array())) {
		$__finalCompiled .= '
			' . $__templater->formTextBoxRow(array(
			'name' => 'cost_sticky',
			'value' => $__vars['package']['cost_sticky'],
		), array(
			'label' => 'Sticky cost',
			'explain' => 'If a value is set, this allows advertisers to sticky their threads in the selected forum.',
		)) . '
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->method($__vars['package'], 'isKeyword', array())) {
		$__finalCompiled .= '
			' . $__templater->formTextBoxRow(array(
			'name' => 'cost_exclusive',
			'value' => $__vars['package']['cost_exclusive'],
		), array(
			'label' => 'Exclusive keyword use cost',
			'explain' => 'If a value is set, this will allow advertisers to opt in for exclusive keyword use. Advertisers that opt in for this option will have the right to use those keywords exclusively.',
		)) . '
		';
	}
	$__finalCompiled .= '

		' . $__templater->formNumberBoxRow(array(
		'name' => 'min_purchase',
		'value' => $__vars['package']['min_purchase'],
		'size' => '5',
		'step' => ($__templater->method($__vars['package'], 'isCpm', array()) ? 1000 : 1),
		'min' => ($__templater->method($__vars['package'], 'isCpm', array()) ? 1000 : 1),
	), array(
		'label' => 'Minimum purchase',
		'explain' => 'Minimum days/weeks/months/years/views/clicks an advertiser can purchase.',
		'rowclass' => 'samMinPurchase',
	)) . '

		' . $__templater->formNumberBoxRow(array(
		'name' => 'max_purchase',
		'value' => $__vars['package']['max_purchase'],
		'size' => '5',
		'step' => ($__templater->method($__vars['package'], 'isCpm', array()) ? 1000 : 1),
		'min' => ($__templater->method($__vars['package'], 'isCpm', array()) ? 1000 : 1),
	), array(
		'label' => 'Maximum purchase',
		'explain' => 'Maximum days/weeks/months/years/views/clicks an advertiser can purchase. If the value is higher that the "Minimum purchase" option, the advertiser can choose how much to purchase.',
		'rowclass' => 'samMaxPurchase',
	)) . '

		';
	$__compilerTemp9 = '';
	if ($__templater->isTraversable($__vars['package']['discount'])) {
		foreach ($__vars['package']['discount'] AS $__vars['purchase'] => $__vars['discount']) {
			$__compilerTemp9 .= '
					<li class="inputGroup">
						' . $__templater->formTextBox(array(
				'name' => 'discount[purchase][]',
				'value' => $__vars['purchase'],
				'placeholder' => 'Purchase',
			)) . '
						<span class="inputGroup-splitter"></span>
						' . $__templater->formTextBox(array(
				'name' => 'discount[discount][]',
				'value' => $__vars['discount'],
				'placeholder' => 'Discount',
			)) . '
					</li>
				';
		}
	}
	$__finalCompiled .= $__templater->formRow('
			<ul class="listPlain inputGroup-container">
				' . $__compilerTemp9 . '

				<li class="inputGroup" data-xf-init="field-adder">
					' . $__templater->formTextBox(array(
		'name' => 'discount[purchase][]',
		'placeholder' => 'Purchase length',
	)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->formTextBox(array(
		'name' => 'discount[discount][]',
		'placeholder' => 'Discount percentage',
	)) . '
				</li>
			</ul>
		', array(
		'label' => 'Discounts',
		'explain' => 'This option allows you to set discounts based on the purchase length.',
		'rowclass' => 'samDiscounts',
	)) . '

		<hr class="formRowSep" />

		' . $__templater->formTextAreaRow(array(
		'name' => 'description',
		'value' => $__vars['package']['description'],
		'rows' => '3',
	), array(
		'label' => 'Package description',
		'explain' => 'Provide information that you might want advertisers to know about this advertising option.',
	)) . '
		' . $__templater->formTextAreaRow(array(
		'name' => 'guidelines',
		'value' => $__vars['package']['guidelines'],
		'rows' => '3',
	), array(
		'label' => 'Guidelines',
		'explain' => 'Set guidelines for advertisers.',
	)) . '

		' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png,.webp',
	), array(
		'label' => 'Preview image',
		'explain' => 'Upload a screenshot of the place where the ads will be displayed on the page.',
	)) . '

		';
	if (!$__templater->test($__vars['package']['preview'], 'empty', array())) {
		$__finalCompiled .= '
			' . $__templater->formRow('
				<img src="' . $__templater->escape($__templater->method($__vars['package'], 'getAbsoluteFilePath', array($__vars['package']['preview'], ))) . '">
				' . $__templater->formCheckBox(array(
		), array(array(
			'name' => 'delete_preview',
			'value' => '1',
			'label' => 'Delete preview image',
			'_type' => 'option',
		))) . '
			', array(
			'label' => 'Current image',
		)) . '
		';
	}
	$__finalCompiled .= '

		<hr class="formRowSep" />

		';
	$__vars['advertiserCriteriaData'] = $__templater->method($__vars['advertiserCriteria'], 'getCriteriaForTemplate', array());
	$__finalCompiled .= '

		';
	$__compilerTemp10 = $__templater->mergeChoiceOptions(array(), $__templater->arrayKey($__templater->method($__vars['advertiserCriteria'], 'getExtraTemplateData', array()), 'userGroups'));
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'advertiser_criteria[user_groups][rule]',
		'value' => 'user_groups',
		'selected' => $__vars['advertiserCriteriaData']['user_groups'],
		'label' => 'Enable package for advertisers',
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'advertiser_criteria[user_groups][data][user_group_ids]',
		'size' => '4',
		'multiple' => 'true',
		'value' => $__vars['advertiserCriteriaData']['user_groups']['user_group_ids'],
	), $__compilerTemp10)),
		'_type' => 'option',
	)), array(
		'explain' => 'If a user group is selected, the package will be available only for that group. Else, it will be available for all user groups.',
	)) . '

		';
	$__compilerTemp11 = $__templater->mergeChoiceOptions(array(), $__vars['advertiserUserGroups']);
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'advertiser_user_groups',
		'multiple' => 'true',
		'value' => $__vars['package']['advertiser_user_groups'],
	), $__compilerTemp11, array(
		'label' => 'Add advertiser to user groups',
		'explain' => 'This option allows you to add advertisers to custom user groups.',
	)) . '

		' . $__templater->formNumberBoxRow(array(
		'name' => 'advertiser_purchase_limit',
		'value' => $__vars['package']['advertiser_purchase_limit'],
		'min' => '0',
	), array(
		'label' => 'Advertiser purchase limit',
		'explain' => 'This option allows you to set a limit on how many active ads an advertiser can have.',
	)) . '

		';
	if ($__templater->method($__vars['package'], 'isEmbeddable', array())) {
		$__finalCompiled .= '
			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'enable_placeholder',
			'value' => '1',
			'selected' => $__vars['package']['placeholder_id'],
			'label' => 'Enable placeholder',
			'data-hide' => 'true',
			'_dependent' => array('
						' . $__templater->formCheckBox(array(
		), array(array(
			'name' => 'settings[use_backup_ad]',
			'value' => '1',
			'selected' => $__vars['package']['settings']['use_backup_ad'],
			'label' => 'Use placeholder as backup ad (Can be edited from ad list)',
			'_type' => 'option',
		))) . '
					'),
			'_type' => 'option',
		)), array(
			'explain' => 'If enabled, this option will add an "Advertise here" placeholder when there are no ads, to attract advertisers.',
		)) . '
		';
	}
	$__finalCompiled .= '

		';
	if (!$__templater->method($__vars['package'], 'isOfType', array(array('keyword', 'resource', 'popup', 'background', ), ))) {
		$__finalCompiled .= '
			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'advertise_here',
			'value' => '1',
			'selected' => $__vars['package']['advertise_here'],
			'label' => 'Enable "Advertise here" link',
			'_type' => 'option',
		)), array(
			'explain' => 'If enabled, this option will add an "Advertise here" link under the ad unit if there are ad slots available, to attract more advertisers.',
		)) . '
		';
	}
	$__finalCompiled .= '

		<hr class="formRowSep" />

		' . $__templater->formNumberBoxRow(array(
		'name' => 'display_order',
		'value' => $__vars['package']['display_order'],
		'size' => '5',
		'min' => '0',
	), array(
		'label' => 'Display order',
		'explain' => 'Display order for advertisers in package list.',
	)) . '

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'settings[no_approval]',
		'value' => '1',
		'selected' => $__vars['package']['settings']['no_approval'],
		'label' => 'Ads do not require approval',
		'_type' => 'option',
	)), array(
		'explain' => 'If enabled, ads created in this package won\'t require admin approval.',
	)) . '
	</li>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['package'], 'isInsert', array())) {
		$__compilerTemp1 .= '
		';
		if ($__templater->method($__vars['package'], 'isCode', array())) {
			$__compilerTemp1 .= '
			' . 'Create code package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isBanner', array())) {
			$__compilerTemp1 .= '
			' . 'Create banner package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isText', array())) {
			$__compilerTemp1 .= '
			' . 'Create text package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isLink', array())) {
			$__compilerTemp1 .= '
			' . 'Create link package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isKeyword', array())) {
			$__compilerTemp1 .= '
			' . 'Create keyword pacakge' . '
		';
		} else if ($__templater->method($__vars['package'], 'isThread', array())) {
			$__compilerTemp1 .= '
			' . 'Create promo thread package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isSticky', array())) {
			$__compilerTemp1 .= '
			' . 'Create sticky thread package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isAffiliate', array())) {
			$__compilerTemp1 .= '
			' . 'Create affiliate link package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isResource', array())) {
			$__compilerTemp1 .= '
			' . 'Create featured resource package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isPopup', array())) {
			$__compilerTemp1 .= '
			' . 'Create popup package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isBackground', array())) {
			$__compilerTemp1 .= '
			' . 'Create background package' . '
		';
		} else if ($__templater->method($__vars['package'], 'isCustom', array())) {
			$__compilerTemp1 .= '
			' . 'Create custom service package' . '
		';
		}
		$__compilerTemp1 .= '
	';
	} else {
		$__compilerTemp1 .= '
		' . 'Edit package' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['package']['title']) . '
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
	if ($__templater->method($__vars['package'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/packages/delete', $__vars['package'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['package'], 'isThread', array()) AND $__templater->test($__vars['xf']['options']['siropuAdsManagerPromoThreadForums'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--warning blockMessage--iconic">
		' . 'In order to allow advertisers to create promo thread ads, you have to set the forum(s) from "<a href="' . $__templater->func('link', array('options/groups/siropuAdsManagerAdvertiser/', ), true) . '#siropuAdsManagerPromoThreadForums">Promo thread forums</a>" option in <a href="' . $__templater->func('link', array('options/groups/siropuAdsManagerAdvertiser/', ), true) . '">Ads Manager [Advertiser]</a> admin options.' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['package'], 'isSticky', array()) AND $__templater->test($__vars['xf']['options']['siropuAdsManagerAllowedStickyForums'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--warning blockMessage--iconic">
		' . 'In order to allow advertisers to create sticky thread ads, you have to select at least one forum for "<a href="' . $__templater->func('link', array('options/groups/siropuAdsManagerAdvertiser/', ), true) . '#siropuAdsManagerAllowedStickyForums">Allowed sticky forums</a>" option in <a href="' . $__templater->func('link', array('options/groups/siropuAdsManagerAdvertiser/', ), true) . '">Ads Manager [Advertiser]</a> admin options.' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['package'], 'isResource', array()) AND $__templater->test($__vars['xf']['options']['siropuAdsManagerAllowedFeaturedResourceCategories'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--warning blockMessage--iconic">
		' . 'In order to allow advertisers to create featured resource ads, you have to select at least one category for "<a href="' . $__templater->func('link', array('options/groups/siropuAdsManagerAdvertiser/', ), true) . '#siropuAdsManagerAllowedFeaturedResourceCategories">Allowed featured resource categories</a>" option in <a href="' . $__templater->func('link', array('options/groups/siropuAdsManagerAdvertiser/', ), true) . '">Ads Manager [Advertiser]</a> admin options.' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp2 = '';
	if (!$__templater->method($__vars['package'], 'hasNoCriteria', array())) {
		$__compilerTemp2 .= '
					<a class="tabs-tab" role="tab" tabindex="0" aria-controls="settings">' . 'Settings' . '</a>
					' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'position_tabs', array(), $__vars) . '
					' . $__templater->callMacro('helper_criteria', 'user_tabs', array(), $__vars) . '
					' . $__templater->callMacro('helper_criteria', 'page_tabs', array(), $__vars) . '
					' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'device_tabs', array(), $__vars) . '
					' . $__templater->callMacro('public:siropu_ads_manager_helper_criteria', 'geo_tabs', array(), $__vars) . '
				';
	}
	$__compilerTemp3 = '';
	if (!$__templater->method($__vars['package'], 'isAffiliate', array())) {
		$__compilerTemp3 .= '
					<a class="tabs-tab" role="tab" tabindex="0" aria-controls="advertising">' . 'Advertising' . '</a>
				';
	}
	$__compilerTemp4 = '';
	if (!$__templater->method($__vars['package'], 'hasNoCriteria', array())) {
		$__compilerTemp4 .= '
				<li role="tabpanel" id="settings">
					';
		if ($__templater->method($__vars['package'], 'isEmbeddable', array())) {
			$__compilerTemp4 .= '
						' . $__templater->formSelectRow(array(
				'name' => 'settings[display]',
				'value' => $__vars['package']['settings']['display'],
			), array(array(
				'value' => 'block',
				'label' => 'Block',
				'_type' => 'option',
			),
			array(
				'value' => 'iblock',
				'label' => 'Inline block',
				'_type' => 'option',
			),
			array(
				'value' => 'inline',
				'label' => 'Inline',
				'_type' => 'option',
			),
			array(
				'value' => 'flexbox',
				'label' => 'Flexbox',
				'_type' => 'option',
			)), array(
				'label' => 'Display',
				'explain' => 'Choose how to display the ads.',
			)) . '

						' . $__templater->formSelectRow(array(
				'name' => 'settings[unit_alignment]',
				'value' => $__vars['package']['settings']['unit_alignment'],
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
				'label' => 'Unit alignment',
				'explain' => 'Choose how to align the ads when displayed.',
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
				'value' => $__vars['package']['settings']['unit_size'],
			), $__compilerTemp5, array(
				'label' => 'Unit size',
				'explain' => 'This option allows you set a custom width and height for the ad unit container.',
			)) . '

						';
			if (!$__templater->method($__vars['package'], 'isKeyword', array())) {
				$__compilerTemp4 .= '
							' . $__templater->formTextBoxRow(array(
					'name' => 'settings[unit_style]',
					'value' => $__vars['package']['settings']['unit_style'],
				), array(
					'label' => 'Unit style',
					'explain' => 'This option allows you to style the ad unit container using CSS.<br>
<p>Example:</p>
<code><span style="border: 1px solid gray;">border: 1px solid gray;</span> <span style="background: lightgray;">background: lightgray;</span> padding: 10px;</code>',
				)) . '
							
							' . $__templater->formTextBoxRow(array(
					'name' => 'settings[css_class]',
					'value' => $__vars['package']['settings']['css_class'],
				), array(
					'label' => 'CSS class',
					'explain' => 'This option allows you to set a custom CSS class.',
				)) . '
						';
			}
			$__compilerTemp4 .= '

						<hr class="formRowSep" />

						' . $__templater->formSelectRow(array(
				'name' => 'ad_display_order',
				'value' => $__vars['package']['ad_display_order'],
			), array(array(
				'value' => 'random',
				'label' => 'Random',
				'_type' => 'option',
			),
			array(
				'value' => 'dateAsc',
				'label' => 'Ascending by ad creation date',
				'_type' => 'option',
			),
			array(
				'value' => 'dateDesc',
				'label' => 'Descending by ad creation date',
				'_type' => 'option',
			),
			array(
				'value' => 'orderAsc',
				'label' => 'Ascending by ad display order',
				'_type' => 'option',
			),
			array(
				'value' => 'orderDesc',
				'label' => 'Descending by ad display order',
				'_type' => 'option',
			),
			array(
				'value' => 'viewAsc',
				'label' => 'Ascending by ad view count',
				'_type' => 'option',
			),
			array(
				'value' => 'viewDesc',
				'label' => 'Descending by ad view count',
				'_type' => 'option',
			),
			array(
				'value' => 'clickAsc',
				'label' => 'Ascending by ad click count',
				'_type' => 'option',
			),
			array(
				'value' => 'clickDesc',
				'label' => 'Descending by ad click count',
				'_type' => 'option',
			),
			array(
				'value' => 'ctrAsc',
				'label' => 'Ascending by ad CTR (click-through rate)',
				'_type' => 'option',
			),
			array(
				'value' => 'ctrDesc',
				'label' => 'Descending by ad CTR (click-through rate)',
				'_type' => 'option',
			)), array(
				'label' => 'Ad display order',
				'explain' => 'Choose how to order the ads when displayed.',
			)) . '

						' . $__templater->formNumberBoxRow(array(
				'name' => 'ad_display_limit',
				'value' => $__vars['package']['ad_display_limit'],
				'size' => '5',
				'min' => '1',
			), array(
				'label' => 'Ad display limit',
				'explain' => 'The maximum number of ads to display at the same time.',
			)) . '

						<hr class="formRowSep" />

						';
			$__vars['carouselDevice'] = $__templater->method($__vars['package'], 'getCarouselSetting', array('device', array('desktop' => 1, 'tablet' => 1, 'mobile' => 1, ), ));
			$__compilerTemp8 = '';
			if (!$__templater->test($__vars['package']['settings']['carousel']['breakpoints'], 'empty', array())) {
				$__compilerTemp8 .= '
														';
				$__vars['breakpoints'] = $__vars['package']['settings']['carousel']['breakpoints'];
				$__compilerTemp8 .= '
														';
				$__vars['counter'] = 0;
				if ($__templater->isTraversable($__vars['breakpoints'])) {
					foreach ($__vars['breakpoints'] AS $__vars['key'] => $__vars['value']) {
						$__vars['counter']++;
						$__compilerTemp8 .= '
															<li class="inputGroup">
																' . $__templater->formTextBox(array(
							'name' => 'settings[carousel][breakpoints][' . $__vars['counter'] . '][width]',
							'value' => $__vars['key'],
							'placeholder' => 'Screen width',
							'size' => '20',
						)) . '
																<span class="inputGroup-splitter"></span>
																' . $__templater->formTextBox(array(
							'name' => 'settings[carousel][breakpoints][' . $__vars['counter'] . '][ads]',
							'value' => $__vars['value'],
							'placeholder' => 'Ads to show',
							'size' => '20',
						)) . '
															</li>
														';
					}
				}
				$__compilerTemp8 .= '
													';
			}
			$__compilerTemp4 .= $__templater->formRow('
							' . $__templater->formCheckBox(array(
			), array(array(
				'name' => 'settings[carousel][enabled]',
				'value' => '1',
				'selected' => $__templater->method($__vars['package'], 'getCarouselSetting', array('enabled', )),
				'label' => 'Enable carousel',
				'data-hide' => 'true',
				'hint' => 'This option allows you to rotate multiple ads in a carousel.',
				'_dependent' => array('
										' . $__templater->formCheckBox(array(
			), array(array(
				'name' => 'settings[carousel][arrows]',
				'value' => '1',
				'selected' => $__templater->method($__vars['package'], 'getCarouselSetting', array('arrows', )),
				'label' => 'Enable navigation arrows',
				'hint' => 'If enabled, this will add navigation arrows before and after the carousel to manually scroll through ads.',
				'_type' => 'option',
			),
			array(
				'name' => 'settings[carousel][bullets]',
				'value' => '1',
				'selected' => $__templater->method($__vars['package'], 'getCarouselSetting', array('bullets', )),
				'label' => 'Enable navigation bullets',
				'hint' => 'If enabled, this will add navigation bullets beneath the carousel to manually scroll through ads.',
				'_type' => 'option',
			))) . '
										
										<dl class="inputLabelPair">
											<dt><label for="carouselItemsPerView">' . 'Ads to show' . '</label></dt>
											<dd>' . $__templater->formNumberBox(array(
				'name' => 'settings[carousel][itemsPerView]',
				'value' => $__templater->method($__vars['package'], 'getCarouselSetting', array('itemsPerView', 1, )),
				'id' => 'carouselItemsPerView',
				'min' => '1',
			)) . '</dd>
										</dl>
										<dl class="inputLabelPair">
											<dt><label for="carouselItemPerColumn">' . 'Ads per row' . '</label></dt>
											<dd>' . $__templater->formNumberBox(array(
				'name' => 'settings[carousel][itemsPerColumn]',
				'value' => $__templater->method($__vars['package'], 'getCarouselSetting', array('itemsPerColumn', 1, )),
				'id' => 'carouselItemPerColumn',
				'min' => '1',
			)) . '</dd>
										</dl>
										<dl class="inputLabelPair">
											<dt><label for="carouselslidesPerGroup">' . 'Ads to scroll' . '</label></dt>
											<dd>' . $__templater->formNumberBox(array(
				'name' => 'settings[carousel][itemsPerGroup]',
				'value' => $__templater->method($__vars['package'], 'getCarouselSetting', array('itemsPerGroup', 1, )),
				'id' => 'carouselItemsPerGroup',
				'min' => '1',
			)) . '</dd>
										</dl>
										<dl class="inputLabelPair">
											<dt><label for="carouselAutoplaySpeed">' . 'Seconds between rotations' . '</label></dt>
											<dd>' . $__templater->formNumberBox(array(
				'name' => 'settings[carousel][autoplaySpeed]',
				'value' => $__templater->method($__vars['package'], 'getCarouselSetting', array('autoplaySpeed', 3, )),
				'id' => 'carouselAutoplaySpeed',
				'step' => '1',
				'min' => '1',
			)) . '</dd>
										</dl>
										<dl class="inputLabelPair">
											<dt><label for="carouselTransitionSpeed">' . 'Transition speed (miliseconds)' . '</label></dt>
											<dd>' . $__templater->formNumberBox(array(
				'name' => 'settings[carousel][transitionSpeed]',
				'value' => $__templater->method($__vars['package'], 'getCarouselSetting', array('transitionSpeed', 300, )),
				'id' => 'carouselTransitionSpeed',
				'step' => '100',
				'min' => '100',
			)) . '</dd>
										</dl>
										<dl class="inputLabelPair">
											<dt><label for="carouselEffect">' . 'Transition effect' . '</label></dt>
											<dd>
												' . $__templater->formSelect(array(
				'name' => 'settings[carousel][effect]',
				'value' => $__templater->method($__vars['package'], 'getCarouselSetting', array('effect', )),
			), array(array(
				'value' => 'slide',
				'label' => 'Slide',
				'_type' => 'option',
			),
			array(
				'value' => 'fade',
				'label' => 'Fade',
				'_type' => 'option',
			),
			array(
				'value' => 'cube',
				'label' => 'Cube',
				'_type' => 'option',
			),
			array(
				'value' => 'coverflow',
				'label' => 'Coverflow',
				'_type' => 'option',
			),
			array(
				'value' => 'flip',
				'label' => 'Flip',
				'_type' => 'option',
			))) . '
											</dd>
										</dl>
										<dl class="inputLabelPair">
											<dt><label for="carouselDirection">' . 'Direction' . '</label></dt>
											<dd>
												' . $__templater->formSelect(array(
				'name' => 'settings[carousel][direction]',
				'value' => $__templater->method($__vars['package'], 'getCarouselSetting', array('direction', )),
			), array(array(
				'value' => 'horizontal',
				'label' => 'Horizontal',
				'_type' => 'option',
			),
			array(
				'value' => 'vertical',
				'label' => 'Vertical',
				'_type' => 'option',
			))) . '
											</dd>
										</dl>
										' . '' . '
										<dl class="inputLabelPair">
											<dt><label>' . 'Enable carousel if device is' . '</label></dt>
											<dd style="text-align: left;">
												' . $__templater->formCheckBox(array(
			), array(array(
				'name' => 'settings[carousel][device][desktop]',
				'value' => '1',
				'selected' => $__vars['carouselDevice']['desktop'],
				'label' => 'Desktop',
				'_type' => 'option',
			),
			array(
				'name' => 'settings[carousel][device][tablet]',
				'value' => '1',
				'selected' => $__vars['carouselDevice']['tablet'],
				'label' => 'Tablet',
				'_type' => 'option',
			),
			array(
				'name' => 'settings[carousel][device][mobile]',
				'value' => '1',
				'selected' => $__vars['carouselDevice']['mobile'],
				'label' => 'Mobile phone',
				'_type' => 'option',
			))) . '
											</dd>
										</dl>
										<dl class="inputLabelPair">
											<dt><label>' . 'Responsive breakpoints' . '</label></dt>
											<dd>
												<ul class="listPlain inputGroup-container">
													' . $__compilerTemp8 . '
													<li class="inputGroup" data-xf-init="field-adder" data-increment-format="settings[carousel][breakpoints][{counter}]">
														' . $__templater->formTextBox(array(
				'name' => 'settings[carousel][breakpoints][' . $__templater->method($__vars['package'], 'getNextBreakpointCounter', array()) . '][width]',
				'placeholder' => 'Screen width',
				'size' => '20',
			)) . '
														<span class="inputGroup-splitter"></span>
														' . $__templater->formTextBox(array(
				'name' => 'settings[carousel][breakpoints][' . $__templater->method($__vars['package'], 'getNextBreakpointCounter', array()) . '][ads]',
				'placeholder' => 'Ads to show',
				'size' => '20',
			)) . '
													</li>
												</ul>
											</dd>
										</dl>
									'),
				'_type' => 'option',
			))) . '
						', array(
			)) . '

						<hr class="formRowSep" />
					';
		}
		$__compilerTemp4 .= '

					';
		$__vars['viewCountMethod'] = $__vars['xf']['options']['siropuAdsManagerViewCountMethod'];
		$__compilerTemp4 .= '

					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[count_views]',
			'value' => '1',
			'selected' => $__vars['package']['settings']['count_views'],
			'label' => (($__vars['viewCountMethod'] == 'view') ? 'Count views' : 'Count impressions'),
			'_dependent' => array($__templater->formNumberBox(array(
			'name' => 'settings[view_limit]',
			'value' => $__vars['package']['settings']['view_limit'],
			'units' => (($__vars['viewCountMethod'] == 'view') ? 'View limit' : 'Impression limit'),
			'size' => '5',
			'min' => '0',
		))),
			'_type' => 'option',
		),
		array(
			'name' => 'settings[count_clicks]',
			'value' => '1',
			'selected' => $__vars['package']['settings']['count_clicks'],
			'label' => 'Count clicks',
			'_dependent' => array($__templater->formNumberBox(array(
			'name' => 'settings[click_limit]',
			'value' => $__vars['package']['settings']['click_limit'],
			'units' => 'Click limit',
			'size' => '5',
			'min' => '0',
		))),
			'_type' => 'option',
		)), array(
			'explain' => 'Please note that limit only affects the ads created from the admin control panel.',
		)) . '

					<hr class="formRowSep" />

					' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[daily_stats]',
			'value' => '1',
			'selected' => $__vars['package']['settings']['daily_stats'],
			'label' => 'Daily statistics',
			'_type' => 'option',
		),
		array(
			'name' => 'settings[click_stats]',
			'value' => '1',
			'selected' => $__vars['package']['settings']['click_stats'],
			'label' => 'Click statistics',
			'_type' => 'option',
		),
		array(
			'name' => 'settings[ga_stats]',
			'value' => '1',
			'selected' => $__vars['package']['settings']['ga_stats'],
			'label' => 'Google Analytics statistics' . ' <a href="' . $__templater->func('link', array('ads-manager/help/google-analytics', ), true) . '" title="' . $__templater->filter('What\'s this?', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" data-xf-click="overlay"><i class="fa fa-question-circle" aria-hidden="true"></i></a>',
			'_type' => 'option',
		)), array(
			'label' => 'Enable statistics',
		)) . '

					<hr class="formRowSep" />

					' . $__templater->formRadioRow(array(
			'name' => 'settings[rel]',
			'value' => ($__vars['package']['settings']['rel'] ?: 'nofollow'),
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
			'value' => $__vars['package']['settings']['rel_custom'],
		)) . '
							'),
			'_type' => 'option',
		)), array(
			'label' => 'Rel attribute',
		)) . '

					<hr class="formRowSep" />
					
					';
		$__compilerTemp9 = array(array(
			'name' => 'settings[target_blank]',
			'value' => '1',
			'selected' => ($__templater->method($__vars['package'], 'isInsert', array()) ? 1 : $__vars['package']['settings']['target_blank']),
			'label' => 'Open in a new tab',
			'_type' => 'option',
		));
		if (!$__templater->method($__vars['package'], 'isKeyword', array())) {
			$__compilerTemp9[] = array(
				'name' => 'settings[hide_from_robots]',
				'value' => '1',
				'selected' => $__vars['package']['settings']['hide_from_robots'],
				'label' => 'Hide from robots',
				'_type' => 'option',
			);
		}
		$__compilerTemp4 .= $__templater->formCheckBoxRow(array(
		), $__compilerTemp9, array(
		)) . '

					<hr class="formRowSep" />

					';
		if ($__templater->method($__vars['package'], 'isOfType', array(array('keyword', 'affiliate', ), ))) {
			$__compilerTemp4 .= '
						';
			$__compilerTemp10 = array(array(
				'name' => 'settings[post_type][thread]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['package'], 'isInsert', array()) ? 1 : $__vars['package']['settings']['post_type']['thread']),
				'label' => 'Discussion threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_poll]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['package'], 'isInsert', array()) ? 1 : $__vars['package']['settings']['post_type']['thread_poll']),
				'label' => 'Poll threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_article]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['package'], 'isInsert', array()) ? 1 : $__vars['package']['settings']['post_type']['thread_article']),
				'label' => 'Article threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_question]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['package'], 'isInsert', array()) ? 1 : $__vars['package']['settings']['post_type']['thread_question']),
				'label' => 'Question threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][thread_suggestion]',
				'value' => '1',
				'selected' => ($__templater->method($__vars['package'], 'isInsert', array()) ? 1 : $__vars['package']['settings']['post_type']['thread_suggestion']),
				'label' => 'Suggestion threads',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][conversation]',
				'value' => '1',
				'selected' => $__vars['package']['settings']['post_type']['conversation'],
				'label' => 'Conversation messages',
				'_type' => 'option',
			)
,array(
				'name' => 'settings[post_type][profile]',
				'value' => '1',
				'selected' => $__vars['package']['settings']['post_type']['profile'],
				'label' => 'Profile posts',
				'_type' => 'option',
			));
			if ($__templater->func('is_addon_active', array('XFRM', ), false)) {
				$__compilerTemp10[] = array(
					'name' => 'settings[post_type][resource]',
					'value' => '1',
					'selected' => $__vars['package']['settings']['post_type']['resource'],
					'label' => 'Resource description',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('Siropu/Chat', ), false)) {
				$__compilerTemp10[] = array(
					'name' => 'settings[post_type][chat]',
					'value' => '1',
					'selected' => $__vars['package']['settings']['post_type']['chat'],
					'label' => 'Chat room messages',
					'_type' => 'option',
				);
				$__compilerTemp10[] = array(
					'name' => 'settings[post_type][chat_conv]',
					'value' => '1',
					'selected' => $__vars['package']['settings']['post_type']['chat_conv'],
					'label' => 'Chat conversation messages',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('XenAddons/AMS', ), false)) {
				$__compilerTemp10[] = array(
					'name' => 'settings[post_type][ams_article]',
					'value' => '1',
					'selected' => $__vars['package']['settings']['post_type']['ams_article'],
					'label' => 'AMS articles',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('XenAddons/Showcase', ), false)) {
				$__compilerTemp10[] = array(
					'name' => 'settings[post_type][showcase_item]',
					'value' => '1',
					'selected' => $__vars['package']['settings']['post_type']['showcase_item'],
					'label' => 'Showcase item',
					'_type' => 'option',
				);
			}
			if ($__templater->func('is_addon_active', array('DBTech/eCommerce', ), false)) {
				$__compilerTemp10[] = array(
					'name' => 'settings[post_type][dbtech_product_desc]',
					'value' => '1',
					'selected' => $__vars['package']['settings']['post_type']['dbtech_product_desc'],
					'label' => 'DBTech eCommerce product description',
					'_type' => 'option',
				);
				$__compilerTemp10[] = array(
					'name' => 'settings[post_type][dbtech_product_spec]',
					'value' => '1',
					'selected' => $__vars['package']['settings']['post_type']['dbtech_product_spec'],
					'label' => 'DBTech eCommerce product specifications',
					'_type' => 'option',
				);
			}
			$__compilerTemp4 .= $__templater->formCheckBoxRow(array(
			), $__compilerTemp10, array(
				'label' => 'Enable in',
			)) . '

						';
			if ($__templater->method($__vars['package'], 'isKeyword', array())) {
				$__compilerTemp4 .= '
							' . $__templater->formNumberBoxRow(array(
					'name' => 'settings[keyword_limit]',
					'value' => $__vars['package']['settings']['keyword_limit'],
					'size' => '5',
					'min' => '0',
				), array(
					'label' => 'Keyword post replace limit',
					'explain' => 'The maximum number of keywords in a post that can be turned into ads. Set to 0 for unlimited.',
				)) . '
							' . $__templater->formNumberBoxRow(array(
					'name' => 'settings[keyword_page_limit]',
					'value' => $__vars['package']['settings']['keyword_page_limit'],
					'size' => '5',
					'min' => '0',
				), array(
					'label' => 'Keyword page replace limit',
					'explain' => 'The maximum number of keywords in a page that can be turned into ads. Set to 0 for unlimited.',
				)) . '
						';
			}
			$__compilerTemp4 .= '
					';
		} else {
			$__compilerTemp4 .= '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'settings[display_after]',
				'value' => $__vars['package']['settings']['display_after'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Display after x seconds',
				'explain' => 'If set, the ads will be displayed with a delay of x seconds.',
			)) . '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'settings[hide_after]',
				'value' => $__vars['package']['settings']['hide_after'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Hide after x seconds',
				'explain' => 'If set, the ads will be hidden after x seconds of display.',
			)) . '
						' . $__templater->formNumberBoxRow(array(
				'name' => 'settings[display_frequency]',
				'value' => $__vars['package']['settings']['display_frequency'],
				'size' => '5',
				'min' => '0',
			), array(
				'label' => 'Display every x minutes',
				'explain' => 'If set, a user will be able to view the ad every x minutes.',
				'hint' => 'Frequency cap',
			)) . '
					';
		}
		$__compilerTemp4 .= '

					';
		if ($__templater->method($__vars['package'], 'isPopup', array())) {
			$__compilerTemp4 .= '
						' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'settings[hide_close_button]',
				'value' => '1',
				'selected' => $__vars['package']['settings']['hide_close_button'],
				'label' => 'Disable overlay close button',
				'_type' => 'option',
			)), array(
			)) . '
					';
		}
		$__compilerTemp4 .= '

					<hr class="formRowSep" />

					';
		if ($__templater->method($__vars['package'], 'isEmbeddable', array())) {
			$__compilerTemp4 .= '
						' . $__templater->formTextAreaRow(array(
				'name' => 'content',
				'value' => $__vars['package']['content'],
			), array(
				'label' => 'Unit content',
				'explain' => 'This option allows you to add content below the ad unit. You may use HTML.',
			)) . '
					';
		}
		$__compilerTemp4 .= '
					
					';
		if ($__templater->method($__vars['package'], 'isOfType', array(array('code', 'banner', ), ))) {
			$__compilerTemp4 .= '
						<hr class="formRowSep" />
						';
			$__templater->inlineCss('
							.samPostLayout
							{
							display: none;
							}
							.samPostLayout input[type="text"]
							{
							margin-bottom: 5px;
							}
						');
			$__compilerTemp4 .= '
						' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'settings[xf_post_layout][enabled]',
				'value' => '1',
				'selected' => $__templater->method($__vars['package'], 'getPostLayoutSetting', array('enabled', )),
				'label' => 'Display in post layout',
				'data-hide' => 'true',
				'_dependent' => array('
									' . $__templater->formTextBox(array(
				'placeholder' => 'Post author avatar URL',
				'name' => 'settings[xf_post_layout][avatar]',
				'value' => $__templater->method($__vars['package'], 'getPostLayoutSetting', array('avatar', '', )),
			)) . '
									' . $__templater->formTextBox(array(
				'placeholder' => 'Post author username',
				'name' => 'settings[xf_post_layout][username]',
				'value' => $__templater->method($__vars['package'], 'getPostLayoutSetting', array('username', '', )),
			)) . '
									' . $__templater->formTextBox(array(
				'placeholder' => 'Post author title',
				'name' => 'settings[xf_post_layout][title]',
				'value' => $__templater->method($__vars['package'], 'getPostLayoutSetting', array('title', '', )),
			)) . '
								'),
				'_type' => 'option',
			)), array(
				'explain' => 'This option allow you to display ads in the XenForo\'s post layout.',
				'rowclass' => 'samPostLayout',
			)) . '
					';
		}
		$__compilerTemp4 .= '
				</li>

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
	$__compilerTemp11 = '';
	if (!$__templater->method($__vars['package'], 'isAffiliate', array())) {
		$__compilerTemp11 .= '
				' . $__templater->callMacro(null, 'advertising_pane', array(
			'package' => $__vars['package'],
			'advertiserCriteria' => $__vars['advertiserCriteria'],
			'advertiserUserGroups' => $__vars['advertiserUserGroups'],
		), $__vars) . '
			';
	}
	$__compilerTemp12 = '';
	if ($__templater->method($__vars['package'], 'isInsert', array())) {
		$__compilerTemp12 .= '
			' . $__templater->formHiddenVal('type', $__vars['package']['type'], array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
			<span class="hScroller-scroll">
				<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="basicInformation">' . 'Basic information' . '</a>
				' . $__compilerTemp2 . '
				' . $__compilerTemp3 . '
			</span>
		</h2>

		<ul class="tabPanes block-body">
			' . $__templater->callMacro(null, 'basic_info_pane', array(
		'package' => $__vars['package'],
	), $__vars) . '

			' . $__compilerTemp4 . '

			' . $__compilerTemp11 . '
		</ul>
		' . $__compilerTemp12 . '
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/packages/save', $__vars['package'], array('redirect' => $__vars['redirect'], ), ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
	)) . '

' . '

';
	return $__finalCompiled;
}
);