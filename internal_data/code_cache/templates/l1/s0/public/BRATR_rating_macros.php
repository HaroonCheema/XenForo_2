<?php
// FROM HASH: bc59f5f002878b4e427da2c8dbbc2989
return array(
'macros' => array('google_review_json' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org/",
	  "@type": "Book",
	  "name": "' . $__templater->filter($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), false), array(array('escape', array('json', )),), true) . $__templater->filter($__vars['thread']['title'], array(array('escape', array('json', )),), true) . '",
	  "description": "' . $__templater->filter($__templater->func('snippet', array($__vars['thread']['FirstPost']['message'], 0, array('stripBbCode' => true, ), ), false), array(array('escape', array('json', )),), true) . '",
	  "aggregateRating": {
		"@type": "AggregateRating",
		"ratingValue": "' . $__templater->escape($__vars['thread']['brivium_rating_avg']) . '",
		"bestRating": "5",
		"ratingCount": "' . $__templater->escape($__vars['thread']['brivium_rating_count']) . '"
	  }
	}
	</script>
';
	return $__finalCompiled;
}
),
'stars' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'rating' => '!',
		'class' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['rating'],
		'class' => 'bratr-rating ' . $__vars['class'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'stars_text' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'rating' => '!',
		'count' => null,
		'text' => null,
		'rowClass' => '',
		'starsClass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<span class="ratingStarsRow ' . $__templater->escape($__vars['rowClass']) . '">
		' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
		'rating' => $__vars['rating'],
		'class' => $__vars['starsClass'],
	), $__vars) . '
		<span class="ratingStarsRow-text">
			';
	if (!$__templater->test($__vars['text'], 'empty', array())) {
		$__finalCompiled .= $__templater->escape($__vars['text']);
	} else {
		$__finalCompiled .= (($__vars['count'] == 1) ? '1 Vote' : '' . $__templater->filter($__vars['count'], array(array('number', array()),), true) . ' Votes');
	}
	$__finalCompiled .= '
		</span>
	</span>
