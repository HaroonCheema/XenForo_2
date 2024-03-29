<?php
// FROM HASH: 278e09e637ae560f83c36a34f467ffe2
return array(
'extensions' => array('footer' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				' . $__templater->callMacro(null, 'page_reaction_footer', array(
		'ownerPage' => $__vars['ownerPage'],
	), $__vars) . '
			';
	return $__finalCompiled;
}),
'macros' => array('page_reaction_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ownerPage' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<footer class="message-footer">
		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					' . $__templater->callMacro(null, 'page_action_bar', array(
		'ownerPage' => $__vars['ownerPage'],
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

		<div class="reactionsBar js-ownerPage-reactionsList ' . ($__vars['ownerPage']['reactions'] ? 'is-active' : '') . '">
					' . $__templater->func('reactions', array($__vars['ownerPage'], 'owners/reactions', array())) . '
		</div>

		<div class="js-historyTarget message-historyTarget toggleTarget" data-href="trigger-href"></div>
	</footer>
';
	return $__finalCompiled;
}
),
'page_action_bar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ownerPage' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			' . $__templater->func('react', array(array(
		'content' => $__vars['ownerPage'],
		'link' => 'owners/react',
		'list' => '.js-ownerPage-reactionsList',
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
	if ($__vars['ownerPage']['title']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['ownerPage']['title']));
		$__finalCompiled .= '<br>
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('' . $__templater->escape($__vars['ownerPage']['User']['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' ');
		$__finalCompiled .= '<br>
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['ownerPage'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '


';
	$__compilerTemp1 = '';
	if ($__vars['alreadySub']) {
		$__compilerTemp1 .= '
		<div class="block">
			<div class="block-container bh_center">
				' . 'You have Followed' . '
			</div>
		</div>
	';
	} else {
		$__compilerTemp1 .= '
		' . $__templater->button('Follow The Owner Page', array(
			'href' => $__templater->func('link', array('owners/pagesub', $__vars['ownerPage'], ), false),
			'class' => 'button--fullWidth',
		), '', array(
		)) . '
	';
	}
	$__compilerTemp2 = '';
	if (($__vars['ownerPage']['user_id'] == $__vars['xf']['visitor']['user_id']) AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_can_delete_Ownerpage', ))) {
		$__compilerTemp2 .= '
		' . $__templater->button('Delete Owner Page', array(
			'href' => $__templater->func('link', array('owners/delete', $__vars['ownerPage'], ), false),
			'class' => '',
			'overlay' => 'true',
		), '', array(
		)) . '
	';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('

	' . $__compilerTemp1 . '
	<br/>
	
	' . $__templater->button('Main Photo', array(
		'href' => $__templater->func('link', array('owners/mainphoto', $__vars['ownerPage'], ), false),
		'class' => '',
		'overlay' => 'true',
	), '', array(
	)) . '
	' . $__compilerTemp2 . '
');
	$__finalCompiled .= '


';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '
		

';
	if ($__vars['filmStripParams']) {
		$__finalCompiled .= '
<div class="media">
	
	';
		if ($__vars['filmStripParams']['prevItem']) {
			$__finalCompiled .= '
		
	<a href="' . $__templater->func('link', array('owners', $__vars['ownerPage'], array('attachment_id' => $__vars['filmStripParams']['prevItem']['attachment_id'], ), ), true) . '" class="media-button media-button--prev" data-xf-key="ArrowLeft"><i class="media-button-icon"></i></a>	
	
		';
		}
		$__finalCompiled .= '

		 <div class="media-container">

     	';
		if ($__vars['mainItem']) {
			$__finalCompiled .= '
        ' . $__templater->callMacro('bh_page_filmstrip_view_macros', 'main_content', array(
				'mainItem' => $__vars['mainItem'],
				'item' => $__vars['ownerPage'],
			), $__vars) . '
		 ';
		}
		$__finalCompiled .= '
		</div>
	
	

	';
		if ($__vars['filmStripParams']['nextItem']) {
			$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('owners', $__vars['ownerPage'], array('attachment_id' => $__vars['filmStripParams']['nextItem']['attachment_id'], ), ), true) . '" class="media-button media-button--next" data-xf-key="ArrowRight"><i class="media-button-icon"></i></a>
	
	';
		}
		$__finalCompiled .= '
		
