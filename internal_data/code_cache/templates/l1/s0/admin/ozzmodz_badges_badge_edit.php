<?php
// FROM HASH: 912b3f07df85bd082304bcd97d561329
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['badge'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add badge');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit badge' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['badge']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->includeCss('ozzmodz_badges.less');
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['badge'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ozzmodz-badges/delete', $__vars['badge'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => 'fa',
		'label' => 'Font Awesome icon',
		'data-hide' => 'true',
		'_dependent' => array('
							' . $__templater->formTextBox(array(
		'name' => 'fa_icon',
		'value' => $__vars['badge']['fa_icon'],
		'fa' => $__vars['badge']['fa_icon'],
	)) . '
							<dfn class="inputChoices-explain">' . 'Font Awesome icon code. For example: <code>fa-comments</code> or <code>fas fa-adjust</code>. <a href="https://fontawesome.com/v5/search" target="_blank">List of icon codes</a>.' . '</dfn>
						'),
		'_type' => 'option',
	));
	if ($__vars['xf']['options']['ozzmodz_badges_mdiSource'] != 'disabled') {
		$__compilerTemp1[] = array(
			'value' => 'mdi',
			'label' => 'Material Design Icon',
			'data-hide' => 'true',
			'_dependent' => array('
								' . $__templater->formTextBox(array(
			'name' => 'mdi_icon',
			'value' => $__vars['badge']['mdi_icon'],
		)) . '
								<dfn class="inputChoices-explain">' . 'Material Design Icon code. For example: <code>mdi-cheese</code> or <code>mdi-car-light-alert</code>. <a href="https://pictogrammers.github.io/@mdi/font/6.5.95/" target="_blank">List of icon codes</a>.' . '</dfn>
							'),
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'value' => 'html',
		'label' => 'HTML code icon',
		'data-hide' => 'true',
		'_dependent' => array('
							' . $__templater->formCodeEditor(array(
		'name' => 'html_icon',
		'value' => $__vars['badge']['html_icon'],
		'mode' => 'html',
		'class' => 'codeEditor--short',
	)) . '
							<dfn class="inputChoices-explain">' . 'Enter the HTML code for your badge. When using SVG or BASE64, please note that this code is not cached in the browser and increases the page size.' . '</dfn>
						'),
		'_type' => 'option',
	);
	$__compilerTemp2 = '';
	if ($__vars['badge']['image_url']) {
		$__compilerTemp2 .= '
											<th>
												<img class="image-icon-preview yellow" src="' . $__templater->escape($__vars['badge']['image_url']) . '" />
											</th>
										';
	}
	$__compilerTemp3 = '';
	if ($__vars['badge']['image_url_2x']) {
		$__compilerTemp3 .= '
											<th>
												<img class="image-icon-preview blue" src="' . $__templater->escape($__vars['badge']['image_url_2x']) . '" />
											</th>
										';
	}
	$__compilerTemp4 = '';
	if ($__vars['badge']['image_url_3x']) {
		$__compilerTemp4 .= '
											<th>
												<img class="image-icon-preview purple" src="' . $__templater->escape($__vars['badge']['image_url_3x']) . '" />
											</th>
										';
	}
	$__compilerTemp5 = '';
	if ($__vars['badge']['image_url_4x']) {
		$__compilerTemp5 .= '
											<th>
												<img class="image-icon-preview grey" src="' . $__templater->escape($__vars['badge']['image_url_4x']) . '" />
											</th>
										';
	}
	$__compilerTemp6 = '';
	if ($__vars['badge']['image_url']) {
		$__compilerTemp6 .= '<td class="image-icon-description yellow">@1x Resolution</td>';
	}
	$__compilerTemp7 = '';
	if ($__vars['badge']['image_url_2x']) {
		$__compilerTemp7 .= '<td class="image-icon-description blue">@2x Resolution</td>';
	}
	$__compilerTemp8 = '';
	if ($__vars['badge']['image_url_3x']) {
		$__compilerTemp8 .= '<td class="image-icon-description purple">@3x Resolution</td>';
	}
	$__compilerTemp9 = '';
	if ($__vars['badge']['image_url_4x']) {
		$__compilerTemp9 .= '<td class="image-icon-description grey">@4x Resolution</td>';
	}
	$__compilerTemp1[] = array(
		'value' => 'image',
		'label' => 'URL',
		'data-hide' => 'true',
		'_dependent' => array('
							<table style="width:100%">
								<tr>
    								<td>
										' . $__templater->formTextBox(array(
		'tabindex' => '1',
		'name' => 'image_url',
		'value' => (($__vars['badge']['icon_type'] == 'image') ? $__vars['badge']['image_url'] : null),
		'placeholder' => 'URL to Image (1x Resolution)',
	)) . '
									</td>
    								<td>
										' . $__templater->formTextBox(array(
		'tabindex' => '3',
		'name' => 'image_url_3x',
		'value' => (($__vars['badge']['icon_type'] == 'image') ? $__vars['badge']['image_url_3x'] : null),
		'placeholder' => 'URL to Image (3x Resolution) - Optional',
	)) . '
									</td>
  								</tr>
  								<tr>
    								<td>
										' . $__templater->formTextBox(array(
		'tabindex' => '2',
		'name' => 'image_url_2x',
		'value' => (($__vars['badge']['icon_type'] == 'image') ? $__vars['badge']['image_url_2x'] : null),
		'placeholder' => 'URL to Image (2x Resolution) - Optional',
	)) . '
									</td>
    								<td>
										' . $__templater->formTextBox(array(
		'tabindex' => '4',
		'name' => 'image_url_4x',
		'value' => (($__vars['badge']['icon_type'] == 'image') ? $__vars['badge']['image_url_4x'] : null),
		'placeholder' => 'URL to Image (4x Resolution) - Optional',
	)) . '
									</td>
  								</tr>
							</table>

							<table>
								<thead>
									<tr>
										' . $__compilerTemp2 . '
										' . $__compilerTemp3 . '
										' . $__compilerTemp4 . '
										' . $__compilerTemp5 . '
									</tr>
									<tr>
										' . $__compilerTemp6 . '
										' . $__compilerTemp7 . '
										' . $__compilerTemp8 . '
										' . $__compilerTemp9 . '
									</tr>
								</thead>
							</table>
						'),
		'_type' => 'option',
	);
	$__compilerTemp10 = '';
	if ($__vars['badge']['image_url']) {
		$__compilerTemp10 .= '
											<th>
												<img class="image-icon-preview yellow" src="' . $__templater->func('base_url', array($__vars['badge']['image_url'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp11 = '';
	if ($__vars['badge']['image_url_2x']) {
		$__compilerTemp11 .= '
											<th>
												<img class="image-icon-preview blue" src="' . $__templater->func('base_url', array($__vars['badge']['image_url_2x'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp12 = '';
	if ($__vars['badge']['image_url_3x']) {
		$__compilerTemp12 .= '
											<th>
												<img class="image-icon-preview purple" src="' . $__templater->func('base_url', array($__vars['badge']['image_url_3x'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp13 = '';
	if ($__vars['badge']['image_url_4x']) {
		$__compilerTemp13 .= '
											<th>
												<img class="image-icon-preview grey" src="' . $__templater->func('base_url', array($__vars['badge']['image_url_4x'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp14 = '';
	if ($__vars['badge']['image_url']) {
		$__compilerTemp14 .= '<td class="image-icon-description yellow">@1x Resolution</td>';
	}
	$__compilerTemp15 = '';
	if ($__vars['badge']['image_url_2x']) {
		$__compilerTemp15 .= '<td class="image-icon-description blue">@2x Resolution</td>';
	}
	$__compilerTemp16 = '';
	if ($__vars['badge']['image_url_3x']) {
		$__compilerTemp16 .= '<td class="image-icon-description purple">@3x Resolution</td>';
	}
	$__compilerTemp17 = '';
	if ($__vars['badge']['image_url_4x']) {
		$__compilerTemp17 .= '<td class="image-icon-description grey">@4x Resolution</td>';
	}
	$__compilerTemp1[] = array(
		'value' => 'asset',
		'label' => 'Upload image',
		'data-hide' => 'true',
		'_dependent' => array('
							<table style="width:100%">
								<tr>
    								<td>
										' . $__templater->formAssetUpload(array(
		'name' => 'image_url',
		'value' => (($__vars['badge']['icon_type'] == 'asset') ? $__vars['badge']['image_url'] : null),
		'asset' => 'ozzmodz_badges_badge',
		'maxlength' => $__templater->func('max_length', array($__vars['badge'], 'image_url', ), false),
		'placeholder' => 'URL to Image (1x Resolution)',
		'dir' => 'ltr',
	)) . '
									</td>
    								<td>
										' . $__templater->formAssetUpload(array(
		'name' => 'image_url_3x',
		'value' => (($__vars['badge']['icon_type'] == 'asset') ? $__vars['badge']['image_url_3x'] : null),
		'asset' => 'ozzmodz_badges_badge',
		'maxlength' => $__templater->func('max_length', array($__vars['badge'], 'image_url_3x', ), false),
		'placeholder' => 'URL to Image (3x Resolution) - Optional',
		'dir' => 'ltr',
	)) . '
									</td>
  								</tr>
  								<tr>
    								<td>
										' . $__templater->formAssetUpload(array(
		'name' => 'image_url_2x',
		'value' => (($__vars['badge']['icon_type'] == 'asset') ? $__vars['badge']['image_url_2x'] : null),
		'asset' => 'ozzmodz_badges_badge',
		'maxlength' => $__templater->func('max_length', array($__vars['badge'], 'image_url_2x', ), false),
		'placeholder' => 'URL to Image (2x Resolution) - Optional',
		'dir' => 'ltr',
	)) . '
									</td>
    								<td>
										' . $__templater->formAssetUpload(array(
		'name' => 'image_url_4x',
		'value' => (($__vars['badge']['icon_type'] == 'asset') ? $__vars['badge']['image_url_4x'] : null),
		'asset' => 'ozzmodz_badges_badge',
		'maxlength' => $__templater->func('max_length', array($__vars['badge'], 'image_url_4x', ), false),
		'placeholder' => 'URL to Image (4x Resolution) - Optional',
		'dir' => 'ltr',
	)) . '
									</td>
  								</tr>
							</table>
							<dfn class="inputChoices-explain">' . 'The web path from your site\'s XenForo installation directory to icon image. For default XenForo style use the square image icon.' . '</dfn>
							<table>
								<thead>
									<tr>
										' . $__compilerTemp10 . '
										' . $__compilerTemp11 . '
										' . $__compilerTemp12 . '
										' . $__compilerTemp13 . '
									</tr>
									<tr>
										' . $__compilerTemp14 . '
										' . $__compilerTemp15 . '
										' . $__compilerTemp16 . '
										' . $__compilerTemp17 . '
									</tr>
								</thead>
							</table>
						'),
		'_type' => 'option',
	);
	$__compilerTemp18 = '';
	if ($__templater->isTraversable($__vars['badge']['badge_link_attributes'])) {
		foreach ($__vars['badge']['badge_link_attributes'] AS $__vars['name'] => $__vars['value']) {
			$__compilerTemp18 .= '
										<li class="inputGroup"dir="ltr" >
											' . $__templater->formTextBox(array(
				'name' => 'badge_link_attribute_names[' . $__vars['name'] . ']',
				'value' => $__vars['name'],
				'size' => '15',
				'code' => 'true',
				'placeholder' => 'Name',
			)) . '
											<span class="inputGroup-splitter"></span>
											' . $__templater->formTextBox(array(
				'name' => 'badge_link_attribute_values[' . $__vars['name'] . ']',
				'value' => $__vars['value'],
				'size' => '25',
				'code' => 'true',
				'placeholder' => 'Value',
			)) . '
										</li>
									';
		}
	}
	$__compilerTemp19 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp19 = $__templater->mergeChoiceOptions($__compilerTemp19, $__vars['badgeCategories']);
	$__compilerTemp20 = array();
	if ($__templater->isTraversable($__vars['badgeTiers'])) {
		foreach ($__vars['badgeTiers'] AS $__vars['badgeTier']) {
			$__compilerTemp20[] = array(
				'value' => $__vars['badgeTier']['value'],
				'label' => $__templater->escape($__vars['badgeTier']['label']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp21 = array(array(
		'value' => '',
		'label' => 'None' . ' ',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['stackableBadges'])) {
		foreach ($__vars['stackableBadges'] AS $__vars['stackableBadge']) {
			$__compilerTemp21[] = array(
				'value' => $__vars['stackableBadge']['badge_id'],
				'label' => $__templater->escape($__vars['stackableBadge']['title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp22 = '';
	if (!$__templater->test($__vars['stackedBadges'], 'empty', array())) {
		$__compilerTemp22 .= '
						<div class="formRow-explain">
							' . 'This badge is already stacked with' . $__vars['xf']['language']['label_separator'] . '
							<ul class="listInline listInline--selfInline listInline--comma">
								';
		if ($__templater->isTraversable($__vars['stackedBadges'])) {
			foreach ($__vars['stackedBadges'] AS $__vars['stackedBadge']) {
				$__compilerTemp22 .= '
									<li><a href="' . $__templater->func('link', array('ozzmodz-badges/edit', $__vars['stackedBadge'], ), true) . '">' . $__templater->escape($__vars['stackedBadge']['title']) . '</a></li>
								';
			}
		}
		$__compilerTemp22 .= '
							</ul>
						</div>
					';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="h-scroller tabs" role="tablist">
			<span class="hScroller-scroll">
				<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="badge-options">' . 'Badge options' . '</a>
				<a class="tabs-tab" role="tab" tabindex="0" aria-controls="badge-criteria">' . 'Award this badge if...' . '</a>
			</span>
		</h2>

		<ul class="block-body tabPanes">
			<li class="is-active" role="tabpanel" id="badge-options">
				' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => ($__vars['badge']['badge_id'] ? $__vars['badge']['MasterTitle']['phrase_text'] : ''),
	), array(
		'label' => 'Title',
	)) . '

				' . $__templater->formTextAreaRow(array(
		'name' => 'description',
		'value' => ($__vars['badge']['badge_id'] ? $__vars['badge']['MasterDescription']['phrase_text'] : ''),
		'autosize' => 'true',
	), array(
		'label' => 'Description',
		'hint' => 'You may use HTML',
		'explain' => 'Optionally describe the badge and the criteria the user needs to meet to be awarded it.',
	)) . '
				
				<hr class="formRowSep" />
				
				' . $__templater->formRadioRow(array(
		'name' => 'icon_type',
		'value' => $__vars['badge']['icon_type'],
	), $__compilerTemp1, array(
		'label' => 'Icon type',
	)) . '
				
				' . $__templater->formTextBoxRow(array(
		'name' => 'alt_description',
		'value' => ($__vars['badge']['badge_id'] ? $__vars['badge']['MasterAltDescription']['phrase_text'] : ''),
		'autosize' => 'true',
	), array(
		'label' => 'Alt Description',
		'explain' => 'Provide a short description of the image you are using for this badge.<br><br>
Alternative Descriptions purpose is to describe badges (images) to visitors who are unable to see them. This includes screen readers and browsers that block images, but it also includes users who are sight-impaired or otherwise unable to visually identify an image. Including alt text with your badges ensures all users, regardless of visual ability, can appreciate the content on your site.',
	)) . '
				
				' . $__templater->formRow('
					' . $__templater->formTextBox(array(
		'name' => 'badge_link',
		'value' => $__vars['badge']['badge_link'],
	)) . '
					<div class="formRow-explain">' . 'By default, clicking on a badge opens the badges tab of the user\'s profile. You can set your link instead.' . '</div>
					
					' . $__templater->formCheckBox(array(
	), array(array(
		'selected' => $__vars['badge']['badge_link_attributes'],
		'label' => 'Extra attributes',
		'data-hide' => 'true',
		'_dependent' => array('
								<ul class="listPlain inputGroup-container">
									' . $__compilerTemp18 . '
									<li class="inputGroup" data-xf-init="field-adder" dir="ltr">
										' . $__templater->formTextBox(array(
		'name' => 'badge_link_attribute_names[]',
		'size' => '15',
		'code' => 'true',
		'placeholder' => 'Name',
	)) . '
										<span class="inputGroup-splitter"></span>
										' . $__templater->formTextBox(array(
		'name' => 'badge_link_attribute_values[]',
		'size' => '25',
		'code' => 'true',
		'placeholder' => 'Value',
	)) . '
									</li>
								</ul>
							'),
		'_type' => 'option',
	))) . '
				', array(
		'rowtype' => 'input',
		'label' => 'Badge link',
	)) . '
				
				<hr class="formRowSep" />
				
				' . $__templater->formTextBoxRow(array(
		'name' => 'class',
		'value' => $__vars['badge']['class'],
	), array(
		'label' => 'CSS class',
		'explain' => 'This class can be used for applying additional styles.',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formSelectRow(array(
		'name' => 'badge_category_id',
		'value' => $__vars['badge']['badge_category_id'],
	), $__compilerTemp19, array(
		'label' => 'Badge category',
	)) . '

				' . $__templater->formSelectRow(array(
		'name' => 'badge_tier_id',
		'value' => $__vars['badge']['badge_tier_id'],
	), $__compilerTemp20, array(
		'label' => 'Badge tier',
	)) . '

				' . $__templater->formRow('
					' . $__templater->formSelect(array(
		'name' => 'stacking_badge_id',
		'value' => $__vars['badge']['stacking_badge_id'],
	), $__compilerTemp21) . '
					' . $__compilerTemp22 . '
				', array(
		'rowtype' => 'input',
		'label' => 'Badge stacking',
		'explain' => 'Choose the badge he will stack with. Badges can only stack one level - sorted by recent in the first place.<br />
