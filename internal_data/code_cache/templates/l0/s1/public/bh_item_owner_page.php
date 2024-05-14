<?php
// FROM HASH: 149b0c35a5f0ab1ef6e84d0cba287b9e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block" id="ownerPage">
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
					' . $__templater->callMacro('bh_item_owner_page_all', 'owner_pages', array(
		'item' => $__vars['item'],
		'itemPages' => $__vars['itemPages'],
	), $__vars) . '
					
					';
	if ($__vars['itemPages'] AND ($__templater->func('count', array($__vars['itemPages'], ), false) == 10)) {
		$__finalCompiled .= '
						<div style="text-align:center;">
							<a href="' . $__templater->func('link', array('owners', $__vars['item'], ), true) . '" target="_blank">' . 'Load more Owner Pages' . '</a>
						</div>
					';
	}
	$__finalCompiled .= '
				
				</div>
			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);