<?php
// FROM HASH: b89e103fc6986bf4e283be97db11bcb0
return array(
'extensions' => array('footer' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				' . $__templater->callMacro(null, 'item_reaction_footer', array(
		'item' => $__vars['item'],
	), $__vars) . '
			';
	return $__finalCompiled;
}),
'macros' => array('navigation' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'pageSelected' => '!',
		'route' => '',
		'item' => '',
		'alreadySub' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	
	';
	if ($__templater->func('property', array('findThreadsNavStyle', ), false) == 'tabs') {
		$__finalCompiled .= '
		
		' . $__templater->includeTemplate('whiteThreeButton', $__vars) . '
		
		<div class="tabs tabs--standalone">
			
			
			<div class="hScroller" data-xf-init="h-scroller">
				<span class="hScroller-scroll">
					' . $__templater->callMacro(null, 'links', array(
			'pageSelected' => $__vars['pageSelected'],
			'baseClass' => 'tabs-tab',
			'selectedClass' => 'is-active',
			'route' => $__vars['route'],
			'item' => $__vars['item'],
		), $__vars) . '
				</span>
			</div>
		</div>
	
		';
		$__templater->setPageParam('sideNavTitle', 'Brand list');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'links' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'pageSelected' => '!',
		'baseClass' => '!',
		'selectedClass' => '!',
		'route' => '',
		'item' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
   
	
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'overview') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'], $__vars['item'], ), true) . '" rel="nofollow">' . 'Overview' . '</a>
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'discussion') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'] . '/#discussion', $__vars['item'], ), true) . '" rel="nofollow">' . 'Discussion' . '</a>
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'reviews') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'] . '/#reviews', $__vars['item'], ), true) . '" rel="nofollow">' . 'Reviews' . '</a>
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'ownerPage') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'] . '/#ownerPage', $__vars['item'], ), true) . '" rel="nofollow">' . 'Owner Pages' . '</a>
';
	return $__finalCompiled;
}
),
'item_reaction_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'item' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<footer class="message-footer">
		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					' . $__templater->callMacro(null, 'item_action_bar', array(
		'item' => $__vars['item'],
	), $__vars) . '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			<div class="message-actionBar actionBar">
				' . $__compilerTemp1 . '
			</div>
		';
	}
	$__finalCompiled .= '

		<div class="reactionsBar js-reactionsList ' . ($__vars['item']['reactions'] ? 'is-active' : '') . '">
					' . $__templater->func('reactions', array($__vars['item'], 'bh-item/reactions', array())) . '
		</div>

		<div class="js-historyTarget message-historyTarget toggleTarget" data-href="trigger-href"></div>
	</footer>
';
	return $__finalCompiled;
}
),
'item_action_bar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'item' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			' . $__templater->func('react', array(array(
		'content' => $__vars['item'],
		'link' => 'bh-item/react',
		'list' => '.js-reactionsList',
	))) . '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="actionBar-set actionBar-set--external">
		' . $__compilerTemp1 . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Resource Page');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Information, reviews, photos, discussion topics, owner pages, and specifications about the ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . '.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped('
	' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' <span class="item-rating">' . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['item']['rating_avg'],
		'class' => 'ratingStars--smaller',
	), $__vars) . '(' . $__templater->escape($__vars['item']['rating_count']) . ')</span>
');
	$__finalCompiled .= '
<div>' . $__templater->escape($__vars['item']['Category']['category_title']) . ' </div>


';
	$__templater->breadcrumbs($__templater->method($__vars['item'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_canUploadPhotos', ))) {
		$__compilerTemp1 .= '
		' . $__templater->button('Upload Photos', array(
			'href' => $__templater->func('link', array('bh-item/uploadphoto', $__vars['item'], ), false),
			'class' => 'button--cta',
			'overlay' => 'true',
		), '', array(
		)) . '
	';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_canSetItemMainPhoto', ))) {
		$__compilerTemp2 .= '
 		' . $__templater->button('Main Photo', array(
			'href' => $__templater->func('link', array('bh-item/mainphoto', $__vars['item'], ), false),
			'class' => '',
			'overlay' => 'true',
		), '', array(
		)) . '
	';
	}
	$__compilerTemp3 = '';
	if ($__vars['xf']['visitor']['is_admin']) {
		$__compilerTemp3 .= '
		' . $__templater->button('Edit this Item', array(
			'href' => $__templater->func('link_type', array('admin', 'bh_item/edit', $__vars['item'], ), false),
			'class' => '',
			'target' => '_blank',
		), '', array(
		)) . '
	';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	
	' . $__compilerTemp1 . '
	
	' . $__compilerTemp2 . '
	
	' . $__compilerTemp3 . '
