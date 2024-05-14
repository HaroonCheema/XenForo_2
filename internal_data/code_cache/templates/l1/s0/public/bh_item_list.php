<?php
// FROM HASH: 12be3a9ec573b716a546057ee78009ec
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['brandObj']['brand_title']) . ' ' . 'items');
	$__finalCompiled .= '

';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '

' . '

<div class="block">
	
	';
	if (!$__templater->test($__vars['items'], 'empty', array())) {
		$__finalCompiled .= '
		<div class="block-outer">
			' . $__templater->callMacro('bh_filter_macros', 'quick_filter', array(
			'key' => 'bh_item',
			'ajax' => $__templater->func('link', array($__vars['xf']['options']['bh_main_route'] . '/brand', $__vars['brandObj'], ), false),
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
		'content' => $__vars['brandObj'],
	), $__vars) . '
	
	<div class="block-body">
		';
	if (!$__templater->test($__vars['items'], 'empty', array())) {
		$__finalCompiled .= '
			';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['items'])) {
			foreach ($__vars['items'] AS $__vars['item']) {
				$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array($__vars['xf']['options']['bh_main_route'] . '/item', $__vars['item'], ), false),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['item']['item_title']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['item']['discussion_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['item']['view_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['item']['rating_avg']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['item']['review_count']),
				))) . '
				';
			}
		}
		$__finalCompiled .= $__templater->dataList('
				' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Title',
		),
		array(
			'_type' => 'cell',
			'html' => 'Discussions',
		),
		array(
			'_type' => 'cell',
			'html' => 'Views',
		),
		array(
			'_type' => 'cell',
			'html' => 'Rating average',
		),
		array(
			'_type' => 'cell',
			'html' => 'Reviews',
		))) . '
				' . $__compilerTemp1 . '
			', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			
			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['items'], $__vars['total'], ), true) . '</span>
			</div>
		';
	} else {
		$__finalCompiled .= '
			<div class="blockMessage">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= '
		
		
		

			';
	$__templater->modifySidebarHtml('shareSidebar', '
				' . $__templater->callMacro('bh_brand_hub_macros', 'brandRelatedLinks', array(
		'brandObj' => $__vars['brandObj'],
	), $__vars) . '
			', 'replace');
	$__finalCompiled .= '
		
	' . $__templater->callMacro('bh_ad_macros', 'sideBar_itemlist', array(), $__vars) . '
		
	</div>
</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => $__vars['xf']['options']['bh_main_route'],
		'data' => $__vars['brandObj'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>

<div class=\'clearfix\'></div>
	<h4 class="block-body block-row block-row--separated">' . 'About ' . $__templater->escape($__vars['brandObj']['brand_title']) . '' . '</h4><br>

	<div class="block-container">	
		<blockquote class="message-body">
			' . $__templater->func('bb_code', array($__vars['brandObj']['Description']['description'], 'description', $__vars['brandObj']['Description'], ), true) . '
			<br>
			';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_can_edit_brandDescript', ))) {
		$__finalCompiled .= '
			<a href="' . $__templater->func('link', array($__vars['xf']['options']['bh_main_route'] . '/edit', $__vars['brandObj'], ), true) . '" data-xf-click="overlay">' . 'Edit' . '</a>
		';
	}
	$__finalCompiled .= '
		</blockquote>
		
	</div>';
	return $__finalCompiled;
}
);