<b>NOTE:</b> Make sure the badges are correctly sorted in display order (use the sort tool in the menu)<br />
If you make changes to an existing you must perform a user badge cache rebuild if you want to apply changes to already awarded badges.
',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'checked' => $__vars['badge']['active'],
		'label' => 'Badge is active',
		'hint' => 'Disabled badges can no longer be awarded, and will no longer appear in public pages.',
		'_type' => 'option',
	),
	array(
		'name' => 'is_repetitive',
		'checked' => $__vars['badge']['is_repetitive'],
		'data-hide' => 'true',
		'label' => 'Repetitive',
		'hint' => 'If selected, this badge may be awarded multiple times.',
		'_dependent' => array('
							<div>' . 'Delay between re-awarding' . $__vars['xf']['language']['label_separator'] . '</div>
							' . $__templater->formNumberBox(array(
		'name' => 'repeat_delay',
		'value' => $__vars['badge']['repeat_delay'],
		'min' => '0',
		'units' => 'Hours',
	)) . '
						'),
		'_type' => 'option',
	),
	array(
		'name' => 'is_revoked',
		'checked' => $__vars['badge']['is_revoked'],
		'label' => 'Is recallable',
		'hint' => 'If checked, this badge will be revoked if the criteria no longer met',
		'_type' => 'option',
	),
	array(
		'name' => 'is_manually_awarded',
		'checked' => $__vars['badge']['is_manually_awarded'],
		'label' => 'Is manually awarded',
		'hint' => 'Disable this option if you want the badge to be awarded only automatically. Manually awarded badges are not removed automatically.',
		'_type' => 'option',
	)), array(
		'label' => 'Options',
	)) . '


				' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => $__vars['badge']['display_order'],
	), $__vars) . '
			</li>
			
			<li role="tabpanel" id="badge-criteria">
				<h2 class="block-minorTabHeader tabs hScroller" data-xf-init="h-scroller tabs" role="tablist">
					<span class="hScroller-scroll">
						' . $__templater->callMacro('helper_criteria', 'user_tabs', array(), $__vars) . '
					</span>
				</h2>
				
				<ul class="block-body tabPanes">
					' . $__templater->callMacro('helper_criteria', 'user_panes', array(
		'criteria' => $__templater->method($__vars['userCriteria'], 'getCriteriaForTemplate', array()),
		'data' => $__templater->method($__vars['userCriteria'], 'getExtraTemplateData', array()),
	), $__vars) . '
				</ul>
			</li>
		</ul>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges/save', $__vars['badge'], ), false),
		'ajax' => 'true',
		'class' => 'badge-edit block',
	));
	return $__finalCompiled;
}
);