';
	return $__finalCompiled;
}
),
'thread_view_rating' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'ratingType' => 'pageaction',
		'row' => true,
		'rowLabel' => 'Rating',
		'rowHint' => '',
		'rowExplain' => '',
		'name' => 'rating',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['thread'], 'canViewUserRated', array())) {
		$__compilerTemp1 .= '
			<div data-href="' . $__templater->filter($__templater->func('link', array('threads/br-user-rated', $__vars['thread'], ), false), array(array('for_attr', array()),), true) . '" data-xf-click="overlay" data-xf-init="tooltip" title="' . $__templater->filter('Members who rated this thread', array(array('for_attr', array()),), true) . '">' . (($__vars['thread']['brivium_rating_count'] == 1) ? '1 Vote' : '' . $__templater->filter($__vars['thread']['brivium_rating_count'], array(array('number', array()),), true) . ' Votes') . '</div>
		';
	} else {
		$__compilerTemp1 .= '
			' . (($__vars['thread']['brivium_rating_count'] == 1) ? '1 Vote' : '' . $__templater->filter($__vars['thread']['brivium_rating_count'], array(array('number', array()),), true) . ' Votes') . '
		';
	}
	$__vars['voteContent'] = $__templater->preEscaped('
		' . $__compilerTemp1 . '
	');
	$__finalCompiled .= '

	';
	if ($__vars['ratingType'] == 'pageaction') {
		$__finalCompiled .= '
		';
		if ($__templater->method($__vars['thread'], 'canRating', array()) AND $__vars['xf']['options']['BRATR_mergeButtonAndDisplay']) {
			$__finalCompiled .= '
			' . $__templater->callMacro('BRATR_rating_macros', 'rating', array(
				'row' => false,
				'currentRating' => $__vars['thread']['brivium_rating_avg'],
				'ratingHref' => $__templater->func('link', array('threads/br-rate', $__vars['thread'], ), false),
				'voteContent' => $__vars['voteContent'],
			), $__vars) . '
		';
		} else if ($__templater->method($__vars['thread'], 'canDisplayThreadRating', array())) {
			$__finalCompiled .= '
			' . $__templater->callMacro('BRATR_rating_macros', 'stars_text', array(
				'rating' => $__vars['thread']['brivium_rating_avg'],
				'count' => $__vars['thread']['brivium_rating_count'],
				'text' => $__vars['voteContent'],
			), $__vars) . '
		';
		}
		$__finalCompiled .= '
	';
	} else if ($__templater->method($__vars['thread'], 'canRating', array()) AND ((!$__templater->method($__vars['thread'], 'canDisplayThreadRating', array())) OR (!$__vars['xf']['options']['BRATR_mergeButtonAndDisplay']))) {
		$__finalCompiled .= '
		' . $__templater->callMacro('BRATR_rating_macros', 'rating', array(
			'row' => $__vars['row'],
			'ratingHref' => $__templater->func('link', array('threads/br-rate', $__vars['thread'], ), false),
			'rowLabel' => $__vars['rowLabel'],
			'rowHint' => $__vars['rowHint'],
			'rowExplain' => $__vars['rowExplain'],
			'name' => $__vars['name'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'rating' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'row' => true,
		'rowType' => $__vars['rowType'],
		'rowLabel' => 'Rating',
		'rowHint' => '',
		'rowExplain' => '',
		'name' => 'rating',
		'currentRating' => '0',
		'ratingHref' => '',
		'readOnly' => 'false',
		'deselectable' => 'false',
		'showSelected' => 'true',
		'voteContent' => null,
		'voteClass' => null,
		'range' => array(1 => 'Terrible', 2 => 'Poor', 3 => 'Average', 4 => 'Good', 5 => 'Excellent', ),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	' . $__templater->callMacro('rating_macros', 'setup', array(), $__vars) . '

	';
	$__compilerTemp1 = array();
	if ($__vars['deselectable']) {
		$__compilerTemp1[] = array(
			'value' => '',
			'_type' => 'option',
		);
	}
	if ($__templater->isTraversable($__vars['range'])) {
		foreach ($__vars['range'] AS $__vars['value'] => $__vars['label']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['value'],
				'label' => $__templater->escape($__vars['label']),
				'_type' => 'option',
			);
		}
	}
	$__vars['inner'] = $__templater->preEscaped('
		' . $__templater->formSelect(array(
		'name' => $__vars['name'],
		'class' => 'br-select',
		'data-xf-init' => 'rating',
		'data-initial-rating' => $__vars['currentRating'],
		'data-rating-href' => $__vars['ratingHref'],
		'data-readonly' => $__vars['readOnly'],
		'data-deselectable' => $__vars['deselectable'],
		'data-show-selected' => $__vars['showSelected'],
		'data-widget-class' => 'bratr-rating',
		'data-vote-content' => $__templater->func('trim', array($__vars['voteContent'], ), false),
		'data-vote-class' => $__vars['voteClass'],
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '

	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['inner'], array(array('raw', array()),), true) . '
		', array(
			'class' => 'u-jsOnly',
			'rowclass' => 'bratr-row-rating',
			'rowtype' => $__vars['rowType'],
			'label' => $__templater->escape($__vars['rowLabel']),
			'hint' => $__templater->filter($__vars['rowHint'], array(array('raw', array()),), true),
			'explain' => $__templater->filter($__vars['rowExplain'], array(array('raw', array()),), true),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->filter($__vars['inner'], array(array('raw', array()),), true) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'review_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'reviews' => '!',
		'listClass' => '',
		'isManagement' => false,
		'linkThread' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<ol class="block-body ' . $__templater->escape($__vars['listClass']) . '">
		';
	if ($__templater->isTraversable($__vars['reviews'])) {
		foreach ($__vars['reviews'] AS $__vars['review']) {
			$__finalCompiled .= '
			<li class="block-row block-row--separated' . ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['review']['user_id'], )) ? ' is-ignored' : '') . '" data-author="' . $__templater->filter($__templater->arrayKey($__templater->method($__vars['review'], 'getUser', array()), 'username'), array(array('for_attr', array()),), true) . '">
				' . $__templater->callMacro('BRATR_rating_macros', 'review', array(
				'review' => $__vars['review'],
				'user' => $__templater->method($__vars['review'], 'getUser', array($__vars['isManagement'], )),
				'thread' => $__vars['review']['Thread'],
				'linkThread' => $__vars['linkThread'],
			), $__vars) . '
			</li>
		';
		}
	}
	$__finalCompiled .= '
	</ol>
