<?php
// FROM HASH: 3e83a5df72ba1c309fb0c1fea5093b71
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block" id="ownerPage">
	<div class="block-container">
		<div class="block-header">
			<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['xf']['visitor']['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Owner Page' . '</h3>
			<div class="p-description">' . 'View owner pages to see photos, customization and comments  about member-owner ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . 's' . '</div>
		</div>
		<div class="block-body block-row block-row--separated">
			<div class="block-body">

				<div class="">
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
				

				<span class="' . ($__vars['userItemPage'] ? '' : ((('js-itemPage-' . $__templater->escape($__vars['item']['item_id'])) . '-') . $__templater->escape($__vars['xf']['visitor']['user_id']))) . '">
					';
	if ($__vars['userItemPage']) {
		$__finalCompiled .= '
						<div class="brandHub">		
							<ul class="grid-page-all">
								' . $__templater->callMacro('bh_item_owner_page_all', 'owner_page', array(
			'item' => $__vars['item'],
			'itemPage' => $__vars['userItemPage'],
		), $__vars) . '
							</ul>
						</div>
					';
	} else {
		$__finalCompiled .= '
						<div class="blockMessage">' . '' . $__templater->escape($__vars['xf']['visitor']['username']) . ' has not created an owner page yet.' . '</div>
					';
	}
	$__finalCompiled .= '
				</span>
			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);