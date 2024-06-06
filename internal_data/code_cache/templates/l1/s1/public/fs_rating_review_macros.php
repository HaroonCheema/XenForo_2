<?php
// FROM HASH: 3917d2d5b912801d53d55e323a3cbc0c
return array(
'macros' => array('review' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'showResource' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/comment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	<div class="message message--simple">
		<span class="u-anchorTarget" id="resource-review-' . $__templater->escape($__vars['review']['rating_id']) . '"></span>
		<div class="message-inner">

			<div class="message-cell message-cell--main">
				<div class="message-content js-messageContent">
					<div class="message-attribution message-attribution--plain" style="padding-bottom: 10px; border-bottom: 1px solid #e7e7e7;">

						<ul class="listInline listInline--bullet">
							<li>
								' . $__templater->func('avatar', array($__vars['review']['User'], 'xs', false, array(
		'defaultname' => $__vars['review']['User']['username'],
		'itemprop' => 'image',
	))) . '
							</li>

							<li class="message-attribution-user">
								' . $__templater->func('username_link', array($__vars['review']['User'], false, array(
		'defaultname' => 'Deleted member',
	))) . '

							</li>
						</ul>

						<ul class="listInline listInline--bullet">
							<li>
								';
	if ($__templater->method($__vars['review'], 'isImage', array())) {
		$__finalCompiled .= '
									<img src="' . $__templater->escape($__templater->method($__vars['review'], 'getImgUrl', array(true, ))) . '" style="width:80px; height:80px; float: right;" >
								';
	}
	$__finalCompiled .= '
							</li>
						</ul>
					</div>

					<ul class="listInline listInline--bullet" style="display: flex; justify-content: space-between; margin: 10px 0px 10px 0px;">
						<li>
							' . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['review']['rating'],
		'class' => 'ratingStars--smaller',
	), $__vars) . '
						</li>
						<li><a href="#" class="u-concealed">' . $__templater->func('date_dynamic', array($__vars['review']['rating_date'], array(
	))) . '</a></li>
					</ul>

					<span class="" style="font-size: 1.17em; font-weight: bold;">
						<a href="' . $__templater->func('link', array('account/upgrades', $__vars['review']['Upgrade']['user_upgrade_id'], ), true) . '">' . $__templater->escape($__vars['review']['Upgrade']['title']) . '</a>
					</span>

					<div class="message-body">
						' . $__templater->func('structured_text', array($__vars['review']['message'], ), true) . '
					</div>
				</div>

				';
	if (($__vars['xf']['visitor']['is_admin'] OR ($__vars['xf']['visitor']['user_id'] == $__vars['review']['user_id']))) {
		$__finalCompiled .= ' 
					';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '

								';
		$__compilerTemp2 = '';
		$__compilerTemp2 .= '
											<a class="actionBar-action actionBar-action--reply js-replyTrigger-' . $__templater->escape($__vars['review']['rating_id']) . '"
											   data-xf-click="toggle"
											   data-target=".js-commentsTarget-' . $__templater->escape($__vars['review']['rating_id']) . '"
											   role="button"
											   tabindex="0">
												' . 'Reply' . '
											</a>
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

											<a href="' . $__templater->func('link', array('package-rating/delete', $__vars['review'], ), true) . '"
											   class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
											   data-xf-click="overlay">
												' . 'Delete' . '
											</a>

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
						<div class="message-actionBar actionBar" style="border-top: 1px solid #e7e7e7; margin-top: 10px; padding-top: 10px;">
							' . $__compilerTemp1 . '



						</div>

						';
			$__compilerTemp4 = '';
			$__compilerTemp4 .= '

									';
			if ($__vars['review']['author_response']) {
				$__compilerTemp4 .= '
										' . $__templater->callMacro(null, 'author_reply_row', array(
					'review' => $__vars['review'],
				), $__vars) . '
										';
			} else if ($__templater->method($__vars['review'], 'canReply', array())) {
				$__compilerTemp4 .= '
										<div class="js-replyNewMessageContainer"></div>
									';
			}
			$__compilerTemp4 .= '

									';
			if ($__templater->method($__vars['review'], 'canReply', array())) {
				$__compilerTemp4 .= '
										';
				$__templater->includeJs(array(
					'src' => 'xf/message.js',
					'min' => '1',
				));
				$__compilerTemp4 .= '
										<div class="message-responseRow js-commentsTarget-' . $__templater->escape($__vars['review']['rating_id']) . ' toggleTarget">
											';
				$__compilerTemp5 = '';
				if ($__vars['xf']['visitor']['is_admin']) {
					$__compilerTemp5 .= '
															<div class="u-muted" style="margin-bottom: 6px">
																' . 'Your reply will be attributed to ' . ($__vars['review']['User'] ? $__templater->escape($__vars['review']['User']['username']) : $__templater->escape($__vars['review']['User']['username'])) . ' publicly.' . '
															</div>
														';
				}
				$__compilerTemp4 .= $__templater->form('

												<div class="comment-inner">
													<span class="comment-avatar">
														' . $__templater->func('avatar', array($__vars['review']['User'], 'xxs', false, array(
				))) . '
													</span>
													<div class="comment-main">
														' . $__templater->formTextArea(array(
					'name' => 'message',
					'rows' => '1',
					'autosize' => 'true',
					'maxlength' => '',
					'data-toggle-autofocus' => '1',
					'class' => 'comment-input js-editor',
				)) . '

														' . $__compilerTemp5 . '

														<div>
															' . $__templater->button('Post reply', array(
					'type' => 'submit',
					'class' => 'button--primary button--small',
					'icon' => 'reply',
				), '', array(
				)) . '
														</div>
													</div>
												</div>
											', array(
					'action' => $__templater->func('link', array('package-rating/reply', $__vars['review'], ), false),
					'ajax' => 'true',
					'class' => 'comment',
					'data-xf-init' => 'quick-reply',
					'data-message-container' => '< .js-messageResponses | .js-replyNewMessageContainer',
					'data-submit-hide' => '.js-commentsTarget-' . $__vars['review']['rating_id'] . ', .js-replyTrigger-' . $__vars['review']['rating_id'],
				)) . '
										</div>
									';
			}
			$__compilerTemp4 .= '

								';
			if (strlen(trim($__compilerTemp4)) > 0) {
				$__finalCompiled .= '
							<div class="message-responses js-messageResponses">
								' . $__compilerTemp4 . '
							</div>
						';
			}
			$__finalCompiled .= '

					';
		}
		$__finalCompiled .= '
				';
	}
	$__finalCompiled .= '

			</div>

		</div>
	</div>
';
	return $__finalCompiled;
}
),
'author_reply_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message-responseRow">
		<div class="comment">
			<div class="comment-inner">
				<span class="comment-avatar">
					' . $__templater->func('avatar', array($__vars['review']['User'], 'xxs', false, array(
		'defaultname' => $__vars['review']['User']['username'],
	))) . '
				</span>
				<div class="comment-main">
					<div class="comment-content">
						<div class="comment-contentWrapper">
							' . $__templater->func('username_link', array($__vars['review']['User'], true, array(
		'defaultname' => $__vars['review']['User']['username'],
		'class' => 'comment-user',
	))) . '
							<div class="comment-body">' . $__templater->func('structured_text', array($__vars['review']['author_response'], ), true) . '</div>
						</div>
					</div>

					<div class="comment-actionBar actionBar">
						<div class="actionBar-set actionBar-set--internal">
							';
	if ($__vars['review']['user_id']) {
		$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('package-rating/reply-delete', $__vars['review'], ), true) . '"
								   class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
								   data-xf-click="overlay">
									' . 'Delete' . '
								</a>
							';
	}
	$__finalCompiled .= '
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);