';
	return $__finalCompiled;
}
),
'review' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'user' => '!',
		'thread' => '!',
		'linkThread' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['review'], 'isDelete', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro('BRATR_rating_macros', 'review_delete', array(
			'review' => $__vars['review'],
			'user' => $__vars['user'],
			'thread' => $__vars['thread'],
		), $__vars) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->callMacro('BRATR_rating_macros', 'review_public', array(
			'review' => $__vars['review'],
			'user' => $__vars['user'],
			'thread' => $__vars['thread'],
			'linkThread' => $__vars['linkThread'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'review_public' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'user' => '!',
		'thread' => '!',
		'linkThread' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message message--post message--review js-review"
		data-author="' . ($__templater->escape($__vars['review']['User']['username']) ?: $__templater->escape($__vars['review']['username'])) . '"
		data-content="review-' . $__templater->escape($__vars['review']['thread_rating_id']) . '">
		
		<span class="u-anchorTarget" id="review-' . $__templater->escape($__vars['review']['thread_rating_id']) . '"></span>
		
		<div class="contentRow">
			<div class="contentRow-figure">
				' . $__templater->func('avatar', array($__vars['user'], 's', false, array(
		'notooltip' => 'true',
		'defaultname' => $__vars['user']['username'],
	))) . '
			</div>
			<div class="contentRow-main">
				<div class="contentRow-extra">
					' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
		'rating' => $__vars['review']['rating'],
	), $__vars) . '
				</div>
				<h3 class="contentRow-header">' . $__templater->func('username_link', array($__vars['user'], true, array(
		'notooltip' => 'true',
	))) . '</h3>
				
				<div class="contentRow-lesser" dir="auto">
					<article class="message-body">
						' . $__templater->func('bb_code', array($__vars['review']['message'], 'bratr-review', $__vars['review'], ), true) . '
					</article>
				</div>

				';
	if ($__vars['linkThread']) {
		$__finalCompiled .= '
					<dl class="pairs pairs--inline structItem-minor">
						<dt>' . 'Thread' . '</dt>
						<dd><a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . ' ' . $__templater->escape($__vars['thread']['title']) . '</a></dd>
					</dl>
				';
	}
	$__finalCompiled .= '

				<footer class="message-footer">
					';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
								';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
										';
	if ($__templater->method($__vars['review'], 'canLike', array())) {
		$__compilerTemp2 .= '
											<a href="' . $__templater->func('link', array('bratr-ratings/like', $__vars['review'], ), true) . '" class="actionBar-action actionBar-action--like" data-xf-click="like" data-like-list="< .js-review | .js-likeList">';
		if ($__templater->method($__vars['review'], 'isLiked', array())) {
			$__compilerTemp2 .= 'Unlike';
		} else {
			$__compilerTemp2 .= 'Like';
		}
		$__compilerTemp2 .= '</a>
										';
	}
	$__compilerTemp2 .= '
									';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
									<div class="actionBar-set actionBar-set--external">
									' . $__compilerTemp2 . '
									</div>
								';
	}
	$__compilerTemp1 .= '

								';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
										<span class="contentRow-muted">' . $__templater->func('date_dynamic', array($__vars['review']['rating_date'], array(
	))) . '</span>
										
										';
	if ($__templater->method($__vars['review'], 'canReport', array())) {
		$__compilerTemp3 .= '
											<a href="' . $__templater->func('link', array('bratr-ratings/report', $__vars['review'], ), true) . '"
												class="actionBar-action actionBar-action--report"
												data-xf-click="overlay">' . 'Report' . '</a>
										';
	}
	$__compilerTemp3 .= '

										';
	$__vars['hasActionBarMenu'] = false;
	$__compilerTemp3 .= '
										';
	if ($__templater->method($__vars['review'], 'canEdit', array())) {
		$__compilerTemp3 .= '
											<a href="' . $__templater->func('link', array('bratr-ratings/edit', $__vars['review'], ), true) . '"
												class="actionBar-action actionBar-action--edit actionBar-action--menuItem"
												data-xf-click="overlay">' . 'Edit' . '</a>

											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp3 .= '
										';
	}
	$__compilerTemp3 .= '

										';
	if ($__templater->method($__vars['review'], 'canUndelete', array())) {
		$__compilerTemp3 .= '
											<a href="' . $__templater->func('link', array('bratr-ratings/un-delete', $__vars['review'], ), true) . '"
												class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
												data-xf-click="overlay" data-follow-redirects="on">' . 'Undelete' . '</a>

											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp3 .= '
										';
	} else if ($__templater->method($__vars['review'], 'canDelete', array('soft', ))) {
		$__compilerTemp3 .= '
											<a href="' . $__templater->func('link', array('bratr-ratings/delete', $__vars['review'], ), true) . '"
												class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
												data-xf-click="overlay">' . 'Delete' . '</a>

											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp3 .= '
										';
	}
	$__compilerTemp3 .= '

										';
	if ($__templater->method($__vars['review'], 'canWarn', array())) {
		$__compilerTemp3 .= '

											<a href="' . $__templater->func('link', array('bratr-ratings/warn', $__vars['review'], ), true) . '"
												class="actionBar-action actionBar-action--warn actionBar-action--menuItem">' . 'Warn' . '</a>

											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp3 .= '
										';
	} else if ($__vars['review']['warning_id'] AND $__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array())) {
		$__compilerTemp3 .= '
											<a href="' . $__templater->func('link', array('warnings', array('warning_id' => $__vars['review']['warning_id'], ), ), true) . '"
												class="actionBar-action actionBar-action--warn actionBar-action--menuItem"
												data-xf-click="overlay">' . 'View warning' . '</a>
											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp3 .= '
										';
	}
	$__compilerTemp3 .= '

										';
	if ($__templater->method($__vars['review'], 'canConfirm', array())) {
		$__compilerTemp3 .= '
											<a href="' . $__templater->func('link', array('bratr-ratings/confirm', $__vars['review'], ), true) . '"
												class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
												data-xf-click="overlay" data-follow-redirects="on">' . 'Confirmation' . '</a>

											';
		$__vars['hasActionBarMenu'] = true;
		$__compilerTemp3 .= '
										';
	}
	$__compilerTemp3 .= '

										';
	if ($__vars['hasActionBarMenu']) {
		$__compilerTemp3 .= '
											<a class="actionBar-action actionBar-action--menuTrigger"
												data-xf-click="menu"
												title="' . $__templater->filter('More options', array(array('for_attr', array()),), true) . '"
												role="button"
												tabindex="0"
												aria-expanded="false"
												aria-haspopup="true">&#8226;&#8226;&#8226;</a>

											<div class="menu" data-menu="menu" aria-hidden="true" data-menu-builder="actionBar">
												<div class="menu-content">
													<h4 class="menu-header">' . 'More options' . '</h4>
													<div class="js-menuBuilderTarget"></div>
												</div>
											</div>
										';
	}
	$__compilerTemp3 .= '
									';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp1 .= '
									<div class="actionBar-set actionBar-set--internal">
									' . $__compilerTemp3 . '
									</div>
								';
	}
	$__compilerTemp1 .= '
							';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
						<div class="message-actionBar actionBar">
							' . $__compilerTemp1 . '
						</div>
					';
	}
	$__finalCompiled .= '

					<div class="likesBar js-likeList ' . ($__vars['review']['likes'] ? 'is-active' : '') . '">
						' . $__templater->func('likes_content', array($__vars['review'], $__templater->func('link', array('bratr-ratings/likes', $__vars['review'], ), false), array(
		'url' => $__templater->func('link', array('bratr-ratings/likes', $__vars['review'], ), false),
	))) . '
					</div>
				</footer>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'review_delete' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'user' => '!',
		'thread' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message message--deleted message--review js-review"
		data-author="' . ($__templater->escape($__vars['review']['User']['username']) ?: $__templater->escape($__vars['review']['username'])) . '"
		data-content="review-' . $__templater->escape($__vars['review']['thread_rating_id']) . '">

		<span class="u-anchorTarget" id="review-' . $__templater->escape($__vars['review']['thread_rating_id']) . '"></span>

		<div class="contentRow">
			<div class="contentRow-figure">
				' . $__templater->func('avatar', array($__vars['user'], 's', false, array(
		'notooltip' => 'true',
		'defaultname' => $__vars['user']['username'],
	))) . '
			</div>
			<div class="contentRow-main">
				<div class="contentRow-extra">
					' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
		'rating' => $__vars['review']['rating'],
	), $__vars) . '
				</div>
				<h3 class="contentRow-header">' . $__templater->func('username_link', array($__vars['user'], true, array(
		'notooltip' => 'true',
	))) . '</h3>
				<div class="messageNotice messageNotice--deleted">
					' . $__templater->callMacro('deletion_macros', 'notice', array(
		'log' => $__vars['review']['DeletionLog'],
	), $__vars) . '

					<a href="' . $__templater->func('link', array('bratr-ratings/show', $__vars['review'], ), true) . '" class="u-jsOnly" data-xf-click="inserter" data-replace="[data-content=review-' . $__templater->escape($__vars['review']['thread_rating_id']) . ']">' . 'Show' . $__vars['xf']['language']['ellipsis'] . '</a>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'item_new_ratings' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'rating' => '!',
		'user' => '!',
		'limitHeight' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="contentRow">
		<div class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['user'], 'xxs', false, array(
		'defaultname' => $__vars['user']['username'],
	))) . '
		</div>
		<div class="contentRow-main contentRow-main--close">
			<div class="contentRow-lesser">
				' . $__templater->func('username_link', array($__vars['user'], true, array(
		'defaultname' => $__vars['user']['username'],
	))) . '
			</div>
			
			<div class="contentRow-lesser">
				' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
		'rating' => $__vars['rating']['rating'],
	), $__vars) . '
			</div>

			';
	if ($__vars['limitHeight']) {
		$__finalCompiled .= '
				<div class="contentRow-faderContainer">
					<div class="contentRow-faderContent">
						' . $__templater->func('structured_text', array($__vars['rating']['message'], ), true) . '
					</div>
					<div class="contentRow-fader"></div>
				</div>
			';
	} else {
		$__finalCompiled .= '
				' . $__templater->func('structured_text', array($__vars['rating']['message'], ), true) . '
			';
	}
	$__finalCompiled .= '

			<div class="contentRow-minor">
				<a href="' . $__templater->func('link', array('bratr-ratings', $__vars['rating'], ), true) . '" rel="nofollow" class="u-concealed">' . $__templater->func('date_dynamic', array($__vars['rating']['rating_date'], array(
	))) . '</a>
				<a href="' . $__templater->func('link', array('bratr-ratings/show', $__vars['rating'], ), true) . '" rel="nofollow" class="contentRow-extra" data-xf-click="overlay" data-xf-init="tooltip" title="' . $__templater->filter('Interact', array(array('for_attr', array()),), true) . '">&#8226;&#8226;&#8226;</a>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'receive_rating_count' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered">
		<dt title="' . $__templater->filter('Ratings Received', array(array('for_attr', array()),), true) . '">' . 'Ratings Received' . '</dt>
		<dd>
			' . $__templater->filter($__vars['user']['bratr_receive_rating_count'], array(array('number', array()),), true) . '
		</dd>
	</dl>
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

' . '
	

' . '

' . '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);