</div>

	
 <div class="block js-mediaInfoBlock">
	
	';
		if ($__vars['filmStripParams']['Items']) {
			$__finalCompiled .= '
	' . $__templater->callMacro('bh_page_filmstrip_view_macros', 'attachment_film_strip', array(
				'mainItem' => $__vars['mainItem'],
				'filmStripParams' => $__vars['filmStripParams'],
				'item' => $__vars['ownerPage'],
			), $__vars) . '
	 ';
		}
		$__finalCompiled .= '
</div>
		';
	}
	$__finalCompiled .= '


		
	
<div class=\'clearfix\'></div>

<div class="block-container" style="border: 2px solid orange;">
	<div class="block-row">
	<blockquote class="message-body">
	
     <h1>' . 'About ' . $__templater->escape($__vars['ownerPage']['User']['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . '' . '</h1>

		
		' . $__templater->func('bb_code', array($__vars['ownerPage']['Detail']['about'], 'about', $__vars['ownerPage']['Detail'], ), true) . '<br>
		
		' . '
		
		';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_can_edit_ownerpage', )) AND ($__vars['xf']['visitor']['user_id'] == $__vars['ownerPage']['user_id'])) {
		$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('owners/edit', $__vars['ownerPage'], ), true) . '"  data-xf-click="overlay">' . 'Edit' . '</a>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'react_page', )) AND $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			' . $__templater->renderExtension('footer', $__vars, $__extensions) . '
		';
	}
	$__finalCompiled .= '
	</blockquote>
	</div>
</div>


<div class=\'clearfix\'></div>
' . $__templater->includeTemplate('bh_ownerPage_posts', $__vars) . '




<div class=\'clearfix\'></div>
<div class="block">
	<div class="block-container">
		<div class="block-header">
			<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['ownerPage']['User']['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Topics' . ' (' . $__templater->escape($__vars['ownerPage']['discussion_count']) . ')</h3>
			<div class="p-description">' . 'Here are the most recent ' . $__templater->escape($__vars['item']['item_title']) . ' topics from our community.' . '</div>
		</div>
		<div class="block-body block-row block-row--separated">
			<div class="block-body">

				';
	if (!$__templater->test($__vars['discussions'], 'empty', array())) {
		$__finalCompiled .= '
					';
		$__compilerTemp3 = '';
		if ($__templater->isTraversable($__vars['discussions'])) {
			foreach ($__vars['discussions'] AS $__vars['discussion']) {
				$__compilerTemp3 .= '
								' . $__templater->callMacro('bh_brand_hub_macros', 'itemDiscussion', array(
					'discussion' => $__vars['discussion'],
				), $__vars) . '
							';
			}
		}
		$__compilerTemp4 = '';
		if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_canEditDiscussionDesc', ))) {
			$__compilerTemp4 .= '
							<div class="block-footer block-footer--split">
								';
			if ($__vars['ownerPage']['discussion_count'] > $__vars['xf']['options']['bh_discussions_on_item']) {
				$__compilerTemp4 .= '
									<span class="block-footer-counter"><a href="' . $__templater->func('link', array('owners/pagethreads', $__vars['ownerPage'], ), true) . '" target="_blank">' . 'View More Threads' . '&nbsp;&nbsp;<i class="fal fa-greater-than"></i></a></span>
									';
			} else {
				$__compilerTemp4 .= '
									<span class="block-footer-counter"></span>
								';
			}
			$__compilerTemp4 .= '

								<span class="block-footer-select">' . $__templater->formCheckBox(array(
				'standalone' => 'true',
			), array(array(
				'check-all' => '.dataList',
				'label' => 'Select all',
				'_type' => 'option',
			))) . '</span>
								<span class="block-footer-controls">' . $__templater->button('', array(
				'type' => 'submit',
				'name' => 'quickdelete',
				'value' => '1',
				'icon' => 'delete',
			), '', array(
			)) . '</span>
							</div>
						';
		}
		$__finalCompiled .= $__templater->form('

						' . $__templater->dataList('

							' . $__compilerTemp3 . '

						', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '

						' . $__compilerTemp4 . '
					', array(
			'action' => $__templater->func('link', array('bh-item/quick-delete', $__vars['item'], ), false),
			'ajax' => 'true',
			'data-xf-init' => 'select-plus',
			'data-sp-checkbox' => '.dataList-cell--toggle input:checkbox',
			'data-sp-container' => '.dataList-row',
			'data-sp-control' => '.dataList-cell a',
		)) . '
				';
	} else {
		$__finalCompiled .= '
					<div class="blockMessage">' . 'No results found.' . '</div>
				';
	}
	$__finalCompiled .= '


			</div>
		</div>			
	</div>