');
	$__finalCompiled .= '

<div class="itemPageNav">
	
	<br>
	<div style="float:right;">
		' . $__templater->callMacro(null, 'navigation', array(
		'pageSelected' => $__vars['pageSelected'],
		'route' => $__vars['xf']['options']['bh_main_route'] . '/item',
		'alreadySub' => $__vars['alreadySub'],
		'item' => $__vars['item'],
	), $__vars) . '
	</div>	
		
</div>
<div class="clearfix"></div>



';
	if ($__vars['filmStripParams']) {
		$__finalCompiled .= '
<div class="media">
	
	';
		if ($__vars['filmStripParams']['prevItem']) {
			$__finalCompiled .= '
		
	<a href="' . $__templater->func('link', array($__vars['xf']['options']['bh_main_route'] . '/item', $__vars['item'], array('attachment_id' => $__vars['filmStripParams']['prevItem']['attachment_id'], ), ), true) . '" class="media-button media-button--prev" data-xf-key="ArrowLeft"><i class="media-button-icon"></i></a>	
	
		';
		}
		$__finalCompiled .= '

		 <div class="media-container">

     	';
		if ($__vars['mainItem']) {
			$__finalCompiled .= '
        ' . $__templater->callMacro('bh_item_filmstrip_view_macros', 'main_content', array(
				'mainItem' => $__vars['mainItem'],
				'item' => $__vars['item'],
			), $__vars) . '
		 ';
		}
		$__finalCompiled .= '
		</div>
	
	

	';
		if ($__vars['filmStripParams']['nextItem']) {
			$__finalCompiled .= '
		<a href="' . $__templater->func('link', array($__vars['xf']['options']['bh_main_route'] . '/item', $__vars['item'], array('attachment_id' => $__vars['filmStripParams']['nextItem']['attachment_id'], ), ), true) . '" class="media-button media-button--next" data-xf-key="ArrowRight"><i class="media-button-icon"></i></a>
	
	';
		}
		$__finalCompiled .= '
		
</div>

	
 <div class="block js-mediaInfoBlock">
	 
	';
		if ($__vars['filmStripParams']['Items']) {
			$__finalCompiled .= '
	' . $__templater->callMacro('bh_item_filmstrip_view_macros', 'attachment_film_strip', array(
				'mainItem' => $__vars['mainItem'],
				'filmStripParams' => $__vars['filmStripParams'],
				'item' => $__vars['item'],
			), $__vars) . '
	 ';
		}
		$__finalCompiled .= '
