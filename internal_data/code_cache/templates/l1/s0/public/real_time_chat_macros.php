<?php
// FROM HASH: 808c75109ad0b8a6d7b84fbc27db90c7
return array(
'macros' => array('chat' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'roomTag' => '',
		'autoSelectRoom' => true,
		'attachmentData' => null,
		'lastRoomDate' => '0',
		'latestMessageDate' => '0',
		'compact' => false,
		'pushHistory' => false,
		'draggable' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'less', array(), $__vars) . '
	' . $__templater->callMacro(null, 'js', array(), $__vars) . '
	
	';
	$__vars['roomParamsPlaceholder'] = array('tag' => '<tag>', );
	$__finalCompiled .= '
	';
	$__vars['messageParamsPlaceholder'] = array('tag' => '<tag>', 'message_id' => '<message_id>', );
	$__finalCompiled .= '
	';
	$__vars['defaultTheme'] = $__templater->func('rtc_room_theme', array(-1, ), false);
	$__finalCompiled .= '
	
	<div class="real-time-chat' . (($__vars['roomTag'] OR $__vars['autoSelectRoom']) ? ' no-left-column' : '') . ($__vars['compact'] ? ' compact' : '') . '"
		 data-xf-init="chat"
		 data-theme="' . $__templater->filter($__vars['defaultTheme'], array(array('json', array()),), true) . '"
		 data-rooms-url="' . $__templater->func('link', array('chat/rooms', ), true) . '"
		 data-room-url="' . $__templater->func('link', array('chat', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-messages-url="' . $__templater->func('link', array('chat/message-list', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-mark-seen-url="' . $__templater->func('link', array('chat/mark-seen', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-post-url="' . $__templater->func('link', array('chat/post', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-typing-url="' . $__templater->func('link', array('chat/typing', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-edit-url="' . $__templater->func('link', array('chat/messages/edit', $__vars['messageParamsPlaceholder'], ), true) . '"
		 data-delete-url="' . $__templater->func('link', array('chat/messages/delete', $__vars['messageParamsPlaceholder'], ), true) . '"
		 data-report-url="' . $__templater->func('link', array('chat/messages/report', $__vars['messageParamsPlaceholder'], ), true) . '"
		 data-audio="' . $__templater->func('base_url', array($__vars['xf']['options']['realTimeChatAudio'], ), true) . '"
		 data-enabled-audio="' . ($__vars['xf']['options']['realTimeChatEnableSound'] ? 'true' : 'false') . '"
		 data-room-tag="' . $__templater->escape($__vars['roomTag']) . '"
		 data-auto-select-room="' . ($__vars['autoSelectRoom'] ? 'true' : 'false') . '"
		 data-save-room-in-cookie="true"
		 data-push-history="' . ($__vars['pushHistory'] ? 'true' : 'false') . '"
		 data-event-prefix="RTC"
		 data-send-timeout="' . ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('general', 'bypassFloodCheck', )) ? 0 : $__templater->escape($__vars['xf']['options']['realTimeChatSendTimeout'])) . '"
		 style="' . $__templater->escape($__vars['defaultTheme']['css']) . '"
	>
		' . $__templater->callMacro(null, 'svg_defs', array(), $__vars) . '
		
		<div class="chat-columns">
			<div class="left-column">
				<div class="left-column-header">
					' . $__templater->button('
						' . $__templater->fontAwesome('fa-house', array(
	)) . '
						<span class="button-text--inner">' . 'Home' . '</span>
					', array(
		'class' => 'back-to-home-btn button--link',
		'href' => ($__vars['xf']['homePageUrl'] ?: $__vars['xf']['options']['boardUrl']),
	), '', array(
	)) . '
				</div>
				<div class="room-list rtc-slide-menu js-roomsList">
					<div class="left-slide">
						' . $__templater->callMacro(null, 'popup_header', array(
		'draggable' => $__vars['draggable'],
	), $__vars) . '
						' . $__templater->callMacro(null, 'rooms_placeholder', array(), $__vars) . '
						
						<div class="room-items scrollable-container">
							' . $__templater->callMacro(null, 'loader', array(
		'position' => 'top',
	), $__vars) . '

							<div class="scrollable js-scrollable">
								<div class="room-items-container js-roomItems"></div>
							</div>

							' . $__templater->callMacro(null, 'loader', array(), $__vars) . '
						</div>

						';
	if ($__templater->method($__vars['xf']['visitor'], 'canCreateChatRoom', array())) {
		$__finalCompiled .= '
							<button class="btn-corner js-createRoom" 
								data-xf-click="rtc-toggle-slide-menu"
								data-menu="< .js-roomsList"
							>' . $__templater->fontAwesome('fas fa-plus', array(
		)) . '</button>
						';
	}
	$__finalCompiled .= '
					</div>
					
					';
	if ($__templater->method($__vars['xf']['visitor'], 'canCreateChatRoom', array())) {
		$__finalCompiled .= '
						<div class="right-slide">
							' . $__templater->callMacro(null, 'create_room_form', array(), $__vars) . '
						</div>
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
			<div class="center-column">
				<div class="communication-content">
					' . $__templater->callMacro(null, 'wallpaper', array(
		'theme' => $__vars['defaultTheme'],
	), $__vars) . '
					' . $__templater->callMacro(null, 'header', array(
		'draggable' => $__vars['draggable'],
	), $__vars) . '
					' . $__templater->callMacro(null, 'connecting', array(), $__vars) . '

					<div class="content-inner">
						' . $__templater->callMacro(null, 'pinned_notices', array(), $__vars) . '
						' . $__templater->callMacro(null, 'content', array(), $__vars) . '
						' . $__templater->callMacro(null, 'editor', array(
		'attachmentData' => $__vars['attachmentData'],
	), $__vars) . '
					</div>
				</div>
			</div>
		</div>

		' . $__templater->formHiddenVal('latest_message_date', $__vars['latestMessageDate'], array(
	)) . '
		' . $__templater->formHiddenVal('latest_room_date', $__vars['lastRoomDate'], array(
	)) . '

		' . $__templater->callMacro(null, 'mustache_templates', array(), $__vars) . '
	</div>

	' . $__templater->callMacro(null, 'smilie_menu', array(), $__vars) . '
