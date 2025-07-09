<?php
// FROM HASH: 2f2e017eda8c3a2d47d24ea236244a51
return array(
'macros' => array('post' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'note' => '!',
		'profileUser' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '

	<article class="message message--simple"
			 data-author="' . $__templater->escape($__vars['note']['User']['username']) . '"
			 data-content="note-' . $__templater->escape($__vars['note']['thread_id']) . '"
			 id="js-note-' . $__templater->escape($__vars['note']['thread_id']) . '">

		<span class="u-anchorTarget" id="note-' . $__templater->escape($__vars['note']['thread_id']) . '"></span>

		<div class="message-inner">

			<!-- Userbit -->
 			<div class="message-cell message-cell--user">
				' . $__templater->callMacro('message_macros', 'user_info_simple', array(
		'user' => $__vars['note']['User'],
		'fallbackName' => $__vars['note']['User']['username'],
	), $__vars) . '
			</div>

			<!-- Message Area -->
			<div class="message-cell message-cell--main">
				<div class="message-main js-quickEditTarget">
					<div class="message-content js-messageContent">
						<header class="message-attribution message-attribution--plain">
							<ul class="listInline listInline--bullet">
								<li class="message-attribution-user">
									' . $__templater->func('avatar', array($__vars['note']['User'], 'xxs', false, array(
	))) . '
									<h4 class="attribution">
										' . $__templater->func('username_link', array($__vars['note']['User'], true, array(
		'defaultname' => $__vars['note']['User']['username'],
	))) . ' <!--First User --> 
										';
	if (!$__vars['profileUser']) {
		$__finalCompiled .= '
											' . $__templater->fontAwesome(($__vars['xf']['isRtl'] ? 'fa-caret-left' : 'fa-caret-right') . ' u-muted', array(
		)) . '
											<a href="' . $__templater->func('link', array('threads', $__vars['note']['Thread'], ), true) . '" class="u-concealed" rel="nofollow">
											' . $__templater->escape($__vars['note']['Thread']['title']) . '
											</a>
											<!-- ' . $__templater->func('username_link', array($__vars['note']['User'], true, array(
			'defaultname' => 'Unknown',
			'aria-hidden' => 'true',
		))) . ' -->
										';
	}
	$__finalCompiled .= '
									</h4>
								</li>
								<li><a href="' . $__templater->func('link', array('threads', $__vars['note']['Thread'], ), true) . '" class="u-concealed" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['note']['post_date'], array(
	))) . '</a></li>
							</ul>
						</header>

						<article class="message-body">
								' . $__templater->func('snippet', array($__vars['note']['message'], 300, ), true) . '
							' . '
								<a href="' . $__templater->func('link', array('posts', $__vars['note'], ), true) . '">' . 'See more' . '</a>
						</article>
					</div>

					<footer class="message-footer">
						<div class="message-actionBar actionBar">
						</div>
					</footer>
				</div>
			</div>
		</div>
	</article>
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