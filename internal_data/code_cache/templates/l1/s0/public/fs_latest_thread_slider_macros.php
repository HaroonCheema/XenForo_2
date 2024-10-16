<?php
// FROM HASH: a393b00565abe2cdf43134f2a27da0e6
return array(
'macros' => array('slider' => array(
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

				<div class="structItem-cell structItem-cell--icon" style="width: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width']) : $__templater->escape($__vars['xf']['options']['thumbnail_width'])) . '; height: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height']) : $__templater->escape($__vars['xf']['options']['thumb_size_hemant'])) . ';">

					<div class="structItem-iconContainer">
						<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '" target="' . (($__vars['xf']['visitor']['new_tab'] == 'yes') ? '_blank' : '_self') . '"> 
							<img src="' . $__templater->escape($__templater->method($__vars['thread'], 'getfirstPostImgUrl', array())) . '" class="' . (($__templater->func('count', array($__vars['thread']['FirstPost']['Attachments'], ), false) > 1) ? 'hideUpdateImg' : ' ') . '" style="width: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width']) : $__templater->escape($__vars['xf']['options']['thumbnail_width'])) . ' ; height: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height']) : $__templater->escape($__vars['xf']['options']['thumb_size_hemant'])) . '; object-fit: cover; border-bottom: solid 2px #fa7d24">
						</a>
						';
		if ($__templater->func('count', array($__vars['thread']['FirstPost']['Attachments'], ), false) > 1) {
			$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '" target="' . (($__vars['xf']['visitor']['new_tab'] == 'yes') ? '_blank' : '_self') . '"> 
								<div class="slider-container dispUpdateSlider" id="slider-container">
									<!-- Numbering Display -->
									<div class="slide-number" id="slide-number"></div>
									<div class="slider" id="slider">
										';
			$__vars['i'] = 0;
			if ($__templater->isTraversable($__vars['thread']['FirstPost']['Attachments'])) {
				foreach ($__vars['thread']['FirstPost']['Attachments'] AS $__vars['attachment']) {
					if ($__vars['attachment']['has_thumbnail']) {
						$__vars['i']++;
						$__finalCompiled .= '
											<img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '?' . ($__vars['xf']['time'] + $__vars['i']) . '" class="' . (($__vars['i'] == 1) ? 'active' : ' ') . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '" style="width: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width']) : $__templater->escape($__vars['xf']['options']['thumbnail_width'])) . ' ; height: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height']) : $__templater->escape($__vars['xf']['options']['thumb_size_hemant'])) . '; object-fit: cover; border-bottom: solid 2px #fa7d24" loading="lazy">
										';
					}
				}
			}
			$__finalCompiled .= '
									</div>
								</div>
							</a>
						';
		}
		$__finalCompiled .= '
						<spam class="containersSlider">
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
			if ($__vars['xf']['options']['fs_latest_thread_custom_field_ver'] AND (($__vars['xf']['visitor']['version_style'] == 'small') AND $__vars['thread']['custom_fields'][$__vars['xf']['options']['fs_latest_thread_custom_field_ver']])) {
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

					<a href="' . $__templater->func('link', array('threads' . (($__templater->method($__vars['thread'], 'isUnread', array()) AND (!$__vars['forceRead'])) ? '/unread' : ''), $__vars['thread'], ), true) . '" target="' . (($__vars['xf']['visitor']['new_tab'] == 'yes') ? '_blank' : '_self') . '" class="" data-tp-primary="on" data-xf-init="' . ($__vars['canPreview'] ? 'preview-tooltip' : '') . '" data-preview-url="' . ($__vars['canPreview'] ? $__templater->func('link', array('threads/preview', $__vars['thread'], ), true) : '') . '">' . $__templater->func('snippet', array($__vars['thread']['title'], 25, array('stripBbCode' => true, ), ), true) . '</a>
					';
	if ($__vars['xf']['options']['fs_latest_thread_custom_field_ver'] AND (($__vars['xf']['visitor']['version_style'] == 'large') AND $__vars['thread']['custom_fields'][$__vars['xf']['options']['fs_latest_thread_custom_field_ver']])) {
		$__finalCompiled .= '
						<spam class="field_game_title">' . $__templater->escape($__vars['thread']['custom_fields'][$__vars['xf']['options']['fs_latest_thread_custom_field_ver']]) . '</spam>
					';
	}
	$__finalCompiled .= '
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
		)) . ' ' . $__templater->escape($__vars['thread']['brivium_rating_count']) . '
							</li>
						</ul>

					';
	}
	$__finalCompiled .= '
				</div>

				<div class="hiddenDivSlider" style="margin-bottom: 5px !important;">

					<hr class="formRowSep" style="margin: 10px 0px;"/>

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
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

	<style>
		.hiddenDivSlider {
			display: none;
			position: absolute; 
			left: 0;
			width: 100%;  
			background-color: #17202f;
			padding: 10px;
			z-index: 1000; 
			border-radius: 5px;
		}

		.onHoverDispSlider:hover .hiddenDivSlider {
			display: block;
		}

		.onHoverDispSlider:hover .hideUpdateImg {
			display: none;
		}

		.dispUpdateSlider {
			display: none;
		}

		.onHoverDispSlider:hover .dispUpdateSlider {
			display: block;
		}

		.containersSlider {
			position: relative;
			top: -14px;
			display: flex;
			justify-content: space-between;
			margin: 0px 7px;
		}

		.onHoverDispSlider {
			position: relative;
			transition: transform 0.15s ease-in-out;
			z-index: 1;
		}
		.onHoverDispSlider:hover {
			transform: scale(1.03);  
		}	

		.slider-container {
			width: 100%;
			max-width: 600px;
			overflow: hidden; 
			position: relative; 
			margin: 5px auto; 
		}

		.slider {
			display: flex;
			transition: transform 0.5s ease-in-out; 
		}

		.slider img {
			width: 100%; 
			flex-shrink: 0; 
			height: 300px; 
			object-fit: cover; 
		}

		.slider img {
			display: none !important;
		}

		.slider img.active {
			display: block !important; 
		}

		.slide-number {
			position: absolute;
			top: 3px;
			left: 7px;
			background: rgba(0, 0, 0, 0.5); 
			color: white;
			padding: 3px 5px;
			border-radius: 3px;
			font-size: 10px;
			font-weight: bold;
		}

		.field_game_title {
			color: #9398a0;
			margin: 0 0 0 5px;
			white-space: nowrap;
		}
	</style>

	<div class="structItem structItem--thread' . ($__vars['thread']['prefix_id'] ? (' is-prefix' . $__templater->escape($__vars['thread']['prefix_id'])) : '') . ($__templater->method($__vars['thread'], 'isIgnored', array()) ? ' is-ignored' : '') . (($__templater->method($__vars['thread'], 'isUnread', array()) AND (!$__vars['forceRead'])) ? ' is-unread' : '') . (($__vars['thread']['discussion_state'] == 'moderated') ? ' is-moderated' : '') . (($__vars['thread']['discussion_state'] == 'deleted') ? ' is-deleted' : '') . ' js-inlineModContainer js-threadListItem-' . $__templater->escape($__vars['thread']['thread_id']) . ' onHoverDispSlider" data-author="' . ($__templater->escape($__vars['thread']['User']['username']) ?: $__templater->escape($__vars['thread']['username'])) . '">

		' . $__templater->renderExtension('icon_cell', $__vars, $__extensions) . '

		' . $__templater->renderExtension('main_cell', $__vars, $__extensions) . '

	</div>

	<script>
		// Function to initialize sliders
		function initializeSliders() {
			const sliders = document.querySelectorAll(\'.slider-container\');

			sliders.forEach((sliderContainer) => {
				const slider = sliderContainer.querySelector(\'.slider\');
				const images = slider.getElementsByTagName(\'img\');
				const imageCount = images.length;
				let currentIndex = 0;

				const slideNumber = sliderContainer.querySelector(\'.slide-number\');

				function changeSlide(index) {
					for (let img of images) {
						img.classList.remove(\'active\');
					}
					images[index].classList.add(\'active\');
					slideNumber.textContent = `${index + 1}/${imageCount}`;
				}

				sliderContainer.addEventListener(\'mouseenter\', function() {
					currentIndex = 0;
					changeSlide(currentIndex);

					const intervalId = setInterval(() => {
						currentIndex++;
						if (currentIndex >= imageCount) {
							currentIndex = 0;
						}
						changeSlide(currentIndex);
					}, 3000);

					sliderContainer.addEventListener(\'mouseleave\', function() {
						clearInterval(intervalId);
						changeSlide(0);
					}, { once: true });
				});
			});
		}

		// Initialize all sliders on the page
		window.onload = initializeSliders;
	</script>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);