';
	return $__finalCompiled;
}
),
'less' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('real_time_chat.less');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'js' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'bs/real_time_chat/chat.js',
	));
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'wallpaper' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'theme' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'bs/real_time_chat/chat-canvas-gradient.js',
	));
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'bs/real_time_chat/chat-canvas-pattern.js',
	));
	$__finalCompiled .= '
	<div class="chat-wallpaper js-wallpaper">
		<div class="default-wallpaper' . (($__templater->func('property', array('styleType', ), false) === 'dark') ? ' is-dark' : '') . '">
			<canvas class="chat-canvas-gradient" 
				data-xf-init="chat-canvas-gradient" 
				data-colors="' . $__templater->filter($__vars['theme']['config']['background_colors'], array(array('json', array()),), true) . '"></canvas>
			<canvas class="chat-canvas-pattern"
				data-xf-init="chat-canvas-pattern"
				data-url="' . $__templater->escape($__vars['theme']['config']['pattern']) . '"
				data-is-dark-pattern="' . (($__templater->func('property', array('styleType', ), false) === 'dark') ? 'true' : 'false') . '"></canvas>
		</div>
		<div class="custom-wallpaper"></div>
	</div>
';
	return $__finalCompiled;
}
),
'header_buttons_before' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="header-buttons">
		<div class="header-button header-button--pl-sm header-button--bars js-toggleLeftColumn">
			' . $__templater->fontAwesome('fa-bars', array(
	)) . '
		</div>
		<div class="header-button header-button--pl-sm header-button--toggleLeft js-resetRoom">
			' . $__templater->fontAwesome('fa-arrow-left', array(
	)) . '
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'header' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'draggable' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="header js-header">
		' . $__templater->callMacro(null, 'header_buttons_before', array(), $__vars) . '

		<div class="avatar-container">
			<div class="header-avatar js-headerAvatar"></div>
			<div class="badge badge--popup is-hidden js-badgePopup"></div>
		</div>
		
		<div class="header-main" data-xf-init="' . ($__vars['draggable'] ? 'rtc-draggable' : '') . '">
			
			<a class="room-main js-roomLink" href="">
				<div class="room-name js-roomName">
					<span class="tag-prefix"></span>
					<span class="tag"></span>
				</div>
			</a>
			
			<div class="room-status js-roomStatus">
				<div class="title">
					' . 'Connecting...' . '
				</div>
				
				' . $__templater->callMacro(null, 'typer', array(), $__vars) . '
			</div>
		</div>
		
		' . $__templater->callMacro(null, 'header_buttons_after', array(), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'header_buttons_after' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="header-buttons">
		' . $__templater->callMacro(null, 'header_popup_buttons', array(), $__vars) . '
		
		<div class="header-button header-button--roomMenu" 
			 data-xf-click="menu" 
			 aria-expanded="false"
			 aria-haspopup="true"
		>
			' . $__templater->fontAwesome('fa-ellipsis-v', array(
	)) . '
		</div>
		<div class="menu rtc-flat-menu js-roomMenu" 
			 data-menu="menu" 
			 aria-hidden="true"
			 data-href=""
			 data-load-target=".js-roomMenuContent"
			 data-nocache="true"
		>
			<div class="menu-content js-roomMenuContent"></div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'popup_header' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'draggable' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="header header--popup">
		<div class="header-main" data-xf-init="' . ($__vars['draggable'] ? 'rtc-draggable' : '') . '">
			' . 'Chat' . '
			<div class="badge badge--popup is-hidden js-badgePopup"></div>
		</div>
		<div class="header-buttons">
			' . $__templater->callMacro(null, 'header_popup_buttons', array(), $__vars) . '
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'header_popup_buttons' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="header-button header-button--popup js-collapsePopup">
		' . $__templater->fontAwesome('fa-angle-down', array(
		'class' => 'collapse-icon',
	)) . '
	</div>

	<div class="header-button header-button--popup js-closePopup">
		' . $__templater->fontAwesome('fa-times', array(
	)) . '
	</div>
