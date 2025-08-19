<?php
// FROM HASH: 86d865bd93aacccfe533556336cc2cc2
return array(
'macros' => array('basic_info' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
		'packages' => '',
		'attachmentData' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'siropu/am/create.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if (!$__vars['ad']['Forum']) {
		$__compilerTemp1 .= '
			.samPrefixId, .samCustomFields
			{
				display: none;
			}
		';
	}
	$__templater->inlineCss('
		' . $__compilerTemp1 . '
		.js-content3, .js-content4
		{
			display: none;
		}
		.samChildFormRow
		{
			margin-bottom: 15px;
		}
		.samChildFormRow:last-child
		{
			margin-bottom: 0;
		}
		.samKeywordRow
		{
			border-bottom: 1px solid #ccc;
			margin-bottom: 20px;
			padding-bottom: 20px;
		}
		.samKeywordRow:last-child
		{
			border-bottom: 0;
			margin-bottom: 0;
			padding-bottom: 0;
		}
	');
	$__finalCompiled .= '

	' . $__templater->formTextBoxRow(array(
		'name' => 'name',
		'value' => $__vars['ad']['name'],
		'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'name', ), false),
	), array(
		'label' => 'Ad name',
	)) . '

	';
	$__compilerTemp2 = array(array(
		'value' => '0',
		'label' => '(' . 'None' . ')',
		'_type' => 'option',
	));
	if (!$__templater->test($__vars['packages'], 'empty', array())) {
		$__compilerTemp2 = $__templater->mergeChoiceOptions($__compilerTemp2, $__vars['packages']);
	} else {
		$__compilerTemp2[] = array(
			'label' => 'No packages have been found for this ad type.',
			'_type' => 'option',
		);
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'package_id',
		'value' => $__vars['ad']['package_id'],
		'data-xf-init' => 'siropu-ads-manager-select-ad-package',
	), $__compilerTemp2, array(
		'label' => 'Package',
		'explain' => 'A package allows you to manage and rotate multiple ads.',
	)) . '

	';
	if (!$__templater->test($__vars['packages'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'inherit_package',
			'value' => '1',
			'checked' => ($__vars['ad']['inherit_package'] == 1),
			'label' => 'Inherit package settings',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to inherit the package\'s settings and criteria for a quick setup.',
			'rowclass' => 'samPackageOptions',
		)) . '

		' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'count_exclude',
			'value' => '1',
			'checked' => ($__vars['ad']['Extra']['count_exclude'] == 1),
			'label' => 'Exclude from package empty slot count',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to exclude this ad from the package empty slot count.',
			'rowclass' => 'samPackageOptions',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isEmbeddable', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro('siropu_ads_manager_position_macros', 'position_select', array(
			'entity' => $__vars['ad'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isThread', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->test($__vars['xf']['options']['siropuAdsManagerPromoThreadForums'], 'empty', array())) {
			$__finalCompiled .= '
			' . $__templater->formRow('', array(
				'label' => 'Forum',
				'html' => 'Please select at least one forum in <a href="' . $__templater->func('link', array('options/groups/siropuAdsManagerAdvertiser/#siropuAdsManagerPromoThreadForums', ), true) . '">Promo thread forums</a> admin option.',
			)) . '
		';
		} else {
			$__finalCompiled .= '
			';
			$__compilerTemp3 = array(array(
				'_type' => 'option',
			));
			$__compilerTemp3 = $__templater->mergeChoiceOptions($__compilerTemp3, $__templater->method($__vars['xf']['samAdmin'], 'getPromoThreadForums', array()));
			$__finalCompiled .= $__templater->formSelectRow(array(
				'name' => 'content_1',
				'value' => $__vars['ad']['content_1'],
				'data-xf-init' => 'siropu-ads-manager-select-forum',
			), $__compilerTemp3, array(
				'label' => 'Forum',
			)) . '
		';
		}
		$__finalCompiled .= '

		';
		$__compilerTemp4 = array();
		if ($__vars['ad']['Forum']) {
			$__compilerTemp4[] = array(
				'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
				'_type' => 'option',
			);
			$__compilerTemp5 = $__templater->method($__vars['ad']['Forum'], 'getPrefixes', array());
			if ($__templater->isTraversable($__compilerTemp5)) {
				foreach ($__compilerTemp5 AS $__vars['prefix']) {
					if ($__vars['xf']['options']['siropuAdsManagerStickyThreadPrefix'] != $__vars['prefix']['prefix_id']) {
						$__compilerTemp4[] = array(
							'value' => $__vars['prefix']['prefix_id'],
							'label' => $__templater->escape($__vars['prefix']['title']),
							'_type' => 'option',
						);
					}
				}
			}
		}
		$__finalCompiled .= $__templater->formSelectRow(array(
			'name' => 'prefix_id',
			'value' => ($__vars['ad']['Extra'] ? $__vars['ad']['Extra']['prefix_id'] : 0),
		), $__compilerTemp4, array(
			'label' => 'Thread prefix',
			'rowclass' => 'samPrefixId',
		)) . '

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
			$__finalCompiled .= '
				' . $__templater->formRow('
					' . $__templater->callMacro('public:helper_attach_upload', 'upload_block', array(
				'attachmentData' => $__vars['attachmentData'],
			), $__vars) . '
				', array(
			)) . '
			';
		}
		$__finalCompiled .= '
		</div>

		';
		if ($__vars['ad']['Extra'] AND $__vars['ad']['Extra']['custom_fields']) {
			$__finalCompiled .= '
			' . $__templater->callMacro('public:custom_fields_macros', 'custom_fields_edit', array(
				'type' => 'threads',
				'set' => $__templater->method($__vars['ad']['Extra'], 'getCustomFields', array()),
				'onlyInclude' => $__vars['ad']['Forum']['field_cache'],
			), $__vars) . '
		';
		} else if ($__vars['ad']['Thread']) {
			$__finalCompiled .= '
			' . $__templater->callMacro('public:custom_fields_macros', 'custom_fields_edit', array(
				'type' => 'threads',
				'set' => $__vars['ad']['Thread']['custom_fields'],
				'onlyInclude' => $__vars['ad']['Forum']['field_cache'],
			), $__vars) . '
		';
		}
		$__finalCompiled .= '

		' . $__templater->formRow('', array(
			'rowclass' => 'samCustomFields',
		)) . '

		' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'sticky',
			'value' => '1',
			'checked' => ($__templater->method($__vars['ad'], 'isInsert', array()) ? false : $__vars['ad']['Extra']['is_sticky']),
			'label' => 'Stick thread',
			'_type' => 'option',
		)), array(
		)) . '
	';
	}
	$__finalCompiled .= '
	
	';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('sticky', 'resource', ), ))) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'item_id',
			'value' => $__vars['ad']['item_id'],
		), array(
			'label' => ($__templater->method($__vars['ad'], 'isSticky', array()) ? 'Thread ID' : 'Resource ID'),
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isCode', array())) {
		$__finalCompiled .= '
		' . $__templater->formCodeEditorRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'class' => 'codeEditor--short',
			'mode' => 'html',
		), array(
			'label' => 'Code',
			'explain' => '
				 ' . 'Paste your ad code here (AdSense, affiliate banners, etc).' . ' ' . 'You may use XenForo template syntax here.' . '<br>
				 <a href="' . $__templater->func('link', array('ads-manager/ads/callback', ), true) . '" data-xf-click="overlay">' . 'Do you want to generate the code using a callback?' . '</a>',
		)) . '

		' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[no_wrapper]',
			'value' => '1',
			'checked' => ($__vars['ad']['settings']['no_wrapper'] == 1),
			'label' => 'Display without wrapper',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to display the ad code without any div tags around the ad. Please note that this option doesn\'t work with lazy loading, AdBlock detection and most of the settings in the Settings tab. ',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('code', 'banner', 'text', ), ))) {
		$__finalCompiled .= '
		';
		if (!$__templater->method($__vars['ad'], 'isText', array())) {
			$__finalCompiled .= '
			' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'settings[lazyload]',
				'value' => '1',
				'checked' => ($__vars['ad']['settings']['lazyload'] == 1),
				'label' => 'Enable lazy loading',
				'data-hide' => 'true',
				'_dependent' => array('
						<label>' . 'Refresh every' . $__vars['xf']['language']['ellipsis'] . '</label>
						' . $__templater->formNumberBox(array(
				'name' => 'settings[refresh]',
				'value' => ($__vars['ad']['settings']['refresh'] ?: 0),
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
			'checked' => ($__vars['ad']['settings']['lazyload_image'] == 1),
			'label' => 'Enable image lazy loading',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to load the ad image after the page loads, when the ad container is in the view.',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'text', 'background', ), ))) {
		$__finalCompiled .= '
		';
		$__compilerTemp6 = '';
		if (!$__templater->method($__vars['ad'], 'isBackground', array())) {
			$__compilerTemp6 .= '
						<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('bannerHtml', ), true) . '">' . 'Custom HTML' . '</a>
					';
		}
		$__compilerTemp7 = '';
		if ($__templater->isTraversable($__vars['ad']['banner_file'])) {
			foreach ($__vars['ad']['banner_file'] AS $__vars['file']) {
				$__compilerTemp7 .= '
							';
				$__vars['bannerFile'] = $__templater->method($__vars['ad'], 'getAbsoluteFilePath', array($__vars['file'], ));
				$__compilerTemp7 .= '
							<li class="samFile">
								';
				if ($__templater->method($__vars['ad'], 'isFlash', array($__vars['file'], ))) {
					$__compilerTemp7 .= '
									' . $__templater->callMacro('public:siropu_ads_manager_ad_macros', 'flash_banner', array(
						'ad' => $__vars['ad'],
						'file' => $__vars['bannerFile'],
					), $__vars) . '
								';
				} else if ($__templater->method($__vars['ad'], 'isMp4', array($__vars['file'], ))) {
					$__compilerTemp7 .= '
									' . $__templater->callMacro('public:siropu_ads_manager_ad_macros', 'mp4_banner', array(
						'ad' => $__vars['ad'],
						'file' => $__vars['bannerFile'],
					), $__vars) . '
								';
				} else {
					$__compilerTemp7 .= '
									<img src="' . $__templater->escape($__vars['bannerFile']) . '">
								';
				}
				$__compilerTemp7 .= '
								' . $__templater->button('Delete', array(
					'data-xf-click' => 'siropu-ads-manager-delete-file',
					'data-post-url' => $__templater->func('link', array('ads-manager/ads/delete-file', $__vars['ad'], ), false),
					'data-file' => $__vars['file'],
					'fa' => 'fas fa-trash-alt',
				), '', array(
				)) . '
							</li>
						';
			}
		}
		$__compilerTemp8 = '';
		if ($__templater->isTraversable($__vars['ad']['banner_url'])) {
			foreach ($__vars['ad']['banner_url'] AS $__vars['url']) {
				$__compilerTemp8 .= '
							<li class="inputGroup">
								' . $__templater->formTextBox(array(
					'name' => 'banner_url[]',
					'value' => $__vars['url'],
					'type' => 'url',
					'dir' => 'ltr',
					'placeholder' => 'URL',
				)) . '
							</li>
						';
			}
		}
		$__compilerTemp9 = '';
		if (!$__templater->method($__vars['ad'], 'isBackground', array())) {
			$__compilerTemp9 .= '
					<li role="tabpanel" id="' . $__templater->func('unique_id', array('bannerHtml', ), true) . '">
						' . $__templater->formCodeEditor(array(
				'name' => 'content_2',
				'value' => $__vars['ad']['content_2'],
				'class' => 'codeEditor--short',
				'mode' => 'html',
			)) . '
						<dfn class="inputChoices-explain inputChoices-explain--after">
							' . 'This option allows you to build your own banner code using HTML/JavaScript.' . ' ' . ($__templater->method($__vars['ad'], 'isBanner', array()) ? 'You may use XenForo template syntax here.' : '') . '
						</dfn>
					</li>
				';
		}
		$__finalCompiled .= $__templater->formRow('
			<h2 class="block-tabHeader tabs tabs--standalone hScroller" data-xf-init="tabs h-scroller" role="tablist">
				<span class="hScroller-scroll">
					<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('bannerUpload', ), true) . '">' . 'Upload from device' . '</a>
					<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('bannerUrl', ), true) . '">' . 'Use from URL' . '</a>
					' . $__compilerTemp6 . '
				</span>
			</h2>

			<ul class="tabPanes" style="margin-top: 10px;">
				<li role="tabpanel" id="' . $__templater->func('unique_id', array('bannerUpload', ), true) . '">
					<ul class="listPlain samFileList">
						' . $__compilerTemp7 . '
					</ul>
					' . $__templater->formUpload(array(
			'name' => 'upload[]',
			'accept' => '.gif,.jpeg,.jpg,.jpe,.png,.svg,.webp,.swf,.mp4',
			'multiple' => 'true',
		)) . '
					<dfn class="inputChoices-explain inputChoices-explain--after">' . 'If multiple files are provided, they will rotate randomly on each page load.' . '</dfn>
				</li>
				<li role="tabpanel" id="' . $__templater->func('unique_id', array('bannerUrl', ), true) . '">
					<ul class="listPlain inputGroup-container">
						' . $__compilerTemp8 . '
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
				' . $__compilerTemp9 . '
			</ul>
		', array(
			'label' => ($__templater->method($__vars['ad'], 'isBackground', array()) ? 'Background image' : 'Banner file'),
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'text', ), ))) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'content_4',
			'value' => $__vars['ad']['content_4'],
		), array(
			'hint' => 'Optional',
			'label' => 'Alt text',
			'explain' => 'The alt attribute provides alternative information for an image if a user for some reason cannot view it (because of slow connection, an error in the src attribute, or if the user uses a screen reader).',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('code', 'banner', ), ))) {
		$__finalCompiled .= '
		' . $__templater->formTextAreaRow(array(
			'name' => 'content_3',
			'value' => $__vars['ad']['content_3'],
		), array(
			'label' => 'Backup ad',
			'explain' => 'This option allows you to display a backup ad if your HTML/JavaScript ad gets blocked by AdBlock or if AdSense has an unfilled ad status. Use a simple HTML banner code that doesn\'t contain any ad related information in its image URL (ad, advertisement, 468x60, 728x90, etc).

To use this with AdBlock detection, you need to set the Ads Manager admin option "<a href="' . $__templater->func('link', array('options/groups/siropuAdsManager/#siropuAdsManagerAdBlock', ), true) . '">If AdBlock is detected</a>" to "Replace ad with its backup".',
			'hint' => 'Optional',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isKeyword', array())) {
		$__finalCompiled .= '
		';
		$__compilerTemp10 = '';
		if ($__templater->isTraversable($__vars['ad']['item_array'])) {
			foreach ($__vars['ad']['item_array'] AS $__vars['counter'] => $__vars['item']) {
				$__compilerTemp10 .= '
							<li class="samKeywordRow">
								 <div class="samChildFormRow">
									 ' . $__templater->formTextBox(array(
					'name' => 'item_array[' . $__vars['counter'] . '][keyword]',
					'value' => $__vars['item']['keyword'],
					'placeholder' => 'Keyword',
					'rows' => '3',
				)) . '
									<div class="formRow-explain">' . 'The keyword you want to target.' . '</div>
								 </div>
								<div class="samChildFormRow">
									 ' . $__templater->formTextBox(array(
					'name' => 'item_array[' . $__vars['counter'] . '][replacement]',
					'value' => $__vars['item']['replacement'],
					'placeholder' => 'Replacement',
				)) . '
									  <div class="formRow-explain">' . 'Allows you to replace the keyword with something else.' . '</div>
								 </div>
								 <div class="samChildFormRow">
									 ' . $__templater->formTextBox(array(
					'name' => 'item_array[' . $__vars['counter'] . '][title]',
					'value' => $__vars['item']['title'],
					'placeholder' => 'Title',
				)) . '
									  <div class="formRow-explain">' . '(Optional) If a title is provided, it will be displayed when hovering over the keyword.' . '</div>
								 </div>
								  <div class="samChildFormRow">
									 ' . $__templater->formTextBox(array(
					'name' => 'item_array[' . $__vars['counter'] . '][url]',
					'value' => $__vars['item']['url'],
					'type' => 'url',
					'dir' => 'ltr',
					'placeholder' => 'Target URL',
				)) . '
									  <div class="formRow-explain">' . 'The address of the website you want to link to.' . '</div>
								 </div>
							</li>
						';
			}
		}
		$__vars['nextCounter'] = ($__vars['ad']['item_array'] ? ($__templater->func('count', array($__vars['ad']['item_array'], ), false) + 1) : 0);
		$__finalCompiled .= $__templater->formRow('
			<h2 class="block-tabHeader tabs tabs--standalone hScroller" data-xf-init="tabs h-scroller" role="tablist">
				 <span class="hScroller-scroll">
					  <a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('keywordList', ), true) . '">' . 'Simple list' . '</a>
					  <a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('keywordArray', ), true) . '">' . 'Batch' . '</a>
				 </span>
			</h2>

			<ul class="tabPanes">
				 <li role="tabpanel" id="' . $__templater->func('unique_id', array('keywordList', ), true) . '">
					 <div class="samChildFormRow">
						 ' . $__templater->formTextArea(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'placeholder' => 'Keyword(s)',
			'rows' => '3',
		)) . '
					 	<div class="formRow-explain">' . 'To target multiple keywords, place each keyword on a new line.' . '</div>
					 </div>
					  <div class="samChildFormRow">
						 ' . $__templater->formTextBox(array(
			'name' => 'content_2',
			'value' => $__vars['ad']['content_2'],
			'placeholder' => 'Replacement',
		)) . '
						  <div class="formRow-explain">' . 'Allows you to replace the keyword with something else.' . '</div>
					 </div>
					 <div class="samChildFormRow">
						 ' . $__templater->formTextBox(array(
			'name' => 'title',
			'value' => $__vars['ad']['title'],
			'placeholder' => 'Title',
			'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'title', ), false),
		)) . '
						  <div class="formRow-explain">' . '(Optional) If a title is provided, it will be displayed when hovering over the keyword.' . '</div>
					 </div>
					  <div class="samChildFormRow">
						 ' . $__templater->formTextBox(array(
			'name' => 'target_url',
			'value' => $__vars['ad']['target_url'],
			'type' => 'url',
			'dir' => 'ltr',
			'placeholder' => 'Target URL',
			'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'target_url', ), false),
		)) . '
						  <div class="formRow-explain">' . 'The address of the website you want to link to.' . '</div>
					 </div>
				 </li>
				 <li role="tabpanel" id="' . $__templater->func('unique_id', array('keywordArray', ), true) . '">
					  <ol class="samKeywordArray">
						' . $__compilerTemp10 . '

						' . '' . '
						<li class="samKeywordRow" data-xf-init="field-adder" data-increment-format="item_array[{counter}]">
							 <div class="samChildFormRow">
								 ' . $__templater->formTextBox(array(
			'name' => 'item_array[' . $__vars['nextCounter'] . '][keyword]',
			'placeholder' => 'Keyword',
		)) . '
								<div class="formRow-explain">' . 'The keyword you want to target.' . '</div>
							 </div>
							<div class="samChildFormRow">
								 ' . $__templater->formTextBox(array(
			'name' => 'item_array[' . $__vars['nextCounter'] . '][replacement]',
			'placeholder' => 'Replacement',
		)) . '
								<div class="formRow-explain">' . 'Allows you to replace the keyword with something else.' . '</div>
							 </div>
							 <div class="samChildFormRow">
								 ' . $__templater->formTextBox(array(
			'name' => 'item_array[' . $__vars['nextCounter'] . '][title]',
			'placeholder' => 'Title',
		)) . '
								  <div class="formRow-explain">' . '(Optional) If a title is provided, it will be displayed when hovering over the keyword.' . '</div>
							 </div>
							  <div class="samChildFormRow">
								 ' . $__templater->formTextBox(array(
			'name' => 'item_array[' . $__vars['nextCounter'] . '][url]',
			'type' => 'url',
			'dir' => 'ltr',
			'placeholder' => 'Target URL',
		)) . '
								  <div class="formRow-explain">' . 'The address of the website you want to link to.' . '</div>
							 </div>
						</li>
					</ol>
				 </li>
			</ul>
		', array(
			'label' => 'Keyword',
		)) . '

		' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[case_sensitive]',
			'value' => '1',
			'checked' => ($__vars['ad']['settings']['case_sensitive'] == 1),
			'label' => 'Case sensitive',
			'_type' => 'option',
		)), array(
			'explain' => 'Check this option if you want keywords to be case sensitive.',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('text', 'link', ), ))) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'title',
			'value' => $__vars['ad']['title'],
			'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'title', ), false),
		), array(
			'label' => 'Title',
			'explain' => ($__templater->method($__vars['ad'], 'isKeyword', array()) ? '(Optional) If a title is provided, it will be displayed when hovering over the keyword.' : 'The title of the link that can be clicked on.'),
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isText', array())) {
		$__finalCompiled .= '
		' . $__templater->formTextAreaRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'rows' => '3',
		), array(
			'label' => 'Description',
			'explain' => 'You may use XenForo template syntax here.',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isPopup', array())) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'title',
			'value' => $__vars['ad']['title'],
			'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'title', ), false),
		), array(
			'label' => 'Popup title',
			'explain' => 'The title of the popup.',
		)) . '

		' . $__templater->formCodeEditorRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'class' => 'codeEditor--short',
			'mode' => 'html',
			'rows' => '3',
		), array(
			'label' => 'Popup content',
			'explain' => 'The content that will be displayed inside the popup.' . ' ' . 'You may use XenForo template syntax here.',
		)) . '

		<hr class="formRowSep" />

		' . $__templater->formCodeEditorRow(array(
			'name' => 'content_2',
			'value' => $__vars['ad']['content_2'],
			'class' => 'codeEditor--short',
			'mode' => 'html',
			'rows' => '3',
		), array(
			'label' => 'Custom popup code',
			'explain' => 'This option allows you to use your own custom JavaScript popup. Paste the code here without the &lt;script&gt; tag.',
			'hint' => 'Alternative 1',
		)) . '

		<hr class="formRowSep" />
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isOfType', array(array('banner', 'text', 'link', 'popup', 'background', ), ))) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'target_url',
			'value' => $__vars['ad']['target_url'],
			'type' => 'url',
			'dir' => 'ltr',
			'maxlength' => $__templater->func('max_length', array($__vars['ad'], 'target_url', ), false),
		), array(
			'label' => ($__templater->method($__vars['ad'], 'isPopup', array()) ? 'Popup window URL' : 'Target URL'),
			'explain' => ($__templater->method($__vars['ad'], 'isPopup', array()) ? 'This option allows you to open an URL in a popup window.' : 'The address of the website you want to link to.'),
			'hint' => ($__templater->method($__vars['ad'], 'isPopup', array()) ? 'Alternative 2' : ''),
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isPopup', array())) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'content_3',
			'value' => $__vars['ad']['content_3'],
		), array(
			'label' => 'Popup window features',
			'explain' => '<a href="https://developer.mozilla.org/en-US/docs/Web/API/Window/open#Window_features" target="_blank">https://developer.mozilla.org/en-US/docs/Web/API/Window/open#Window_features</a>',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isAffiliate', array())) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
		), array(
			'label' => 'Affiliate website',
			'explain' => 'Specify the affiliate website you want to target. Only domain name is required as it will match any pages of that website. If you want to match the subdomains as well, add a . right before the domain name (Example: .google.com).',
		)) . '

		';
		$__compilerTemp11 = '';
		if ($__templater->isTraversable($__vars['ad']['item_array'])) {
			foreach ($__vars['ad']['item_array'] AS $__vars['item']) {
				$__compilerTemp11 .= '
					<li class="inputGroup">
						' . $__templater->formTextBox(array(
					'name' => 'item_array[]',
					'value' => $__vars['item'],
					'dir' => 'ltr',
				)) . '
					</li>
				';
			}
		}
		$__finalCompiled .= $__templater->formRow('
			<ul class="listPlain inputGroup-container">
				' . $__compilerTemp11 . '
				<li class="inputGroup" data-xf-init="field-adder" data-increment-format="item_array[]">
					' . $__templater->formTextBox(array(
			'name' => 'item_array[]',
			'dir' => 'ltr',
		)) . '
				</li>
			</ul>
		', array(
			'label' => 'Exclude URLs',
			'explain' => 'This option allows you to exclude certain URLs from getting converted to affiliate links.',
		)) . '
		
		' . $__templater->formSelectRow(array(
			'name' => 'content_2',
			'value' => $__vars['ad']['content_2'],
			'data-xf-init' => 'siropu-ads-manager-affiliate-action',
		), array(array(
			'value' => 'to_aff',
			'label' => 'Append parameter to affiliate website',
			'_type' => 'option',
		),
		array(
			'value' => 'aff_to',
			'label' => 'Append affiliate website to URL',
			'_type' => 'option',
		),
		array(
			'value' => 'replace',
			'label' => 'Replace affiliate website with URL',
			'_type' => 'option',
		),
		array(
			'value' => 'params',
			'label' => 'Replace parameters in affiliate URL',
			'_type' => 'option',
		),
		array(
			'value' => 'callback',
			'label' => 'Use callback to build affiliate URL',
			'_type' => 'option',
		)), array(
			'label' => 'Method',
			'explain' => $__templater->filter($__templater->arrayKey($__templater->method($__vars['ad'], 'getAffiliateLinkFormPhrase', array()), 'description'), array(array('raw', array()),), true),
			'rowclass' => 'js-content2',
		)) . '

		' . $__templater->formTextBoxRow(array(
			'name' => 'content_3',
			'value' => $__vars['ad']['content_3'],
		), array(
			'label' => $__templater->escape($__templater->arrayKey($__templater->method($__vars['ad'], 'getAffiliateLinkFormPhrase', array()), 'label')),
			'rowclass' => 'js-content3',
		)) . '

		';
		$__compilerTemp12 = '';
		$__compilerTemp13 = $__templater->method($__vars['ad'], 'getAffiliateLinkParams', array());
		if ($__templater->isTraversable($__compilerTemp13)) {
			foreach ($__compilerTemp13 AS $__vars['param'] => $__vars['value']) {
				$__compilerTemp12 .= '
					<li class="inputGroup">
						' . $__templater->formTextBox(array(
					'name' => 'params[name][]',
					'value' => $__vars['param'],
					'placeholder' => 'Parameter name',
				)) . '
						<span class="inputGroup-splitter"></span>
						' . $__templater->formTextBox(array(
					'name' => 'params[value][]',
					'value' => $__vars['value'],
					'placeholder' => 'Parameter value',
				)) . '
					</li>
				';
			}
		}
		$__finalCompiled .= $__templater->formRow('
			<ul class="listPlain inputGroup-container">
				' . $__compilerTemp12 . '

				<li class="inputGroup" data-xf-init="field-adder">
					' . $__templater->formTextBox(array(
			'name' => 'params[name][]',
			'placeholder' => 'Parameter name',
		)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->formTextBox(array(
			'name' => 'params[value][]',
			'placeholder' => 'Parameter value',
		)) . '
				</li>
			</ul>

			<dfn class="inputChoices-explain inputChoices-explain--after">' . 'Set the name of the parameter that you want to replace in the affiliate URL and the value that you want to set for that parameter.' . '</dfn>

			' . $__templater->formCheckBox(array(
			'style' => 'margin-top: 10px;',
		), array(array(
			'name' => 'settings[append_parameters]',
			'value' => '1',
			'checked' => ($__vars['ad']['settings']['append_parameters'] != 0),
			'label' => 'Append parameters if not found',
			'_type' => 'option',
		))) . '
		', array(
			'label' => 'Parameters',
			'rowclass' => 'js-content4',
		)) . '

		' . $__templater->formTextBoxRow(array(
			'name' => 'title',
			'value' => $__vars['ad']['title'],
		), array(
			'label' => 'Anchor text',
			'explain' => 'This option allows you to change the link anchor text of affiliate links. ',
			'hint' => 'Optional',
		)) . '
	
		' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'settings[hide_affiliate]',
			'value' => '1',
			'selected' => $__vars['ad']['settings']['hide_affiliate'],
			'label' => 'Hide affiliate URL',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to use the original link URL but open the affiliate URL when the link is clicked.',
		)) . '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['ad'], 'isCustom', array())) {
		$__finalCompiled .= '
		' . $__templater->formTextAreaRow(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'rows' => '10',
		), array(
			'label' => 'Notes',
		)) . '
	';
	}
	$__finalCompiled .= '	
	
	' . $__templater->formSelectRow(array(
		'name' => 'status',
		'value' => $__vars['ad']['status'],
	), array(array(
		'value' => 'active',
		'label' => 'Active',
		'_type' => 'option',
	),
	array(
		'value' => 'inactive',
		'label' => 'Inactive',
		'_type' => 'option',
	),
	array(
		'value' => 'pending',
		'label' => 'Pending',
		'_type' => 'option',
	),
	array(
		'value' => 'approved',
		'label' => 'Approved',
		'_type' => 'option',
	),
	array(
		'value' => 'queued',
		'label' => 'Queued',
		'_type' => 'option',
	),
	array(
		'value' => 'queued_invoice',
		'label' => 'Queued (Pending invoice)',
		'_type' => 'option',
	),
	array(
		'value' => 'paused',
		'label' => 'Paused',
		'_type' => 'option',
	),
	array(
		'value' => 'archived',
		'label' => 'Archived',
		'_type' => 'option',
	),
	array(
		'value' => 'rejected',
		'label' => 'Rejected',
		'_type' => 'option',
	)), array(
		'label' => 'Status',
	)) . '
