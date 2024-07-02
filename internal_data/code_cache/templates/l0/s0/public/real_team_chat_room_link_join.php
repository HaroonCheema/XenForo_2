<?php
// FROM HASH: e29b277cf4aad14e481d8447879779b2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('template', 'RTC_PAGE_CONTAINER');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Chat');
	$__finalCompiled .= '

';
	$__templater->includeCss('real_time_chat.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('real_time_chat_window.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('real_team_chat_room_link.less');
	$__finalCompiled .= '

<div class="real-time-chat" style="' . $__templater->escape($__vars['link']['Room']['theme']['css']) . '">
	<div class="invite-background">		
		' . $__templater->callMacro(null, 'real_time_chat_macros::wallpaper', array(
		'theme' => $__vars['link']['Room']['theme'],
	), $__vars) . '
		<div class="invite-center">
			' . $__templater->form('
				<div class="section section--header">
					<div class="room-avatar">
						' . $__templater->func('rtc_room_avatar', array($__vars['link']['Room'], 's', ), true) . '
					</div>
					<div class="room-name">
						<span class="tag-prefix">' . $__templater->escape($__vars['link']['Room']['tag_prefix']) . '/</span>
						<span class="tag">' . $__templater->escape($__vars['link']['Room']['tag_name']) . '</span>
					</div>
				</div>
				<div class="section section--description">
					' . $__templater->escape($__vars['link']['Room']['description']) . '
				</div>
				<div class="section section--join">
					' . $__templater->button('Join', array(
		'type' => 'submit',
	), '', array(
	)) . '
				</div>
			', array(
		'action' => $__templater->func('link', array('chat/l', $__vars['link'], ), false),
		'ajax' => 'true',
		'class' => 'room-card',
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);