';
	return $__finalCompiled;
}
),
'connecting' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="connecting-container js-connecting">
		<div class="connecting-notice">
			' . 'Connecting...' . '
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'content' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="messages scrollable-container" data-xf-init="lightbox">
		' . $__templater->callMacro(null, 'loader', array(
		'position' => 'top',
	), $__vars) . '
		
		<div class="scrollable js-scrollable">
			<div class="message-list-wrapper"></div>
		</div>
	
		' . $__templater->callMacro(null, 'loader', array(), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'pinned_notices' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="pinned-notices js-chatPinnedNotices' . ($__vars['xf']['options']['realTimeChatNotice'] ? '' : ' is-hidden') . '">
		';
	if (!$__templater->test($__vars['xf']['options']['realTimeChatNotice'], 'empty', array())) {
		$__finalCompiled .= '
			<div class="pinned-notice js-chatPinnedNotice" data-notice-id="ad">
				<div class="content">
					' . $__templater->filter($__vars['xf']['options']['realTimeChatNotice'], array(array('raw', array()),), true) . '
				</div>
				<div class="notice-closer js-pinnedNoticeCloser">
					' . $__templater->fontAwesome('fa-times', array(
		)) . '
				</div>
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}
),
'typer' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="typer js-typer">
		<div class="typer--activity">
			<div class="dots">
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
			</div>
			<span class="typers"></span>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'loader' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'position' => 'bottom',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="content-loader content-loader--' . $__templater->escape($__vars['position']) . ' js-loader js-loader-' . $__templater->escape($__vars['position']) . '">
		<span class="spinner"></span>
	</div>