';
	return $__finalCompiled;
}
),
'type_tabs' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'route' => 'ads',
		'item' => 'ad',
		'type' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<h2 class="block-tabHeader tabs hScroller" data-xf-init="h-scroller">
		<span class="hScroller-scroll">
			<a href="' . $__templater->func('link', array($__vars['route'], ), true) . '" class="tabs-tab' . (($__vars['type'] == '') ? ' is-active' : '') . '">' . (($__vars['item'] == 'ad') ? 'All ads' : 'All packages') . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'code', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'code') ? ' is-active' : '') . '">' . 'Code' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'banner', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'banner') ? ' is-active' : '') . '">' . 'Banner' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'text', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'text') ? ' is-active' : '') . '">' . 'Text' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'link', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'link') ? ' is-active' : '') . '">' . 'Link' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'keyword', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'keyword') ? ' is-active' : '') . '">' . 'Keyword' . '</a>
			';
	if ($__vars['item'] == 'ad') {
		$__finalCompiled .= '
				<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'affiliate', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'affiliate') ? ' is-active' : '') . '">' . 'Affiliate link' . '</a>
			';
	}
	$__finalCompiled .= '
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'sticky', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'sticky') ? ' is-active' : '') . '">' . 'Sticky thread' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'thread', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'thread') ? ' is-active' : '') . '">' . 'Promo thread' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'resource', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'resource') ? ' is-active' : '') . '">' . 'Featured resource' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'popup', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'popup') ? ' is-active' : '') . '">' . 'Popup' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'background', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'background') ? ' is-active' : '') . '">' . 'Background' . '</a>
			<a href="' . $__templater->func('link', array($__vars['route'], '', array('type' => 'custom', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'custom') ? ' is-active' : '') . '">' . 'Custom service' . '</a>
		</span>
	</h2>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);