</div>


<div class=\'clearfix\'></div>
' . $__templater->includeTemplate('bh_user_review', $__vars) . '
	


		

		';
	$__compilerTemp5 = '';
	$__compilerTemp6 = '';
	$__compilerTemp6 .= '
										';
	$__compilerTemp7 = '';
	if ($__vars['pageRanking']['view_rank']) {
		$__compilerTemp7 .= '
												' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['pageRanking']['view_rank']) . ' most Viewed',
		))) . '	
											';
	}
	$__compilerTemp8 = '';
	if ($__vars['pageRanking']['discussion_rank']) {
		$__compilerTemp8 .= '
												' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['pageRanking']['discussion_rank']) . ' most Discussions',
		))) . '	
											';
	}
	$__compilerTemp9 = '';
	if ($__vars['pageRanking']['reaction_rank']) {
		$__compilerTemp9 .= '
												' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['pageRanking']['reaction_rank']) . ' most Reactions',
		))) . '	
											';
	}
	$__compilerTemp10 = '';
	if ($__vars['pageRanking']['follow_rank']) {
		$__compilerTemp10 .= '
												' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['pageRanking']['follow_rank']) . ' most Followed',
		))) . '	
											';
	}
	$__compilerTemp11 = '';
	if ($__vars['pageRanking']['attachment_rank']) {
		$__compilerTemp11 .= '
												' . $__templater->dataRow(array(
		), array(array(
			'_type' => 'cell',
			'html' => '#' . $__templater->escape($__vars['pageRanking']['attachment_rank']) . ' most Photos',
		))) . '	
											';
	}
	$__compilerTemp6 .= $__templater->dataList('

											' . $__compilerTemp7 . '

											' . $__compilerTemp8 . '

											' . $__compilerTemp9 . '

											' . $__compilerTemp10 . '
											' . $__compilerTemp11 . '
										', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
								';
	if (strlen(trim($__compilerTemp6)) > 0) {
		$__compilerTemp5 .= '
         
					<h2 class="block-minorHeader">' . '' . $__templater->escape($__vars['ownerPage']['User']['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Rankings' . '</h2>
					
 						<div class="block-body block-row">

									' . $__compilerTemp6 . '


								<br><br>

							</div>
					';
	}
	$__templater->modifySidebarHtml('', '
			<div class="block">
				<div class="block-container">
					' . $__compilerTemp5 . '
				</div>
			</div>
		', 'replace');
	$__finalCompiled .= '



' . $__templater->callMacro('bh_ad_macros', 'sideBar_pageside', array(), $__vars) . '

' . '


';
	return $__finalCompiled;
}
);