</div>
		';
	}
	$__finalCompiled .= '


		
	';
	$__compilerTemp4 = '';
	$__compilerTemp5 = '';
	$__compilerTemp5 .= '
								   ' . $__templater->callMacro('item_custom_fields_macros_public', 'custom_fields_view', array(
		'type' => 'bhItemfield',
		'group' => 'below_record',
		'onlyInclude' => $__vars['category']['field_cache'],
		'set' => $__vars['item']['custom_fields'],
		'rowType' => 'noGutter',
		'rowClass' => 'mediaItem-input',
		'wrapperClass' => 'resourceBody-fields resourceBody-fields--before',
	), $__vars) . '
								';
	if (strlen(trim($__compilerTemp5)) > 0) {
		$__compilerTemp4 .= '
						<h3 class="block-minorHeader">' . 'Specifications' . '</h3>
								' . $__compilerTemp5 . '
						';
	}
	$__templater->modifySidebarHtml('shareSidebar', '
			<div class="block">
				<div class="block-container">
					<div class="block-body block-row">
					' . $__compilerTemp4 . '

						</div>
				</div>
			</div>
		', 'replace');
	$__finalCompiled .= '


	';
	$__compilerTemp6 = '';
	$__compilerTemp7 = '';
	$__compilerTemp7 .= '
								';
	$__compilerTemp8 = '';
	if ($__vars['itemPosition']['categoryItemReviewPosition']) {
		$__compilerTemp8 .= '
										' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['itemPosition']['categoryItemReviewPosition']) . ' user rating of ' . $__templater->escape($__vars['itemPosition']['totalcategoryItems']) . ' ' . $__templater->escape($__vars['item']['Category']['category_title']) . ' items',
		))) . '
								';
	}
	$__compilerTemp9 = '';
	if ($__vars['itemPosition']['categoryItemViewPosition']) {
		$__compilerTemp9 .= '
										' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['itemPosition']['categoryItemViewPosition']) . ' Viewed of ' . $__templater->escape($__vars['itemPosition']['totalcategoryItems']) . ' ' . $__templater->escape($__vars['item']['Category']['category_title']) . ' items',
		))) . '	
								';
	}
	$__compilerTemp10 = '';
	if ($__vars['itemPosition']['categoryItemDiscussionPosition']) {
		$__compilerTemp10 .= '
										' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['itemPosition']['categoryItemDiscussionPosition']) . ' discussed of ' . $__templater->escape($__vars['itemPosition']['totalcategoryItems']) . ' ' . $__templater->escape($__vars['item']['Category']['category_title']) . ' items',
		))) . '
								';
	}
	$__compilerTemp11 = '';
	if ($__vars['itemPosition']['overallItemReviewPosition']) {
		$__compilerTemp11 .= '
										' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['itemPosition']['overallItemReviewPosition']) . ' user rating of ' . $__templater->escape($__vars['itemPosition']['totalItems']) . ' items overall',
		))) . '	
								';
	}
	$__compilerTemp12 = '';
	if ($__vars['itemPosition']['overallItemViewPosition']) {
		$__compilerTemp12 .= '
										' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['itemPosition']['overallItemViewPosition']) . ' Viewed of ' . $__templater->escape($__vars['itemPosition']['totalItems']) . ' items overall',
		))) . '	
								';
	}
	$__compilerTemp13 = '';
	if ($__vars['itemPosition']['overallItemDiscussionPosition']) {
		$__compilerTemp13 .= '
										' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['itemPosition']['overallItemDiscussionPosition']) . ' discussed of ' . $__templater->escape($__vars['itemPosition']['totalItems']) . ' items overall',
		))) . '	
								';
	}
	$__compilerTemp14 = '';
	if ($__vars['itemPosition']['itemOwnerPageRanking']) {
		$__compilerTemp14 .= '
										' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['itemPosition']['itemOwnerPageRanking']) . ' Ranking of Most-OwnerPages in ' . $__templater->escape($__vars['itemPosition']['totalItems']) . ' items overall',
		))) . '	
								';
	}
	$__compilerTemp7 .= $__templater->dataList('
									
								' . $__compilerTemp8 . '
								' . $__compilerTemp9 . '
									
                          		' . $__compilerTemp10 . '
									
							
								' . $__compilerTemp11 . '
									
								' . $__compilerTemp12 . '
									
								' . $__compilerTemp13 . '
									
									
								' . $__compilerTemp14 . '
									
									
								
								
									
								 ', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
							';
	if (strlen(trim($__compilerTemp7)) > 0) {
		$__compilerTemp6 .= '
 					<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Community Rankings' . '</h3>
						<div class="block-body block-row">

							' . $__compilerTemp7 . '

							</div>
					';
	}
	$__templater->modifySidebarHtml('', '
			<div class="block">
				<div class="block-container">
					' . $__compilerTemp6 . '
				</div>
			</div>
		', 'replace');
	$__finalCompiled .= '

' . $__templater->callMacro('bh_ad_macros', 'sideBar_itemdetail', array(), $__vars) . '
	<div class=\'clearfix\'></div>

<h3 class="block-body block-row block-row--separated">' . 'About the ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . '' . '</h3><br>
<div class="block-container">
	<div class="block-row">
	<blockquote class="message-body">
		' . $__templater->func('bb_code', array($__vars['item']['Description']['description'], 'description', $__vars['item']['Description'], ), true) . '
		<br>
		';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_can_edit_itemDescript', ))) {
		$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('bh-item/edit', $__vars['item'], ), true) . '" data-xf-click="overlay">' . 'Edit' . '</a>
		';
	}
	$__finalCompiled .= '
		
		
		';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'react', )) AND $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			' . $__templater->renderExtension('footer', $__vars, $__extensions) . '
		';
	}
	$__finalCompiled .= '
	</blockquote>
			</div>
</div>

<div class=\'clearfix\'></div>

