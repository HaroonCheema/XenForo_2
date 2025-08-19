<?php
// FROM HASH: c6acf9c74cb0146a6331f7ee111287d5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Packages');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		<div class="buttonGroup-buttonWrapper">
			' . $__templater->button('Create package', array(
		'class' => 'menuTrigger',
		'icon' => 'add',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
	), '', array(
	)) . '
			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					<h4 class="menu-header">' . 'Select ad type' . '</h4>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'code', ), ), true) . '" class="menu-linkRow">' . 'Code' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'banner', ), ), true) . '" class="menu-linkRow">' . 'Banner' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'text', ), ), true) . '" class="menu-linkRow">' . 'Text' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'link', ), ), true) . '" class="menu-linkRow">' . 'Link' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'keyword', ), ), true) . '" class="menu-linkRow">' . 'Keyword' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'affiliate', ), ), true) . '" class="menu-linkRow">' . 'Affiliate link' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'sticky', ), ), true) . '" class="menu-linkRow">' . 'Sticky thread' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'thread', ), ), true) . '" class="menu-linkRow">' . 'Promo thread' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'resource', ), ), true) . '" class="menu-linkRow">' . 'Featured resource' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'popup', ), ), true) . '" class="menu-linkRow">' . 'Popup' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'background', ), ), true) . '" class="menu-linkRow">' . 'Background' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'custom', ), ), true) . '" class="menu-linkRow">' . 'Custom service' . '</a>
				</div>
			</div>
		</div>
		<div class="buttonGroup-buttonWrapper">
			' . $__templater->button('&#8226;&#8226;&#8226;', array(
		'class' => 'menuTrigger',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
		'title' => $__templater->filter('More options', array(array('for_attr', array()),), false),
	), '', array(
	)) . '
			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					<h4 class="menu-header">' . 'More options' . '</h4>
					<a href="' . $__templater->func('link', array('ads-manager/packages/import', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Import' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/mass-export', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/packages/manage-placeholders', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Manage placeholders' . '</a>
				</div>
			</div>
		</div>
	</div>
');
	$__finalCompiled .= '

';
	$__templater->includeCss('siropu_ads_manager_admin.less');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['packages'], 'empty', array()) OR !$__templater->test($__vars['filters'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if (!$__templater->test($__vars['packages'], 'empty', array())) {
			$__compilerTemp1 .= '
						';
			if ($__templater->isTraversable($__vars['packages'])) {
				foreach ($__vars['packages'] AS $__vars['adType'] => $__vars['packageList']) {
					$__compilerTemp1 .= '
							<tbody class="dataList-rowGroup">
								';
					if (!$__vars['type']) {
						$__compilerTemp1 .= '
									' . $__templater->dataRow(array(
							'rowtype' => 'subsection',
							'rowclass' => 'dataList-row--noHover',
						), array(array(
							'colspan' => '6',
							'_type' => 'cell',
							'html' => $__templater->func('sam_type_phrase', array($__vars['adType'], ), true),
						))) . '
								';
					}
					$__compilerTemp1 .= '
								';
					if ($__templater->isTraversable($__vars['packageList'])) {
						foreach ($__vars['packageList'] AS $__vars['package']) {
							$__compilerTemp1 .= '
									';
							$__compilerTemp2 = '';
							if (!$__templater->method($__vars['package'], 'isXfItem', array())) {
								$__compilerTemp2 .= '
												' . $__templater->button('', array(
									'href' => $__templater->func('link', array('ads-manager/packages/statistics', $__vars['package'], ), false),
									'class' => 'button--link button--iconOnly',
									'data-xf-init' => 'tooltip',
									'data-xf-click' => 'overlay',
									'title' => $__templater->filter('Package statistics', array(array('for_attr', array()),), false),
									'fa' => 'fas fa-chart-bar',
								), '', array(
								)) . '
											';
							}
							$__compilerTemp1 .= $__templater->dataRow(array(
								'hash' => $__vars['package']['package_id'],
								'href' => $__templater->func('link', array('ads-manager/packages/edit', $__vars['package'], ), false),
								'label' => $__templater->escape($__vars['package']['title']),
								'explain' => 'Total ads' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['package']['ad_count']) . ' / ' . 'Empty slots' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['package']['empty_slot_count']),
								'delete' => $__templater->func('link', array('ads-manager/packages/delete', $__vars['package'], ), false),
								'dir' => 'auto',
							), array(array(
								'width' => '5%',
								'class' => 'dataList-cell--separated',
								'_type' => 'cell',
								'html' => '
											' . $__templater->button('', array(
								'href' => $__templater->func('link', array('ads-manager/ads/add/', '', array('type' => $__vars['package']['type'], 'package_id' => $__vars['package']['package_id'], ), ), false),
								'class' => 'button--link button--iconOnly',
								'data-xf-init' => 'tooltip',
								'title' => $__templater->filter('Create ad', array(array('for_attr', array()),), false),
								'fa' => 'fas fa-plus-square',
							), '', array(
							)) . '
										',
							),
							array(
								'width' => '5%',
								'class' => 'dataList-cell--separated',
								'_type' => 'cell',
								'html' => '
											' . $__templater->button('', array(
								'href' => $__templater->func('link', array('ads-manager/ads', '', array('package_id' => $__vars['package']['package_id'], ), ), false),
								'class' => 'button--link button--iconOnly',
								'data-xf-init' => 'tooltip',
								'title' => $__templater->filter('List ads', array(array('for_attr', array()),), false),
								'fa' => 'fas fa-list',
							), '', array(
							)) . '
										',
							),
							array(
								'width' => '5%',
								'class' => 'dataList-cell--separated',
								'_type' => 'cell',
								'html' => '
											' . $__compilerTemp2 . '
										',
							),
							array(
								'width' => '5%',
								'class' => 'dataList-cell--separated',
								'_type' => 'cell',
								'html' => '
											' . $__templater->callMacro('siropu_ads_manager_package_macros', 'options_menu', array(
								'package' => $__vars['package'],
							), $__vars) . '
										',
							))) . '
								';
						}
					}
					$__compilerTemp1 .= '
							</tbody>
						';
				}
			}
			$__compilerTemp1 .= '
						';
		} else {
			$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
				'rowclass' => 'dataList-row--noHover dataList-row--note',
				'colspan' => '6',
			), array(array(
				'class' => 'dataList-cell--noSearch',
				'_type' => 'cell',
				'html' => '
								' . 'No packages have been found.' . '
							',
			))) . '
					';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'packages',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'type_tabs', array(
			'item' => 'package',
			'route' => 'ads-manager/packages',
			'type' => $__vars['type'],
		), $__vars) . '
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['total'], ), true) . '</span>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/packages/toggle', ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No packages have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);