';
	return $__finalCompiled;
}
),
'chat_command' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message-action-container-wrapper js-containerWrapper">
		<div class="chat-command message-action-container js-chatCommand">
			<div class="icon">
				' . $__templater->fontAwesome('fa-terminal', array(
	)) . '
			</div>
			<div class="content">
				<div class="title">' . 'Run command' . '</div>
				<div class="message-text command-text"></div>
			</div>
			<div class="actions">
				<div class="action action--commandPin js-commandPin">
					' . $__templater->fontAwesome('fa-thumbtack', array(
	)) . '
				</div>
				<div class="action js-commandRemover">
					' . $__templater->fontAwesome('fa-times', array(
	)) . '
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'edit_message' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message-action-container-wrapper js-containerWrapper">
		<div class="message-action-container js-editMessage">
			<div class="icon">
				' . $__templater->fontAwesome('fa-pencil', array(
	)) . '
			</div>
			<div class="content">
				<div class="title">' . 'Edit message' . '</div>
				<div class="message-text js-messageText"></div>
			</div>
			<div class="actions">
				<div class="action js-cancelEditMessage">
					' . $__templater->fontAwesome('fa-times', array(
	)) . '
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'editor' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachmentData' => null,
		'forceHash' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('editor.less');
	$__finalCompiled .= '
	';
	$__vars['leftButtons'] = $__templater->preEscaped('
		<div class="ql-button ql-button--avatar">
			' . $__templater->func('avatar', array($__vars['xf']['visitor'], 'xxs', false, array(
	))) . '
 		</div>
		<div data-xf-init="smilie-box" class="ql-button ql-button--smile-button">
			' . $__templater->fontAwesome('fa-smile', array(
	)) . '
		</div>
	');
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['attachmentData'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="ql-button ql-button--attachment">
				' . $__templater->callMacro('helper_attach_upload', 'upload_link_from_data', array(
			'attachmentData' => $__vars['attachmentData'],
			'forceHash' => $__vars['forceHash'],
		), $__vars) . '

				' . $__templater->fontAwesome('fa-paperclip', array(
		)) . '
			</div>
		';
	}
	$__vars['rightButtons'] = $__templater->preEscaped('
		' . $__compilerTemp1 . '
	');
	$__finalCompiled .= '
	';
	$__vars['prepend'] = $__templater->preEscaped('
		' . $__templater->callMacro(null, 'chat_command', array(), $__vars) . '
		
		' . $__templater->callMacro(null, 'edit_message', array(), $__vars) . '
		
		' . $__templater->callMacro(null, 'helper_attach_upload::uploaded_files_list', array(
		'attachments' => $__vars['attachmentData']['attachments'],
	), $__vars) . '
	');
	$__finalCompiled .= '
	
	';
	$__vars['append'] = $__templater->preEscaped('
		' . $__templater->callMacro(null, 'rtc_message_macros::bubble_tail_svg', array(), $__vars) . '
	');
	$__finalCompiled .= '
	
	<div class="message-editor js-chatEditor" data-xf-init="' . (!$__templater->test($__vars['attachmentData'], 'empty', array()) ? 'attachment-manager' : '') . '">
		' . $__templater->func('quill_editor', array(array('allowedBbCodes' => $__vars['xf']['options']['realTimeChatEnabledBbCodes'] + array('user' => true, 'img' => (!$__templater->test($__vars['attachmentData'], 'empty', array()) ? true : false), ), 'active' => $__templater->method($__vars['xf']['visitor'], 'hasChatPermission', array('canWrite', )), 'submitByEnter' => true, 'prepend' => $__vars['prepend'], 'append' => $__vars['append'], 'leftButtons' => $__vars['leftButtons'], 'rightButtons' => $__vars['rightButtons'], 'placeholder' => 'Message', ), ), true) . '
		
		<div class="btn-send-container">
			<div class="btn-send js-actionSubmit">
				' . $__templater->fontAwesome('fas fa-paper-plane', array(
	)) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'rooms_placeholder' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'title' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="rooms-placeholder js-roomsPlaceholder">
		<img class="placeholder-icon" src="' . $__templater->func('base_url', array('styles/default/bs/real_time_chat/empty-chats.svg', ), true) . '" />
		<div class="placeholder-title">' . ($__vars['title'] ? $__templater->escape($__vars['title']) : 'Rooms will appear here') . '</div>
	</div>
