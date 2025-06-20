<?php
// FROM HASH: 6e3eae6f636bbfcd2c116c874ca3ef60
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Select a Brand');
	$__finalCompiled .= '

';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '


' . '
	
<div class="block">
	';
	if (!$__templater->test($__vars['brands'], 'empty', array())) {
		$__finalCompiled .= '
		<div class="block-outer">
			' . $__templater->callMacro('bh_filter_macros', 'quick_filter', array(
			'key' => 'bh_brand',
			'ajax' => $__templater->func('link', array($__vars['xf']['options']['bh_main_route'], null, ), false),
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
	';
	}
	$__finalCompiled .= '
		
<div class="block-container">
	
	' . $__templater->callMacro('bh_overview_macros', 'list_filter_bar', array(
		'filters' => $__vars['filters'],
		'baseLinkPath' => $__vars['xf']['options']['bh_main_route'],
	), $__vars) . '

	
	<div class="block-body">
		';
	if (!$__templater->test($__vars['brands'], 'empty', array())) {
		$__finalCompiled .= '
		    ';
		$__vars['revDirection'] = ($__vars['filters']['direction'] ? (($__vars['filters']['direction'] == 'desc') ? 'asc' : 'desc') : $__vars['xf']['options']['bh_default_direction']);
		$__finalCompiled .= '

			';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['brands'])) {
			foreach ($__vars['brands'] AS $__vars['brand']) {
				$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array($__vars['xf']['options']['bh_main_route'], $__vars['brand'], ), false),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['brand_title']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['discussion_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['view_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['rating_avg']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['review_count']),
				))) . '
				';
			}
		}
		$__finalCompiled .= $__templater->dataList('
				' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => '<a href="' . $__templater->func('link', array($__vars['route'], null, array('order' => 'brand_title', 'direction' => $__vars['revDirection'], ), ), true) . '" rel="nofollow">' . 'Title' . '</a>',
		),
		array(
			'_type' => 'cell',
			'html' => '<a href="' . $__templater->func('link', array($__vars['route'], null, array('order' => 'discussion_count', 'direction' => $__vars['revDirection'], ), ), true) . '" rel="nofollow">' . 'Discussions' . '</a>',
		),
		array(
			'_type' => 'cell',
			'html' => '<a href="' . $__templater->func('link', array($__vars['route'], null, array('order' => 'view_count', 'direction' => $__vars['revDirection'], ), ), true) . '" rel="nofollow">' . 'Views' . '</a>',
		),
		array(
			'_type' => 'cell',
			'html' => '<a href="' . $__templater->func('link', array($__vars['route'], null, array('order' => 'rating_avg', 'direction' => $__vars['revDirection'], ), ), true) . '" rel="nofollow">' . 'Rating average' . '</a>',
		),
		array(
			'_type' => 'cell',
			'html' => '<a href="' . $__templater->func('link', array($__vars['route'], null, array('order' => 'review_count', 'direction' => $__vars['revDirection'], ), ), true) . '" rel="nofollow">' . 'Reviews' . '</a>',
		))) . '
				' . $__compilerTemp1 . '
			', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			
			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['brands'], $__vars['total'], ), true) . '</span>
			</div>
		';
	} else {
		$__finalCompiled .= '
			<div class="blockMessage">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= '
		
	' . $__templater->callMacro('bh_ad_macros', 'sideBar_brand', array(), $__vars) . '
		
	</div>
</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => $__vars['xf']['options']['bh_main_route'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);