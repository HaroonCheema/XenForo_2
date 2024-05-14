<?php
// FROM HASH: 33308bb13bec4e6b8d19b6aa60f6a2bf
return array(
'macros' => array('owner_pages' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'item' => '!',
		'itemPages' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<span class="js-itemPage-' . $__templater->escape($__vars['item']['item_id']) . '-' . $__templater->escape($__vars['xf']['visitor']['user_id']) . '"></span>
	
	';
	if (!$__templater->test($__vars['itemPages'], 'empty', array())) {
		$__finalCompiled .= '
		<div class="brandHub">		
			<ul class="grid-page-all">
				';
		if ($__templater->isTraversable($__vars['itemPages'])) {
			foreach ($__vars['itemPages'] AS $__vars['itemPage']) {
				$__finalCompiled .= '
					' . $__templater->callMacro(null, 'owner_page', array(
					'item' => $__vars['item'],
					'itemPage' => $__vars['itemPage'],
				), $__vars) . '
				';
			}
		}
		$__finalCompiled .= '
			</ul>	
		</div>
	';
	} else {
		$__finalCompiled .= '
		<div class="blockMessage">' . 'No results found.' . '</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'owner_page' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'item' => '!',
		'itemPage' => '!',
		'overlay' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="innerpage js-itemPage-' . $__templater->escape($__vars['item']['item_id']) . '-' . $__templater->escape($__vars['itemPage']['page_id']) . '">
		
		';
	$__vars['pageThumbnailUrl'] = $__templater->method($__vars['itemPage'], 'getthumbnailurl', array());
	$__finalCompiled .= '
		<div class="borderpage">
			<a href="' . $__templater->func('link', array('owners', $__vars['itemPage'], ), true) . '" class="bh_a" target="_blank" data-xf-click="' . $__templater->escape($__vars['overlay']) . '">
				';
	if ($__vars['pageThumbnailUrl']) {
		$__finalCompiled .= '
					<img src="' . $__templater->escape($__vars['pageThumbnailUrl']) . '" class="pageimage" />	
					';
	} else {
		$__finalCompiled .= '
					<i class="fas fa-image fa-6x icon"  ></i><br>
				';
	}
	$__finalCompiled .= '	

				<strong>' . ($__templater->escape($__vars['itemPage']['title']) ?: '' . $__templater->escape($__vars['itemPage']['User']['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' ') . '</strong></a>
		</div>
	</li>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']));
	$__finalCompiled .= '
';
	if ($__vars['page']) {
		$__finalCompiled .= '
	';
		$__templater->breadcrumbs($__templater->method($__vars['page'], 'getBreadcrumbs', array(false, )));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '
<div class="block">
	<div class="block-container">
		' . $__templater->callMacro('bh_overview_macros', 'list_filter_bar', array(
		'filters' => $__vars['filters'],
		'baseLinkPath' => 'owners',
		'content' => $__vars['item'],
	), $__vars) . '
		
		<div class="block-header">
			<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Owner Pages' . '</h3>
			<div class="p-description">' . 'View owner pages to see photos, customization and comments  about member-owner ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . 's' . '</div>
		</div>
		<div class="block-body block-row block-row--separated">
			<div class="block-body">
				<div class="">
					' . '
					
					
					';
	if ($__vars['userItemPage'] AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_can_delete_Ownerpage', ))) {
		$__finalCompiled .= '
						<div style="float:right;margin-left:2px;">
							' . $__templater->button('Delete Owner Page', array(
			'href' => $__templater->func('link', array('owners/delete', $__vars['userItemPage'], ), false),
			'class' => 'button--fullWidth',
			'overlay' => 'true',
			'data-cache' => 'false',
		), '', array(
		)) . '
						</div>
					';
	}
	$__finalCompiled .= '
					
					';
	if (!$__vars['userItemPage']) {
		$__finalCompiled .= '
						<div style="float:right;">
							' . $__templater->button('Create your own ' . $__templater->escape($__vars['item']['item_title']) . ' owner page', array(
			'href' => $__templater->func('link', array('owners/add', $__vars['item'], array('item' => $__vars['item']['item_id'], ), ), false),
			'class' => 'button--fullWidth',
			'overlay' => 'true',
			'data-cache' => 'false',
		), '', array(
		)) . '
						</div>
					';
	} else if ($__vars['userItemPage'] AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_can_edit_ownerpage', ))) {
		$__finalCompiled .= '
						<div style="float:right;">
							' . $__templater->button('Edit Owner Page', array(
			'href' => $__templater->func('link', array('owners/edit', $__vars['userItemPage'], ), false),
			'class' => 'button--fullWidth',
			'overlay' => 'true',
			'data-cache' => 'false',
		), '', array(
		)) . '
						</div>
					';
	}
	$__finalCompiled .= '
				</div>


				<div class="clearfix"></div>


				<div class="block-body">
					' . $__templater->callMacro(null, 'owner_pages', array(
		'item' => $__vars['item'],
		'itemPages' => $__vars['itemPages'],
	), $__vars) . '
				</div>
			</div>
		</div>
	</div>
</div>


' . '


';
	return $__finalCompiled;
}
);