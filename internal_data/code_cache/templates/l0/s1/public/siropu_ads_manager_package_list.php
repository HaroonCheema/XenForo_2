<?php
// FROM HASH: 13751041d22eb263c7e53d6f8230bd23
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Create ad');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Please select advertising package');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->inlineCss('
	.dataList-subRow
	{
		white-space: initial;
		overflow: initial;
		max-height: unset;
	}
	.samTimeToWait
	{
		color: ' . $__templater->func('property', array('textColorAttention', ), false) . ';
		font-size: 12px;
	}
');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('siropu_ads_manager_wrapper', $__vars);
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['packages'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			';
		if ($__templater->func('count', array($__vars['types'], ), false) > 1) {
			$__finalCompiled .= '
				<h2 class="block-tabHeader tabs hScroller" data-xf-init="h-scroller">
					<span class="hScroller-scroll">
						<a href="' . $__templater->func('link', array('ads-manager/packages', ), true) . '" class="tabs-tab' . (($__vars['type'] == '') ? ' is-active' : '') . '">' . 'All packages' . '</a>
						';
			if ($__vars['types']['code']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'code', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'code') ? ' is-active' : '') . '">' . 'Code' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['banner']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'banner', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'banner') ? ' is-active' : '') . '">' . 'Banner' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['text']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'text', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'text') ? ' is-active' : '') . '">' . 'Text' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['link']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'link', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'link') ? ' is-active' : '') . '">' . 'Link' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['keyword']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'keyword', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'keyword') ? ' is-active' : '') . '">' . 'Keyword' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['sticky']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'sticky', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'sticky') ? ' is-active' : '') . '">' . 'Sticky thread' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['thread']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'thread', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'thread') ? ' is-active' : '') . '">' . 'Promo thread' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['resource']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'resource', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'resource') ? ' is-active' : '') . '">' . 'Featured resource' . '</a>
						';
			}
			$__finalCompiled .= '
						';
			if ($__vars['types']['custom']) {
				$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ads-manager/packages', '', array('type' => 'custom', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'custom') ? ' is-active' : '') . '">' . 'Custom service' . '</a>
						';
			}
			$__finalCompiled .= '
					</span>
				</h2>
			';
		}
		$__finalCompiled .= '
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['packages'])) {
			foreach ($__vars['packages'] AS $__vars['package']) {
				$__compilerTemp1 .= '
						<tbody class="dataList-rowGroup">
							';
				$__compilerTemp2 = '';
				if ($__vars['package']['discount'] AND ($__vars['package']['min_purchase'] < $__vars['package']['max_purchase'])) {
					$__compilerTemp2 .= '
										<a href="' . $__templater->func('link', array('ads-manager/packages/discounts', $__vars['package'], ), true) . '" data-xf-click="overlay" style="font-size: 10px; display: block;">' . 'View discounts' . '</a>
									';
				}
				$__compilerTemp3 = '';
				if ($__vars['package']['empty_slot_count'] == 0) {
					$__compilerTemp3 .= '
										';
					if (!$__templater->method($__vars['package'], 'isCostPer', array(array('cpm', 'cpc', ), ))) {
						$__compilerTemp3 .= '
											<i class="far fa-info-circle" aria-hidden="true" title="' . $__templater->filter('Time to wait' . $__vars['xf']['language']['label_separator'], array(array('for_attr', array()),), true) . ' ' . $__templater->filter($__templater->method($__vars['package'], 'getTimeToWait', array()), array(array('for_attr', array()),), true) . '" data-xf-init="tooltip"></i>
										';
					} else {
						$__compilerTemp3 .= '
											0
										';
					}
					$__compilerTemp3 .= '
									';
				} else {
					$__compilerTemp3 .= '
										' . $__templater->escape($__vars['package']['empty_slot_count']) . '
									';
				}
				$__compilerTemp4 = '';
				if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('siropuAdsManager', 'useDeviceCriteria', )) AND (!$__templater->method($__vars['package'], 'hasNoCriteria', array()))) {
					$__compilerTemp4 .= '
										<i class="fas fa-tablet-alt" aria-hidden="true" data-xf-init="tooltip" title="' . $__templater->filter('Device criteria: Target your ad based on user device type, platform and browser.', array(array('for_attr', array()),), true) . '"></i>
									';
				}
				$__compilerTemp5 = '';
				if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('siropuAdsManager', 'useGeoCriteria', )) AND (!$__templater->method($__vars['package'], 'hasNoCriteria', array()))) {
					$__compilerTemp5 .= '
										<i class="fas fa-globe" aria-hidden="true" data-xf-init="tooltip" title="' . $__templater->filter('Geo criteria: Target your ad based on the user country.', array(array('for_attr', array()),), true) . '"></i>
									';
				}
				$__compilerTemp6 = '';
				if ($__templater->method($__vars['package'], 'hasPreviewImage', array())) {
					$__compilerTemp6 .= '
										';
					$__templater->includeCss('lightbox.less');
					$__compilerTemp6 .= '
										';
					$__templater->includeJs(array(
						'prod' => 'xf/lightbox-compiled.js',
						'dev' => 'vendor/lightgallery/lightgallery-all.min.js, xf/lightbox.js',
					));
					$__compilerTemp6 .= '
										' . $__templater->button('Position preview', array(
						'href' => $__templater->method($__vars['package'], 'getAbsoluteFilePath', array($__vars['package']['preview'], )),
						'target' => '_blank',
						'class' => 'js-lbImage button--link',
						'fa' => 'fas fa-eye',
					), '', array(
					)) . '
									';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['package']['title']),
					'href' => $__templater->func('link', array('ads-manager/packages/create-ad', $__vars['package'], ), false),
					'explain' => ($__vars['package']['description'] ? $__templater->filter($__vars['package']['description'], array(array('raw', array()),), true) : ''),
				), array(array(
					'width' => '10%',
					'_type' => 'cell',
					'html' => $__templater->func('sam_type_phrase', array($__vars['package']['type'], ), true),
				),
				array(
					'width' => '20%',
					'_type' => 'cell',
					'html' => '
									' . $__templater->escape($__vars['package']['cost']) . ' ' . ($__templater->method($__vars['package'], 'isFree', array()) ? (('(' . $__templater->escape($__templater->method($__vars['package'], 'getMinimumLength', array()))) . ')') : '') . '
									' . $__compilerTemp2 . '
								',
				),
				array(
					'width' => '10%',
					'_type' => 'cell',
					'html' => '
									' . $__compilerTemp3 . '
								',
				),
				array(
					'width' => '10%',
					'_type' => 'cell',
					'html' => '
									' . $__compilerTemp4 . '
									' . $__compilerTemp5 . '
								',
				),
				array(
					'width' => '10%',
					'data-xf-init' => 'lightbox',
					'data-lb-single-image' => '1',
					'data-lb-trigger' => '.js-lbImage',
					'_type' => 'cell',
					'html' => '
									' . $__compilerTemp6 . '
								',
				),
				array(
					'width' => '10%',
					'class' => 'dataList-cell--separated',
					'_type' => 'cell',
					'html' => '
									' . $__templater->button('Create ad', array(
					'href' => $__templater->func('link', array('ads-manager/packages/create-ad', $__vars['package'], ), false),
					'class' => 'button--cta',
					'icon' => 'add',
				), '', array(
				)) . '
								',
				))) . '
						</tbody>
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Package',
		),
		array(
			'_type' => 'cell',
			'html' => 'Type',
		),
		array(
			'_type' => 'cell',
			'html' => 'Cost',
		),
		array(
			'_type' => 'cell',
			'html' => 'Empty slots',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '
					' . $__compilerTemp1 . '
				', array(
		)) . '
			</div>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'We are sorry, currently there are no advertising packages available.' . '</div>
';
	}
	return $__finalCompiled;
}
);