';
	return $__finalCompiled;
}
),
'rooms' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'rooms' => '',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['rooms'])) {
		foreach ($__vars['rooms'] AS $__vars['room']) {
			$__finalCompiled .= '
		' . $__templater->callMacro(null, 'room', array(
				'room' => $__vars['room'],
				'filter' => $__vars['filter'],
			), $__vars) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'room' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'room' => '!',
		'classes' => 'js-room',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['lastMessage'] = $__vars['room']['LastMessage'];
	$__finalCompiled .= '
	';
	$__vars['member'] = $__templater->method($__vars['room'], 'getMember', array($__vars['xf']['visitor'], ));
	$__finalCompiled .= '
	
	<div class="room ' . $__templater->escape($__vars['classes']) . '" 
	   data-room-tag="' . $__templater->escape($__vars['room']['tag']) . '"
	   data-room-menu-href="' . $__templater->func('link', array('chat/rooms/menu', $__vars['room'], ), true) . '"
	   data-history-url="' . $__templater->func('link', array('chat', $__vars['room'], ), true) . '"
	   data-can-post-message="' . $__templater->escape($__templater->method($__vars['room'], 'canPostMessage', array())) . '"
	   data-pinned="' . ($__templater->method($__vars['room'], 'isPinned', array()) ? '1' : '0') . '"
	   data-pin-order="' . $__templater->escape($__vars['room']['member_pin_order']) . '"
	   data-last-message="' . $__templater->escape($__vars['room']['last_message_date']) . '"
	   data-theme="' . $__templater->filter($__vars['room']['theme'], array(array('json', array()),), true) . '"
	   data-xf-click=""
	>
		<div class="room-avatar">
			' . $__templater->func('rtc_room_avatar', array($__vars['room'], 's', array(), 'js-roomAvatar', ), true) . '
		</div>
		
		<div class="room-content">
			<div class="room-title-with-markers">
				<div class="room-title">
					' . $__templater->escape($__vars['room']['tag']) . '
				</div>
				<div class="room-extra">
					<ul class="room-extraInfo">
						<li>' . $__templater->func('rtc_relative_date', array($__vars['lastMessage']['message_date'], ), true) . '</li>
					</ul>
				</div>
			</div>
			<div class="room-latest-message js-roomLatestMessage type--' . $__templater->escape($__vars['lastMessage']['type']) . '">
				<div class="message-text">
					';
	if ($__vars['lastMessage']['user_id'] AND ($__vars['lastMessage']['user_id'] !== $__vars['xf']['visitor']['user_id'])) {
		$__finalCompiled .= '
						<span class="message-sender text-highlight">' . $__templater->escape($__vars['lastMessage']['User']['username']) . ':</span>
					';
	}
	$__finalCompiled .= '
					<div class="bbWrapper">
						' . ($__templater->func('snippet', array($__vars['lastMessage']['message'], 150, array('bbWrapper' => false, 'stripQuote' => true, ), ), true) ?: '[MEDIA]') . '
					</div>
				</div>
				' . $__templater->callMacro(null, 'typer', array(), $__vars) . '

				<div class="room-extra">
					<ul class="room-extraInfo">
						';
	if (!$__vars['room']['allowed_replies']) {
		$__finalCompiled .= '
							<li class="extra-item" data-xf-init="tooltip" title="' . $__templater->filter('Channel', array(array('for_attr', array()),), true) . '">
								' . $__templater->fontAwesome('fas fa-bullhorn', array(
		)) . '
							</li>
						';
	}
	$__finalCompiled .= '
						';
	if ($__templater->method($__vars['room'], 'isPinned', array())) {
		$__finalCompiled .= '
							<li class="extra-item">
								' . $__templater->fontAwesome('fas fa-thumbtack', array(
		)) . '
							</li>
						';
	}
	$__finalCompiled .= '
						<li class="badge badge--unread js-unreadCountBadge' . (($__vars['member']['unread_count'] <= 0) ? ' is-hidden' : '') . '">' . $__templater->escape($__vars['member']['unread_count']) . '</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'create_room_form' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['formId'] = $__templater->func('unique_id', array(), false);
	$__finalCompiled .= '
	
	<div class="chat-form js-createRoomForm" data-xf-init="rtc-create-room">
		<div class="title">
			<div class="return-back big-icon js-toggleSlide">
				' . $__templater->fontAwesome('fa-arrow-left', array(
	)) . '
			</div>
			' . 'Create new room' . '
		</div>

		' . $__templater->form('
			<div class="form-body-content form-body-content--big">
				<div class="input chat-header-input">
					<div class="avatar-box" data-xf-init="rtc-avatar-box">
						' . $__templater->func('rtc_room_avatar', array(array('tag' => 'r/Avatar', 'avatar_type' => 'fa', 'fa' => 'fa-image', ), 's', ), true) . '
						<input type="file" 
							   class="upload-input" 
							   name="avatar" 
							   accept=".gif,.jpeg,.jpg,.jpe,.png">
					</div>
					
					<div class="input tag-input">
						<div class="tag-prefix">' . $__templater->escape($__vars['xf']['visitor']['username']) . '/</div>
						' . $__templater->formTextBox(array(
		'name' => 'tag',
		'placeholder' => 'Love',
	)) . '
					</div>
				</div>
				' . $__templater->formTextArea(array(
		'rows' => '5',
		'name' => 'description',
		'placeholder' => 'Description',
		'maxlength' => $__templater->func('max_length', array('BS\\RealTimeChat:Room', 'description', ), false),
	)) . '
				' . $__templater->formCheckBox(array(
	), array(array(
		'name' => 'allow_messages_from_others',
		'checked' => 'true',
		'label' => 'Allow messages from other users',
		'_type' => 'option',
	))) . '
			</div>
		', array(
		'action' => $__templater->func('link', array('chat/create-room', ), false),
		'class' => 'form-body',
		'id' => $__vars['formId'],
		'ajax' => 'true',
		'data-redirect' => 'off',
		'data-reset-complete' => 'on',
	)) . '
	</div>
	
	<button class="btn-corner" type="submit" form="' . $__templater->escape($__vars['formId']) . '">
		' . $__templater->fontAwesome('fas fa-arrow-right', array(
	)) . '
	</button>
