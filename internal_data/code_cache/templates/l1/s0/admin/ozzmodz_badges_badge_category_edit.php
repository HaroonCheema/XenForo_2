<?php
// FROM HASH: 1d7abb3dd0a4b5c84c8c9618330e1dce
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['badgeCategory'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add badge category');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit badge category' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['badgeCategory']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->includeCss('ozzmodz_badges.less');
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['badgeCategory'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ozzmodz-badges-categories/delete', $__vars['badgeCategory'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'None',
		'_type' => 'option',
	)
,array(
		'value' => 'fa',
		'label' => 'Font Awesome icon',
		'data-hide' => 'true',
		'_dependent' => array('
						' . $__templater->formTextBox(array(
		'name' => 'fa_icon',
		'value' => $__vars['badgeCategory']['fa_icon'],
		'fa' => $__vars['badgeCategory']['fa_icon'],
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
			'value' => $__vars['badgeCategory']['mdi_icon'],
		)) . '
							<dfn class="inputChoices-explain">' . 'Material Design Icon code. For example: <code>mdi-cheese</code> or <code>mdi-car-light-alert</code>. <a href="https://pictogrammers.github.io/@mdi/font/6.5.95/" target="_blank">List of icon codes</a>.' . '</dfn>
						'),
			'_type' => 'option',
		);
	}
	$__compilerTemp2 = '';
	if ($__vars['badgeCategory']['image_url']) {
		$__compilerTemp2 .= '
											<th>
												<img class="image-icon-preview yellow" src="' . $__templater->func('base_url', array($__vars['badgeCategory']['image_url'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp3 = '';
	if ($__vars['badgeCategory']['image_url_2x']) {
		$__compilerTemp3 .= '
											<th>
												<img class="image-icon-preview blue" src="' . $__templater->func('base_url', array($__vars['badgeCategory']['image_url_2x'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp4 = '';
	if ($__vars['badgeCategory']['image_url_3x']) {
		$__compilerTemp4 .= '
											<th>
												<img class="image-icon-preview purple" src="' . $__templater->func('base_url', array($__vars['badgeCategory']['image_url_3x'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp5 = '';
	if ($__vars['badgeCategory']['image_url_4x']) {
		$__compilerTemp5 .= '
											<th>
												<img class="image-icon-preview grey" src="' . $__templater->func('base_url', array($__vars['badgeCategory']['image_url_4x'], ), true) . '" />
											</th>
										';
	}
	$__compilerTemp6 = '';
	if ($__vars['badgeCategory']['image_url']) {
		$__compilerTemp6 .= '<td class="image-icon-description yellow">@1x Resolution</td>';
	}
	$__compilerTemp7 = '';
	if ($__vars['badgeCategory']['image_url_2x']) {
		$__compilerTemp7 .= '<td class="image-icon-description blue">@2x Resolution</td>';
	}
	$__compilerTemp8 = '';
	if ($__vars['badgeCategory']['image_url_3x']) {
		$__compilerTemp8 .= '<td class="image-icon-description purple">@3x Resolution</td>';
	}
	$__compilerTemp9 = '';
	if ($__vars['badgeCategory']['image_url_4x']) {
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
		'value' => (($__vars['badgeCategory']['icon_type'] == 'image') ? $__vars['badgeCategory']['image_url'] : null),
		'placeholder' => 'URL to Image (1x Resolution)',
	)) . '
									</td>
    								<td>
										' . $__templater->formTextBox(array(
		'tabindex' => '3',
		'name' => 'image_url_3x',
		'value' => (($__vars['badgeCategory']['image_url_3x'] == 'image') ? $__vars['badgeCategory']['image_url_3x'] : null),
		'placeholder' => 'URL to Image (3x Resolution) - Optional',
	)) . '
									</td>
  								</tr>
  								<tr>
    								<td>
										' . $__templater->formTextBox(array(
		'tabindex' => '2',
		'name' => 'image_url_2x',
		'value' => (($__vars['badgeCategory']['image_url_2x'] == 'image') ? $__vars['badgeCategory']['image_url_2x'] : null),
		'placeholder' => 'URL to Image (2x Resolution) - Optional',
	)) . '
									</td>
    								<td>
										' . $__templater->formTextBox(array(
		'tabindex' => '4',
		'name' => 'image_url_4x',
		'value' => (($__vars['badgeCategory']['image_url_4x'] == 'image') ? $__vars['badgeCategory']['image_url_4x'] : null),
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
		'value' => (($__vars['badgeCategory']['icon_type'] == 'asset') ? $__vars['badgeCategory']['image_url'] : null),
		'asset' => 'ozzmodz_badges_badge_category',
		'maxlength' => $__templater->func('max_length', array($__vars['badgeCategory'], 'image_url', ), false),
		'placeholder' => 'URL to Image (1x Resolution)',
		'dir' => 'ltr',
	)) . '
									</td>
    								<td>
										' . $__templater->formAssetUpload(array(
		'name' => 'image_url_3x',
		'value' => (($__vars['badgeCategory']['icon_type'] == 'asset') ? $__vars['badgeCategory']['image_url_3x'] : null),
		'asset' => 'ozzmodz_badges_badge_category',
		'maxlength' => $__templater->func('max_length', array($__vars['badgeCategory'], 'image_url_3x', ), false),
		'placeholder' => 'URL to Image (3x Resolution) - Optional',
		'dir' => 'ltr',
	)) . '
									</td>
  								</tr>
  								<tr>
    								<td>
										' . $__templater->formAssetUpload(array(
		'name' => 'image_url_2x',
		'value' => (($__vars['badgeCategory']['icon_type'] == 'asset') ? $__vars['badgeCategory']['image_url_2x'] : null),
		'asset' => 'ozzmodz_badges_badge_category',
		'maxlength' => $__templater->func('max_length', array($__vars['badgeCategory'], 'image_url_2x', ), false),
		'placeholder' => 'URL to Image (2x Resolution) - Optional',
		'dir' => 'ltr',
	)) . '
									</td>
    								<td>
										' . $__templater->formAssetUpload(array(
		'name' => 'image_url_4x',
		'value' => (($__vars['badgeCategory']['icon_type'] == 'asset') ? $__vars['badgeCategory']['image_url_4x'] : null),
		'asset' => 'ozzmodz_badges_badge_category',
		'maxlength' => $__templater->func('max_length', array($__vars['badgeCategory'], 'image_url_4x', ), false),
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
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => ($__templater->method($__vars['badgeCategory'], 'exists', array()) ? $__vars['badgeCategory']['MasterTitle']['phrase_text'] : ''),
	), array(
		'label' => 'Title',
	)) . '

			<hr class="formRowSep" />
			
			' . $__templater->formRadioRow(array(
		'name' => 'icon_type',
		'value' => $__vars['badgeCategory']['icon_type'],
	), $__compilerTemp1, array(
		'label' => 'Icon type',
	)) . '
			
			<hr class="formRowSep" />
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'class',
		'value' => $__vars['badgeCategory']['class'],
	), array(
		'label' => 'CSS class',
		'explain' => 'This class can be used for applying additional styles.',
	)) . '
			
			<hr class="formRowSep" />
			
			' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => $__vars['badgeCategory']['display_order'],
	), $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges-categories/save', $__vars['badgeCategory'], ), false),
		'ajax' => 'true',
		'class' => 'badge-category-edit block',
	));
	return $__finalCompiled;
}
);