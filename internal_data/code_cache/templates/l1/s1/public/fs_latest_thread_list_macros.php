<?php
// FROM HASH: bdd1976dc657823ec043c0740be357e9
return array(
'macros' => array('item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'forum' => '',
		'forceRead' => false,
		'showWatched' => true,
		'allowInlineMod' => true,
		'chooseName' => '',
		'extraInfo' => '',
		'allowEdit' => true,
	); },
'extensions' => array('icon_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
			';
	if ($__templater->func('in_array', array($__vars['thread']['node_id'], $__vars['xf']['options']['node_id_for_thumb'], ), false)) {
		$__finalCompiled .= '
				';
		if ((($__vars['xf']['reply']['template'] == 'forum_view') OR ($__vars['xf']['reply']['template'] == 'forum_view_latest_content')) OR ($__vars['xf']['reply']['template'] == 'tag_view')) {
			$__finalCompiled .= '

					<div class="structItem-cell structItem-cell--icon" style="width: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width']) : $__templater->escape($__vars['xf']['options']['thumbnail_width'])) . '; height: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height']) : $__templater->escape($__vars['xf']['options']['thumb_size_hemant'])) . ';">
						';
		} else {
			$__finalCompiled .= '
						<div class="structItem-cell structItem-cell--icon">
							';
		}
		$__finalCompiled .= '
						<div class="structItem-iconContainer">
							<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '"> 
								';
		if ((($__vars['xf']['reply']['template'] == 'forum_view') OR ($__vars['xf']['reply']['template'] == 'forum_view_latest_content')) OR ($__vars['xf']['reply']['template'] == 'tag_view')) {
			$__finalCompiled .= '
									<img src="' . $__templater->escape($__templater->method($__vars['thread'], 'getfirstPostImgUrl', array())) . '" style="width: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width']) : $__templater->escape($__vars['xf']['options']['thumbnail_width'])) . ' ; height: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height']) : $__templater->escape($__vars['xf']['options']['thumb_size_hemant'])) . '; object-fit: cover; border-bottom: solid 2px #ec5555;">
									';
		} else {
			$__finalCompiled .= '
									<img src="' . $__templater->escape($__templater->method($__vars['thread'], 'getfirstPostImgUrl', array())) . '" class="avatar avatar--square" style="object-fit: cover;">
								';
		}
		$__finalCompiled .= '
							</a>
							<spam class="containers">
								<spam class="leftDiv">
									';
		if ($__vars['thread']['prefix_id']) {
			$__finalCompiled .= '
										' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', 'noStatus', ), true) . '
									';
		}
		$__finalCompiled .= '
								</spam>
								<spam class="rightDiv">
									';
		if ($__vars['thread']['prefix_id']) {
			$__finalCompiled .= '
										' . $__templater->func('prefix', array('thread', $__vars['thread'], 'html', 'isStatus', ), true) . ' 

										';
			if ($__vars['xf']['options']['fs_latest_thread_custom_field_ver']) {
				$__finalCompiled .= '
											<spam style="background-color: #3f4043; padding: 0px 6px;">' . $__templater->escape($__vars['thread']['custom_fields'][$__vars['xf']['options']['fs_latest_thread_custom_field_ver']]) . '</spam>
										';
			}
			$__finalCompiled .= '
									';
		}
		$__finalCompiled .= '
								</spam>
							</spam>
						</div>
					</div>
					';
	} else {
		$__finalCompiled .= '
					<div class="structItem-cell structItem-cell--icon">
						<div class="structItem-iconContainer">
							' . $__templater->func('avatar', array($__vars['thread']['User'], 's', false, array(
			'defaultname' => $__vars['thread']['username'],
		))) . '
							';
		if ($__templater->method($__vars['thread'], 'getUserPostCount', array())) {
			$__finalCompiled .= '
								' . $__templater->func('avatar', array($__vars['xf']['visitor'], 's', false, array(
				'href' => '',
				'class' => 'avatar--separated structItem-secondaryIcon',
				'tabindex' => '0',
				'data-xf-init' => 'tooltip',
				'data-trigger' => 'auto',
				'title' => 'You have posted ' . $__templater->method($__vars['thread'], 'getUserPostCount', array()) . ' message(s) in this thread',
			))) . '
							';
		}
		$__finalCompiled .= '
						</div>
					</div>
				';
	}
	$__finalCompiled .= '
				';
	return $__finalCompiled;
},
'before_status_state' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'status_sticky' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
										';
	if ($__vars['thread']['sticky']) {
		$__finalCompiled .= '
											<li>
												<i class="structItem-status structItem-status--sticky" aria-hidden="true" title="' . $__templater->filter('Sticky', array(array('for_attr', array()),), true) . '"></i>
												<span class="u-srOnly">' . 'Sticky' . '</span>
											</li>
										';
	}
	$__finalCompiled .= '
									';
	return $__finalCompiled;
},
'before_status_watch' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_status_type' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'thread_type_redirect' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
											<li>
												<i class="structItem-status structItem-status--redirect" aria-hidden="true" title="' . $__templater->filter('Redirect', array(array('for_attr', array()),), true) . '"></i>
												<span class="u-srOnly">' . 'Redirect' . '</span>
											</li>
										';
	return $__finalCompiled;
},
'thread_type_question_solved' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
											<li>
												<i class="structItem-status structItem-status--solved" aria-hidden="true" title="' . $__templater->filter('Solved', array(array('for_attr', array()),), true) . '"></i>
												<span class="u-srOnly">' . 'Solved' . '</span>
											</li>
										';
	return $__finalCompiled;
},
'thread_type_icon' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
											';
	if ($__vars['thread']['discussion_type'] != 'discussion') {
		$__finalCompiled .= '
												';
		$__vars['threadTypeHandler'] = $__templater->method($__vars['thread'], 'getTypeHandler', array());
		$__finalCompiled .= '
												';
		if ($__templater->method($__vars['threadTypeHandler'], 'getTypeIconClass', array())) {
			$__finalCompiled .= '
													<li>
														';
			$__vars['threadTypePhrase'] = $__templater->method($__vars['threadTypeHandler'], 'getTypeTitle', array());
			$__finalCompiled .= '
														' . $__templater->fontAwesome($__templater->escape($__templater->method($__vars['threadTypeHandler'], 'getTypeIconClass', array())), array(
				'class' => 'structItem-status',
				'title' => $__templater->filter($__vars['threadTypePhrase'], array(array('for_attr', array()),), false),
			)) . '
														<span class="u-srOnly">' . $__templater->escape($__vars['threadTypePhrase']) . '</span>
													</li>
												';
		}
		$__finalCompiled .= '
											';
	}
	$__finalCompiled .= '
										';
	return $__finalCompiled;
},
'statuses' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
									';
	if (($__templater->func('property', array('reactionSummaryOnLists', ), false) == 'status') AND $__vars['thread']['first_post_reactions']) {
		$__finalCompiled .= '
										<li>' . $__templater->func('reactions_summary', array($__vars['thread']['first_post_reactions'])) . '</li>
									';
	}
	$__finalCompiled .= '
									' . $__templater->renderExtension('before_status_state', $__vars, $__extensions) . '
									';
	if ($__vars['thread']['discussion_state'] == 'moderated') {
		$__finalCompiled .= '
										<li>
											';
		$__vars['moderatedStatus'] = $__templater->preEscaped('
												<i class="structItem-status structItem-status--moderated" aria-hidden="true" title="' . $__templater->filter('Awaiting approval', array(array('for_attr', array()),), true) . '"></i>
												<span class="u-srOnly">' . 'Awaiting approval' . '</span>
											');
		$__finalCompiled .= '
											';
		if ($__templater->method($__vars['thread'], 'canCleanSpam', array())) {
			$__finalCompiled .= '
												<a href="' . $__templater->func('link', array('spam-cleaner', $__vars['thread'], ), true) . '" data-xf-click="overlay">' . $__templater->escape($__vars['moderatedStatus']) . '</a>
												';
		} else {
			$__finalCompiled .= '
												' . $__templater->escape($__vars['moderatedStatus']) . '
											';
		}
		$__finalCompiled .= '
										</li>
									';
	}
	$__finalCompiled .= '
									';
	if ($__vars['thread']['discussion_state'] == 'deleted') {
		$__finalCompiled .= '
										<li>
											<i class="structItem-status structItem-status--deleted" aria-hidden="true" title="' . $__templater->filter('Deleted', array(array('for_attr', array()),), true) . '"></i>
											<span class="u-srOnly">' . 'Deleted' . '</span>
										</li>
									';
	}
	$__finalCompiled .= '
									';
	if (!$__vars['thread']['discussion_open']) {
		$__finalCompiled .= '
										<li>
											<i class="structItem-status structItem-status--locked" aria-hidden="true" title="' . $__templater->filter('Locked', array(array('for_attr', array()),), true) . '"></i>
											<span class="u-srOnly">' . 'Locked' . '</span>
										</li>
									';
	}
	$__finalCompiled .= '

									' . $__templater->renderExtension('status_sticky', $__vars, $__extensions) . '

									' . $__templater->renderExtension('before_status_watch', $__vars, $__extensions) . '
									';
	if ($__vars['showWatched'] AND $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
										';
		if ($__vars['thread']['Watch'][$__vars['xf']['visitor']['user_id']]) {
			$__finalCompiled .= '
											<li>
												<i class="structItem-status structItem-status--watched" aria-hidden="true" title="' . $__templater->filter('Thread watched', array(array('for_attr', array()),), true) . '"></i>
												<span class="u-srOnly">' . 'Thread watched' . '</span>
											</li>
											';
		} else if ((!$__vars['forum']) AND $__vars['thread']['Forum']['Watch'][$__vars['xf']['visitor']['user_id']]) {
			$__finalCompiled .= '
											<li>
												<i class="structItem-status structItem-status--watched" aria-hidden="true" title="' . $__templater->filter('Forum watched', array(array('for_attr', array()),), true) . '"></i>
												<span class="u-srOnly">' . 'Forum watched' . '</span>
											</li>
										';
		}
		$__finalCompiled .= '
									';
	}
	$__finalCompiled .= '

									' . $__templater->renderExtension('before_status_type', $__vars, $__extensions) . '
									';
	if ($__vars['thread']['discussion_type'] == 'redirect') {
		$__finalCompiled .= '
										' . $__templater->renderExtension('thread_type_redirect', $__vars, $__extensions) . '
										';
	} else if (($__vars['thread']['discussion_type'] == 'question') AND $__vars['thread']['type_data']['solution_post_id']) {
		$__finalCompiled .= '
										' . $__templater->renderExtension('thread_type_question_solved', $__vars, $__extensions) . '
										';
	} else if ((!$__vars['forum']) OR ($__vars['forum']['forum_type_id'] == 'discussion')) {
		$__finalCompiled .= '
										' . $__templater->renderExtension('thread_type_icon', $__vars, $__extensions) . '
									';
	}
	$__finalCompiled .= '
								';
	return $__finalCompiled;
},
'main_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '

				<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

					';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
								' . $__templater->renderExtension('statuses', $__vars, $__extensions) . '
							';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
						<ul class="structItem-statuses">
							' . $__compilerTemp1 . '
						</ul>
					';
	}
	$__finalCompiled .= '

					<div class="structItem-title" style="margin-top: 12px;">
						';
	$__vars['canPreview'] = $__templater->method($__vars['thread'], 'canPreview', array());
	$__finalCompiled .= '

						<a href="' . $__templater->func('link', array('threads' . (($__templater->method($__vars['thread'], 'isUnread', array()) AND (!$__vars['forceRead'])) ? '/unread' : ''), $__vars['thread'], ), true) . '" class="" data-tp-primary="on" data-xf-init="' . ($__vars['canPreview'] ? 'preview-tooltip' : '') . '" data-preview-url="' . ($__vars['canPreview'] ? $__templater->func('link', array('threads/preview', $__vars['thread'], ), true) : '') . '">' . $__templater->func('snippet', array($__vars['thread']['title'], 25, array('stripBbCode' => true, ), ), true) . '</a>
					</div>

					<div class="structItem-minor">
						';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
									';
	if (($__templater->func('property', array('reactionSummaryOnLists', ), false) == 'minor_opposite') AND $__vars['thread']['first_post_reactions']) {
		$__compilerTemp2 .= '
										<li>' . $__templater->func('reactions_summary', array($__vars['thread']['first_post_reactions'])) . '</li>
									';
	}
	$__compilerTemp2 .= '
									';
	if ($__vars['extraInfo']) {
		$__compilerTemp2 .= '
										<li>' . $__templater->escape($__vars['extraInfo']) . '</li>
										';
	} else if ($__vars['allowEdit'] AND ($__templater->method($__vars['thread'], 'canEdit', array()) AND $__templater->method($__vars['thread'], 'canUseInlineModeration', array()))) {
		$__compilerTemp2 .= '
										';
		if ((!$__vars['allowInlineMod']) OR (!$__vars['forum'])) {
			$__compilerTemp2 .= '
											';
			$__vars['editParams'] = array('_xfNoInlineMod' => ((!$__vars['allowInlineMod']) ? 1 : null), '_xfForumName' => ((!$__vars['forum']) ? 1 : 0), );
			$__compilerTemp2 .= '
											';
		} else {
			$__compilerTemp2 .= '
											';
			$__vars['editParams'] = array();
			$__compilerTemp2 .= '
										';
		}
		$__compilerTemp2 .= '
										';
		if ($__vars['thread']['discussion_type'] != 'redirect') {
			$__compilerTemp2 .= '
											<li class="structItem-extraInfoMinor">
												<a href="' . $__templater->func('link', array('threads/edit', $__vars['thread'], ), true) . '" data-xf-click="overlay" data-cache="false" data-href="' . $__templater->func('link', array('threads/edit', $__vars['thread'], $__vars['editParams'], ), true) . '">
													' . 'Edit' . '
												</a>
											</li>
										';
		}
		$__compilerTemp2 .= '
									';
	}
	$__compilerTemp2 .= '
									';
	if ($__vars['chooseName']) {
		$__compilerTemp2 .= '
										<li>' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => $__vars['chooseName'] . '[]',
			'value' => $__vars['thread']['thread_id'],
			'class' => 'js-chooseItem',
			'_type' => 'option',
		))) . '</li>
										';
	} else if ($__vars['allowInlineMod'] AND $__templater->method($__vars['thread'], 'canUseInlineModeration', array())) {
		$__compilerTemp2 .= '
										<li>' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => $__vars['thread']['thread_id'],
			'class' => 'js-inlineModToggle',
			'data-xf-init' => 'tooltip',
			'title' => 'Select for moderation',
			'label' => 'Select for moderation',
			'hiddenlabel' => 'true',
			'_type' => 'option',
		))) . '</li>
									';
	}
	$__compilerTemp2 .= '
								';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__finalCompiled .= '
							<ul class="structItem-extraInfo">
								' . $__compilerTemp2 . '
							</ul>
						';
	}
	$__finalCompiled .= '

						';
	if ($__vars['thread']['discussion_state'] == 'deleted') {
		$__finalCompiled .= '
							';
		if ($__vars['extraInfo']) {
			$__finalCompiled .= '<span class="structItem-extraInfo">' . $__templater->escape($__vars['extraInfo']) . '</span>';
		}
		$__finalCompiled .= '

							' . $__templater->callMacro('deletion_macros', 'notice', array(
			'log' => $__vars['thread']['DeletionLog'],
		), $__vars) . '
							';
	} else {
		$__finalCompiled .= '
							<ul class="structItem-parts">
								<li class="structItem-startDate">
									' . $__templater->fontAwesome('fas fa-clock', array(
			'title' => $__templater->filter('Start date', array(array('for_attr', array()),), false),
		)) . '
									<span class="u-srOnly">' . 'Start date' . '</span>
									<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '" rel="nofollow">' . $__templater->escape($__templater->method($__vars['thread'], 'getTimeStampThread', array())) . '</a>
								</li>
								<li>
									' . $__templater->fontAwesome('fas fa-thumbs-up', array(
		)) . ' ' . $__templater->escape($__vars['thread']['first_post_reaction_score']) . '
								</li>
								<li>
									' . $__templater->fontAwesome('fas fa-eye', array(
		)) . ' ' . $__templater->escape($__templater->method($__vars['thread'], 'getViewCountKM', array())) . '
								</li>
								<li>
									' . $__templater->fontAwesome('fas fa-star', array(
		)) . ' ' . $__templater->escape($__vars['thread']['vote_count']) . '
								</li>
							</ul>

							';
		if (($__vars['thread']['discussion_type'] != 'redirect') AND (($__vars['thread']['reply_count'] >= $__vars['xf']['options']['messagesPerPage']) AND $__vars['xf']['options']['lastPageLinks'])) {
			$__finalCompiled .= '
								<span class="structItem-pageJump">
									';
			$__compilerTemp3 = $__templater->func('last_pages', array($__vars['thread']['reply_count'] + 1, $__vars['xf']['options']['messagesPerPage'], $__vars['xf']['options']['lastPageLinks'], ), false);
			if ($__templater->isTraversable($__compilerTemp3)) {
				foreach ($__compilerTemp3 AS $__vars['p']) {
					$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('threads', $__vars['thread'], array('page' => $__vars['p'], ), ), true) . '">' . $__templater->escape($__vars['p']) . '</a>
									';
				}
			}
			$__finalCompiled .= '
								</span>
							';
		}
		$__finalCompiled .= '

						';
	}
	$__finalCompiled .= '
					</div>

					<div class="hiddenDiv" style="margin-bottom: 5px !important;">


						<hr class="formRowSep" style="    margin: 10px 0px;;"/>

						';
	if ($__vars['xf']['options']['fs_latest_thread_custom_field_game']) {
		$__finalCompiled .= '
							<spam>' . $__templater->escape($__vars['thread']['custom_fields'][$__vars['xf']['options']['fs_latest_thread_custom_field_game']]) . '</spam>
							<br/>
						';
	}
	$__finalCompiled .= '

						<ul class="structItem-parts">
							';
	if ($__vars['xf']['options']['enableTagging'] AND ($__templater->method($__vars['thread'], 'canEditTags', array()) OR $__vars['thread']['tags'])) {
		$__finalCompiled .= '
								';
		$__templater->includeCss('avForumsTagEss_thread_view_grouped_tags.less');
		$__finalCompiled .= '

								';
		if ($__vars['thread']['GroupedTags']) {
			$__finalCompiled .= '
									';
			if ($__templater->isTraversable($__vars['thread']['GroupedTags'])) {
				foreach ($__vars['thread']['GroupedTags'] AS $__vars['categoryId'] => $__vars['groupedTagsData']) {
					$__finalCompiled .= '
										<li class="groupedTags">
											';
					if ($__templater->isTraversable($__vars['groupedTagsData']['tags'])) {
						foreach ($__vars['groupedTagsData']['tags'] AS $__vars['groupedTag']) {
							$__finalCompiled .= '
												<a href="' . $__templater->func('link', array('tags', $__vars['groupedTag'], ), true) . '" data-xf-init="preview-tooltip" data-preview-url="' . $__templater->func('link', array('tags/preview', $__vars['groupedTag'], ), true) . '" class="tagItem" dir="auto">' . $__templater->escape($__vars['groupedTag']['tag']) . '</a>
											';
						}
					}
					$__finalCompiled .= '
										</li>
									';
				}
			}
			$__finalCompiled .= '
								';
		}
		$__finalCompiled .= '
							';
	}
	$__finalCompiled .= '
						</ul>
					</div>

				</div>
			';
	return $__finalCompiled;
},
'icon_end_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				<div class="structItem-cell structItem-cell--icon structItem-cell--iconEnd">
					<div class="structItem-iconContainer">
						';
	if ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['thread']['last_post_user_id'], )) OR ($__vars['thread']['discussion_type'] == 'redirect')) {
		$__finalCompiled .= '
							' . $__templater->func('avatar', array(null, 'xxs', false, array(
		))) . '
							';
	} else {
		$__finalCompiled .= '
							' . $__templater->func('avatar', array($__vars['thread']['LastPoster'], 'xxs', false, array(
			'defaultname' => $__vars['thread']['last_post_username'],
		))) . '
						';
	}
	$__finalCompiled .= '
					</div>
				</div>
			';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

	<style>
		.hiddenDiv {
			display: none;
		}

		.onHoverDisp:hover .hiddenDiv {
			display: block;
		}

		.containers {
			position: relative;
			top: -12px;
			display: flex;
			justify-content: space-between; /* Pushes the divs to opposite sides */
			margin: 0px 7px;
		}
	</style>

	<div class="structItem structItem--thread' . ($__vars['thread']['prefix_id'] ? (' is-prefix' . $__templater->escape($__vars['thread']['prefix_id'])) : '') . ($__templater->method($__vars['thread'], 'isIgnored', array()) ? ' is-ignored' : '') . (($__templater->method($__vars['thread'], 'isUnread', array()) AND (!$__vars['forceRead'])) ? ' is-unread' : '') . (($__vars['thread']['discussion_state'] == 'moderated') ? ' is-moderated' : '') . (($__vars['thread']['discussion_state'] == 'deleted') ? ' is-deleted' : '') . ' js-inlineModContainer js-threadListItem-' . $__templater->escape($__vars['thread']['thread_id']) . ' onHoverDisp" data-author="' . ($__templater->escape($__vars['thread']['User']['username']) ?: $__templater->escape($__vars['thread']['username'])) . '">

		' . $__templater->renderExtension('icon_cell', $__vars, $__extensions) . '

			' . $__templater->renderExtension('main_cell', $__vars, $__extensions) . '

			' . '

			' . $__templater->renderExtension('icon_end_cell', $__vars, $__extensions) . '

			</div>
		';
	return $__finalCompiled;
}
),
'item_new_posts' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
		<div class="contentRow">
			<div class="contentRow-figure">
				' . $__templater->func('avatar', array($__vars['thread']['LastPoster'], 'xxs', false, array(
		'defaultname' => $__vars['thread']['last_post_username'],
	))) . '
			</div>
			<div class="contentRow-main contentRow-main--close">
				';
	if ($__templater->method($__vars['thread'], 'isUnread', array())) {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('threads/unread', $__vars['thread'], ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . '</a>
					';
	} else {
		$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['thread']['last_post_id'], ), ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . '</a>
				';
	}
	$__finalCompiled .= '

				<div class="contentRow-minor contentRow-minor--hideLinks">
					<ul class="listInline listInline--bullet">
						<li>' . 'Latest: ' . $__templater->escape($__vars['thread']['last_post_cache']['username']) . '' . '</li>
						<li>' . $__templater->func('date_dynamic', array($__vars['thread']['last_post_date'], array(
	))) . '</li>
					</ul>
				</div>
				<div class="contentRow-minor contentRow-minor--hideLinks">
					<a href="' . $__templater->func('link', array('forums', $__vars['thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['thread']['Forum']['title']) . '</a>
				</div>
			</div>
		</div>
	';
	return $__finalCompiled;
}
),
'item_new_threads' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
		<div class="contentRow">
			<div class="contentRow-figure">
				' . $__templater->func('avatar', array($__vars['thread']['User'], 'xxs', false, array(
		'defaultname' => $__vars['thread']['username'],
	))) . '
			</div>
			<div class="contentRow-main contentRow-main--close">
				<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . '</a>

				<div class="contentRow-minor contentRow-minor--hideLinks">
					<ul class="listInline listInline--bullet">
						<li>' . 'Started by ' . $__templater->escape($__vars['thread']['username']) . '' . '</li>
						<li>' . $__templater->func('date_dynamic', array($__vars['thread']['post_date'], array(
	))) . '</li>
						<li>' . 'Replies' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['thread']['reply_count'], array(array('number_short', array()),), true) . '</li>
					</ul>
				</div>
				<div class="contentRow-minor contentRow-minor--hideLinks">
					<a href="' . $__templater->func('link', array('forums', $__vars['thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['thread']['Forum']['title']) . '</a>
				</div>
			</div>
		</div>
	';
	return $__finalCompiled;
}
),
'quick_thread' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'forum' => '!',
		'page' => '1',
		'order' => 'last_post_date',
		'direction' => 'desc',
		'prefixes' => array(),
	); },
