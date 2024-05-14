<?php
// FROM HASH: e0cea09b2c33103540570d31f908a7de
return array(
'macros' => array('review_simple' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'item' => '',
		'route' => 'bh-item/review',
	); },
'extensions' => array('footer' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
					' . $__templater->callMacro(null, 'review_footer', array(
		'review' => $__vars['review'],
		'route' => $__vars['route'],
	), $__vars) . '
				';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	';
	$__templater->includeCss('bh_item_attachment_list.less');
	$__finalCompiled .= '
	
	
	<span class="u-anchorTarget" id="item-review-' . $__templater->escape($__vars['review']['item_rating_id']) . '"></span>
	
	<div class="contentRow js-itemReview js-itemReview-' . $__templater->escape($__vars['item']['item_id']) . '-' . $__templater->escape($__vars['review']['item_rating_id']) . '" id="js-itemReview-' . $__templater->escape($__vars['review']['item_rating_id']) . '">
		<div class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['review']['User'], 'xxs', false, array(
	))) . '
		</div>
		<div class="contentRow-main contentRow-main--close">
			<div class="contentRow-lesser">
				' . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['review']['rating'],
		'class' => 'ratingStars--smaller',
	), $__vars) . ' 
			</div>
			<div class="contentRow-minor contentRow-minor--smaller">
				<ul class="listInline listInline--bullet">
					<li>
							' . ($__templater->escape($__vars['review']['User']['username']) ?: 'Deleted member') . '
					</li>
					<li>' . $__templater->func('date_dynamic', array($__vars['review']['rating_date'], array(
	))) . '</li>
					';
	if (!$__templater->test($__vars['item'], 'empty', array())) {
		$__finalCompiled .= '
						<li><a href="' . $__templater->func('link', array('bh-item', $__vars['item'], ), true) . '" target="_blank">' . $__templater->escape($__vars['item']['item_title']) . '</a> ' . $__templater->escape($__vars['item']['brand_title']) . '</li>
					';
	}
	$__finalCompiled .= '
				</ul>
			</div>
			
			';
	if ($__vars['review']['rating_state'] == 'deleted') {
		$__finalCompiled .= '
				<div class="messageNotice messageNotice--deleted">
					' . $__templater->callMacro('deletion_macros', 'notice', array(
			'log' => $__vars['review']['DeletionLog'],
		), $__vars) . '
				</div>
			';
	}
	$__finalCompiled .= '
			<div class="contentRow-lesser">' . $__templater->func('bb_code', array($__vars['review']['message'], 'message', $__vars['review'], ), true) . '</div>
	
			';
	if (!$__templater->test($__vars['review']['Attachment'], 'empty', array())) {
		$__finalCompiled .= '
				
				' . $__templater->callMacro(null, 'reviewAttachments', array(
			'review' => $__vars['review'],
		), $__vars) . '
				
				
				' . '
			
			';
	}
	$__finalCompiled .= '
			
			
		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '

					';
	$__vars['hasActionBarMenu'] = false;
	$__compilerTemp1 .= '
					';
	if ($__templater->method($__vars['review'], 'canDelete', array('soft', ))) {
		$__compilerTemp1 .= '
						<a href="' . $__templater->func('link', array($__vars['route'] . '/delete', $__vars['review'], ), true) . '"
						   class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
						   data-xf-click="overlay" data-cache="false">
							' . 'Delete' . '
						</a>
						';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp1 .= '
					';
	}
	$__compilerTemp1 .= '
					';
	if (($__vars['review']['rating_state'] == 'deleted') AND $__templater->method($__vars['review'], 'canUndelete', array())) {
		$__compilerTemp1 .= '
						<a href="' . $__templater->func('link', array($__vars['route'] . '/undelete', $__vars['review'], ), true) . '"
						   class="actionBar-action actionBar-action--undelete actionBar-action--menuItem"
						   data-xf-click="overlay" data-cache="false">
							' . 'Undelete' . '
						</a>
						';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp1 .= '
					';
	}
	$__compilerTemp1 .= '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			<div class="actionBar-set actionBar-set--internal">
				' . $__compilerTemp1 . '
			</div>
		';
	}
	$__finalCompiled .= '
	
			';
	if ($__templater->method($__vars['review'], 'canReact', array())) {
		$__finalCompiled .= '
				' . $__templater->renderExtension('footer', $__vars, $__extensions) . '
			';
	}
	$__finalCompiled .= '
						
		</div>
	</div>

';
	return $__finalCompiled;
}
),
'reviewAttachments' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
		' . $__templater->callMacro('lightbox_macros', 'setup', array(
		'canViewAttachments' => 'true',
	), $__vars) . '
			<div class="itemList itemList--strip js-filmStrip" style="justify-content: start;">
				';
	if ($__templater->isTraversable($__vars['review']['Attachment'])) {
		foreach ($__vars['review']['Attachment'] AS $__vars['attach']) {
			$__finalCompiled .= '
					
					<div class="js-filmStrip-item itemList-item">						
						<a class="file-preview js-lbImage" href="' . $__templater->escape($__vars['attach']['direct_url']) . '" target="_blank">
							<span class="xfmgThumbnail xfmgThumbnail--image xfmgThumbnail--fluid xfmgThumbnail--iconSmallest">
								<img class="xfmgThumbnail-image" src="' . $__templater->escape($__vars['attach']['thumbnail_url']) . '" alt="' . $__templater->escape($__vars['attach']['filename']) . '" loading="lazy" />
								<span class="xfmgThumbnail-icon"></span>
							</span>
						</a>
					</div>
				';
		}
	}
	$__finalCompiled .= '
			</div>
';
	return $__finalCompiled;
}
),
'review_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'route' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<footer class="message-footer">
		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					' . $__templater->callMacro(null, 'review_action_bar', array(
		'review' => $__vars['review'],
		'route' => $__vars['route'],
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

		<div class="reactionsBar js-review-reactionsList ' . ($__vars['review']['reactions'] ? 'is-active' : '') . '">
			' . $__templater->func('reactions', array($__vars['review'], $__vars['route'] . '/reactions', array())) . '
		</div>

		<div class="js-historyTarget message-historyTarget toggleTarget" data-href="trigger-href"></div>
	</footer>
';
	return $__finalCompiled;
}
),
'review_action_bar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'route' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				' . $__templater->func('react', array(array(
		'content' => $__vars['review'],
		'link' => $__vars['route'] . '/react',
		'list' => '< .js-itemReview | .js-review-reactionsList',
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
	$__finalCompiled .= '


' . '


' . '


';
	return $__finalCompiled;
}
);