';
	return $__finalCompiled;
}
),
'smilie_menu' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<script class="js-xfSmilieMenu" type="text/template">' . trim('
		<div class="menu menu--emoji" data-menu="menu" aria-hidden="true"
			data-href="' . $__templater->func('link', array('editor/smilies-emoji', ), true) . '"
			data-load-target=".js-xfSmilieMenuBody">
			<div class="menu-content">
				<div class="js-xfSmilieMenuBody">
					<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
				</div>
			</div>
		</div>
	') . '</script>
';
	return $__finalCompiled;
}
),
'mustache_templates' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'notification_template', array(), $__vars) . '
	' . $__templater->callMacro(null, 'message_template', array(), $__vars) . '
';
	return $__finalCompiled;
}
),
'notification_template' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<script class="js-notificationTemplate" type="text/template">' . trim('
		' . $__templater->callMacro(null, 'rtc_message_macros::notification_template', array(), $__vars) . '
	') . '</script>
';
	return $__finalCompiled;
}
),
'message_template' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<script class="js-messageTemplate" type="text/template">' . trim('
		' . $__templater->callMacro(null, 'rtc_message_macros::bubble_template', array(), $__vars) . '
	') . '</script>
';
	return $__finalCompiled;
}
),
'svg_defs' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<svg style="position:absolute;top:-10000px;left:-10000px">
		<defs id="svg-defs">
			' . $__templater->callMacro(null, 'rtc_message_macros::bubble_tail', array(), $__vars) . '
		</defs>
	</svg>
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

' . '

' . '

' . '

' . '

' . '

' . '

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