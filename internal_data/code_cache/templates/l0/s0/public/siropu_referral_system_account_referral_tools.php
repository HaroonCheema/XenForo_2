<?php
// FROM HASH: 67f41f4b42c7e6f022de11a7c6c43be2
return array(
'macros' => array('tools' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'tools' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array();
	if ($__vars['type'] == 'banner') {
		$__compilerTemp1[] = array(
			'_type' => 'cell',
			'html' => 'Banner size',
		);
	}
	$__compilerTemp1[] = array(
		'_type' => 'cell',
		'html' => 'HTML',
	);
	$__compilerTemp1[] = array(
		'_type' => 'cell',
		'html' => 'BB code',
	);
	$__compilerTemp1[] = array(
		'_type' => 'cell',
		'html' => 'Preview',
	);
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['tools'])) {
		foreach ($__vars['tools'] AS $__vars['tool']) {
			$__compilerTemp2 .= '
			';
			$__compilerTemp3 = '';
			if ($__templater->method($__vars['tool'], 'isBanner', array())) {
				$__compilerTemp3 .= '<img src="' . $__templater->escape($__vars['tool']['absolute_file_path']) . '">';
			} else {
				$__compilerTemp3 .= $__templater->escape($__vars['tool']['content']);
			}
			$__vars['htmlValue'] = $__templater->preEscaped(trim('
				<a href="' . $__templater->func('siropu_rs_referral_link', array('tool', $__vars['tool'], ), true) . '" target="_blank">' . $__compilerTemp3 . '</a>
			'));
			$__compilerTemp2 .= '
			';
			$__compilerTemp4 = '';
			if ($__templater->method($__vars['tool'], 'isBanner', array())) {
				$__compilerTemp4 .= '[IMG]' . $__templater->escape($__vars['tool']['absolute_file_path']) . '[/IMG]';
			} else {
				$__compilerTemp4 .= $__templater->escape($__vars['tool']['content']);
			}
			$__vars['bbCodeValue'] = $__templater->preEscaped(trim('
				[URL=' . $__templater->func('siropu_rs_referral_link', array('tool', $__vars['tool'], ), true) . ']' . $__compilerTemp4 . '[/URL]
			'));
			$__compilerTemp2 .= '
			';
			$__compilerTemp5 = array();
			if ($__vars['type'] == 'banner') {
				$__compilerTemp5[] = array(
					'_type' => 'cell',
					'html' => '<b>' . $__templater->escape($__vars['tool']['size']) . '</b>',
				);
			}
			$__compilerTemp5[] = array(
				'_type' => 'cell',
				'html' => '
					<textarea class="input" rows="5">' . $__templater->escape($__vars['htmlValue']) . '</textarea>
				',
			);
			$__compilerTemp5[] = array(
				'_type' => 'cell',
				'html' => '
					<textarea class="input" rows="5">' . $__templater->escape($__vars['bbCodeValue']) . '</textarea>
				',
			);
			$__compilerTemp5[] = array(
				'width' => '10%',
				'_type' => 'cell',
				'html' => '
					' . $__templater->button('Click to view', array(
				'href' => $__templater->func('link', array('account/referral-tools/preview', null, array('tool_id' => $__vars['tool']['tool_id'], ), ), false),
				'icon' => 'preview',
				'data-xf-click' => 'overlay',
			), '', array(
			)) . '
				',
			);
			$__compilerTemp2 .= $__templater->dataRow(array(
			), $__compilerTemp5) . '
		';
		}
	}
	$__finalCompiled .= $__templater->dataList('
		<thead>
			' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), $__compilerTemp1) . '
		</thead>
		' . $__compilerTemp2 . '
	', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Referral tools');
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['siropuReferralSystemGenerarteLink']) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'siropu/rs/tools.js',
			'min' => '1',
		));
		$__finalCompiled .= '

	';
		$__templater->inlineCss('
		.urlResult
		{
			display: none;
		}
	');
		$__finalCompiled .= '
	
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formRow('
					<div class="inputGroup">
						' . $__templater->formTextBox(array(
			'name' => 'url',
			'autocomplete' => 'off',
		)) . '
						<span class="inputGroup-splitter"></span>
						' . $__templater->button('Generate', array(
			'type' => 'submit',
		), '', array(
		)) . '
					</div>
				', array(
			'label' => 'Generate referral link',
			'explain' => 'Paste the link from one of our community pages to generate a referral link from it.',
			'rowclass' => 'siropuGenerateCustomLink',
		)) . '

				' . $__templater->formRow('
					' . $__templater->formTextBox(array(
			'name' => 'result',
		)) . '
				', array(
			'rowclass' => 'urlResult',
			'label' => 'Your referral link',
		)) . '
			</div>
		</div>
	', array(
			'class' => 'block',
			'data-xf-init' => 'siropu-referral-system-link-generator',
		)) . '
';
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['tools'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
				<span class="hScroller-scroll">
					';
		if ($__vars['tools']['banner']) {
			$__finalCompiled .= '
						<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('banners', ), true) . '">' . 'Banners' . '</a>
					';
		}
		$__finalCompiled .= '
					';
		if ($__vars['tools']['text']) {
			$__finalCompiled .= '
						<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('text_links', ), true) . '">' . 'Text links' . '</a>
					';
		}
		$__finalCompiled .= '
				</span>
			</h2>
			<ul class="tabPanes block-body">
				';
		if ($__vars['tools']['banner']) {
			$__finalCompiled .= '
					<li class="is-active" role="tabpanel" id="' . $__templater->func('unique_id', array('banners', ), true) . '">
						' . $__templater->callMacro(null, 'tools', array(
				'type' => 'banner',
				'tools' => $__vars['tools']['banner'],
			), $__vars) . '
					</li>
				';
		}
		$__finalCompiled .= '
				';
		if ($__vars['tools']['text']) {
			$__finalCompiled .= '
					<li role="tabpanel" id="' . $__templater->func('unique_id', array('text_links', ), true) . '">
						' . $__templater->callMacro(null, 'tools', array(
				'type' => 'text',
				'tools' => $__vars['tools']['text'],
			), $__vars) . '
					</li>
				';
		}
		$__finalCompiled .= '
			</ul>
			<div class="block-footer">
				' . 'You can use the HTML code on your website or blog and the BB Code in your signature and threads on other forum communities (Please do not SPAM).' . '
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);