'extensions' => array('icon_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
					<div class="structItem-cell structItem-cell--icon">
						<div class="structItem-iconContainer">
							' . $__templater->func('avatar', array($__vars['xf']['visitor'], 's', false, array(
	))) . '
						</div>
					</div>
				';
	return $__finalCompiled;
},
'main_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
					<div class="structItem-cell structItem-cell--newThread js-prefixListenContainer">

						' . $__templater->formRow('

							' . $__templater->formPrefixInput($__vars['prefixes'], array(
		'maxlength' => $__templater->func('max_length', array('XF:Thread', 'title', ), false),
		'placeholder' => $__vars['forum']['thread_prompt'],
		'title' => 'Post a new thread in this forum',
		'prefix-value' => $__vars['forum']['default_prefix_id'],
		'type' => 'thread',
		'data-xf-init' => 'tooltip',
		'rows' => '1',
		'help-href' => $__templater->func('link', array('forums/prefix-help', $__vars['forum'], ), false),
		'help-skip-initial' => true,
	)) . '

							' . '
						', array(
		'rowtype' => 'noGutter noLabel fullWidth noPadding mergeNext',
		'label' => 'Title',
	)) . '

						<div class="js-quickThreadFields inserter-container is-hidden"><!--' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '--></div>
					</div>
				';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

		';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

		';
	if ($__templater->method($__vars['forum'], 'canCreateThread', array()) OR $__templater->method($__vars['forum'], 'canCreateThreadPreReg', array())) {
		$__finalCompiled .= '

			';
		$__templater->includeJs(array(
			'src' => 'xf/thread.js',
			'min' => '1',
		));
		$__finalCompiled .= '

			';
		$__vars['inlineMode'] = ((($__vars['page'] == 1) AND (($__vars['order'] == 'last_post_date') AND ($__vars['direction'] == 'desc'))) ? true : false);
		$__finalCompiled .= '

			' . $__templater->form('

				' . $__templater->renderExtension('icon_cell', $__vars, $__extensions) . '

				' . $__templater->renderExtension('main_cell', $__vars, $__extensions) . '

			', array(
			'action' => $__templater->func('link', array('forums/post-thread', $__vars['forum'], array('inline-mode' => $__vars['inlineMode'], ), ), false),
			'ajax' => 'true',
			'class' => 'structItem structItem--quickCreate',
			'draft' => $__templater->func('link', array('forums/draft', $__vars['forum'], ), false),
			'data-xf-init' => 'quick-thread',
			'data-focus-activate' => '.js-titleInput',
			'data-focus-activate-href' => $__templater->func('link', array('forums/post-thread', $__vars['forum'], array('inline-mode' => true, ), ), false),
			'data-focus-activate-target' => '.js-quickThreadFields',
			'data-insert-target' => '.js-threadList',
			'data-replace-target' => '.js-emptyThreadList',
		)) . '
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