';
	$__compilerTemp15 = '';
	$__compilerTemp15 .= '
					' . $__templater->callMacro('item_custom_fields_macros_public', 'custom_fields_view', array(
		'type' => 'bhItemfield',
		'group' => 'above_record',
		'onlyInclude' => $__vars['category']['field_cache'],
		'set' => $__vars['item']['custom_fields'],
		'rowType' => 'noGutter',
		'rowClass' => 'mediaItem-input',
		'wrapperClass' => 'resourceBody-fields resourceBody-fields--before',
	), $__vars) . '
				';
	if (strlen(trim($__compilerTemp15)) > 0) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body block-row">

				<h3 class="block-minorHeader">' . 'Specifications' . '</h3>
				' . $__compilerTemp15 . '
				<br>
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '
<div class=\'clearfix\'></div>


<div class="block" id="discussion">
				<div class="block-container">
					<div class="block-header">
						<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Discussions' . ' (' . $__templater->escape($__vars['item']['discussion_count']) . ')</h3>
						<div class="p-description">' . 'Here are the most recent ' . $__templater->escape($__vars['item']['item_title']) . ' topics from our community.' . '</div>
						
						<div style="float:right;">
							' . $__templater->button('
								' . 'Start a discussion about ' . $__templater->escape($__vars['item']['item_title']) . ' here

' . '
							', array(
		'href' => $__templater->func('link', array('bh-item/post-thread-chooser', $__vars['item'], ), false),
		'class' => 'button--cta',
		'icon' => 'write',
		'overlay' => 'true',
	), '', array(
	)) . '
						</div>
					</div>
							<div class="block-body block-row block-row--separated">
								<div class="block-body">
									
										
										';
	if (!$__templater->test($__vars['discussions'], 'empty', array())) {
		$__finalCompiled .= '
											<ol class="block-body">
												';
		if ($__templater->isTraversable($__vars['discussions'])) {
			foreach ($__vars['discussions'] AS $__vars['discussion']) {
				$__finalCompiled .= '
													' . $__templater->filter($__templater->method($__vars['discussion'], 'render', array(array('mod' => $__vars['activeModType'], ), )), array(array('raw', array()),), true) . '
												';
			}
		}
		$__finalCompiled .= '
											</ol>
										';
	} else {
		$__finalCompiled .= '
											<div class="blockMessage">' . 'No discussions tagged.' . '</div>
										';
	}
	$__finalCompiled .= '
									
									
									<div class="block-footer block-footer--split">
										';
	if ($__vars['item']['discussion_count'] > $__vars['xf']['options']['bh_discussions_on_item']) {
		$__finalCompiled .= '
											<span class="block-footer-counter"><a href="' . $__templater->func('link', array('bh-item/itemthreads', $__vars['item'], ), true) . '" target="_blank">' . 'View all ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Topics' . '&nbsp;&nbsp;<i class="fal fa-greater-than"></i> </a>
												

												<dl class="tagList">
	
													<dd>
														<span class="js-tagList">
															';
		if ($__vars['tags']) {
			$__finalCompiled .= '
																';
			if ($__templater->isTraversable($__vars['tags'])) {
				foreach ($__vars['tags'] AS $__vars['tag']) {
					$__finalCompiled .= '
																	<a href="' . $__templater->func('link', array('tags', $__vars['tag'], ), true) . '" class="tagItem tagItem--tag_' . $__templater->escape($__vars['tag']['tag_url']) . '" dir="auto">
																		' . $__templater->escape($__vars['tag']['tag']) . '
																	</a>
																';
				}
			}
			$__finalCompiled .= '
																';
		} else {
			$__finalCompiled .= '
																' . 'None' . '
															';
		}
		$__finalCompiled .= '
														</span>
													</dd>
												</dl>

											</span>
											
										';
	} else {
		$__finalCompiled .= '
											<span class="block-footer-counter"></span>
										';
	}
	$__finalCompiled .= '
									</div>
									


								</div>
							</div>			
				</div>
			</div>


<div class=\'clearfix\'></div>

' . $__templater->callMacro('bh_ad_macros', 'center_itemdetail1', array(), $__vars) . '
	<div class=\'clearfix\'></div>

' . $__templater->includeTemplate('bh_user_reviews', $__vars) . '
	<div class=\'clearfix\'></div>

' . $__templater->callMacro('bh_ad_macros', 'center_itemdetail2', array(), $__vars) . '
	<div class=\'clearfix\'></div>

' . $__templater->includeTemplate('bh_item_owner_page', $__vars) . '
	<div class=\'clearfix\'></div>




' . '

' . '

' . '


';
	return $__finalCompiled;
}
);