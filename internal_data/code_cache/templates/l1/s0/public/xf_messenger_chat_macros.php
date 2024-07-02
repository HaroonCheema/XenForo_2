<?php
// FROM HASH: 70b41dab98a68f7ac5e8fb81c794df4f
return array(
'macros' => array('chat' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'createForm' => array(),
		'roomTag' => '',
		'attachmentData' => null,
		'lastRoomDate' => '0',
		'latestMessageDate' => '0',
		'compact' => false,
		'pushHistory' => true,
		'draggable' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('xf_messenger.less');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'real_time_chat_macros::less', array(), $__vars) . '
	' . $__templater->callMacro(null, 'real_time_chat_macros::js', array(), $__vars) . '
	
	';
	$__vars['roomParamsPlaceholder'] = array('tag' => '<tag>', );
	$__finalCompiled .= '
	';
	$__vars['messageParamsPlaceholder'] = array('tag' => '<tag>', 'message_id' => '<message_id>', );
	$__finalCompiled .= '
	';
	$__vars['defaultTheme'] = $__templater->func('rtc_room_theme', array(-1, ), false);
	$__finalCompiled .= '

	<div class="real-time-chat real-time-chat--xf-messenger' . ($__vars['roomTag'] ? ' no-left-column' : '') . ($__vars['compact'] ? ' compact' : '') . '"
		 data-xf-init="chat"
		 data-theme="' . $__templater->filter($__vars['defaultTheme'], array(array('json', array()),), true) . '"
		 data-rooms-url="' . $__templater->func('link', array('conversations/messenger/rooms', ), true) . '"
		 data-room-url="' . $__templater->func('link', array('conversations/messenger', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-mark-seen-url="' . $__templater->func('link', array('conversations/messenger/mark-seen', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-messages-url="' . $__templater->func('link', array('conversations/messenger/message-list', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-post-url="' . $__templater->func('link', array('conversations/messenger/reply', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-typing-url="' . $__templater->func('link', array('conversations/messenger/typing', $__vars['roomParamsPlaceholder'], ), true) . '"
		 data-edit-url="' . $__templater->func('link', array('conversations/messenger/messages/edit', $__vars['messageParamsPlaceholder'], ), true) . '"
		 data-delete-url="' . $__templater->func('link', array('conversations/messenger/messages/delete', $__vars['messageParamsPlaceholder'], ), true) . '"
		 data-report-url="' . $__templater->func('link', array('conversations/messenger/messages/report', $__vars['messageParamsPlaceholder'], ), true) . '"
		 data-audio="' . $__templater->func('base_url', array($__vars['xf']['options']['xfmSoundPath'], ), true) . '"
		 data-enabled-audio="' . ($__vars['xf']['options']['xfmEnableSound'] ? 'true' : 'false') . '"
		 data-room-tag="' . $__templater->escape($__vars['roomTag']) . '"
		 data-room-channel-format="Conversation.<tag>"
		 data-auto-select-room="false"
		 data-auto-open-create-form="' . $__templater->escape($__vars['createForm']['open']) . '"
		 data-use-chat-channel="false"
		 data-event-prefix="XFM"
		 data-go-to-prefix="convMessage"
		 data-push-history="' . ($__vars['pushHistory'] ? 'true' : 'false') . '"
		 style="' . $__templater->escape($__vars['defaultTheme']['css']) . '"
	>
		' . $__templater->callMacro(null, 'real_time_chat_macros::svg_defs', array(), $__vars) . '
		
		<div class="chat-columns">
			<div class="left-column">
				<div class="room-list rtc-slide-menu js-roomsList">
					<div class="left-slide">
						' . $__templater->callMacro(null, 'real_time_chat_macros::popup_header', array(
		'draggable' => $__vars['draggable'],
	), $__vars) . '
						' . $__templater->callMacro(null, 'search_box', array(), $__vars) . '
						' . $__templater->callMacro(null, 'real_time_chat_macros::rooms_placeholder', array(
		'title' => 'Your conversations will appear here',
	), $__vars) . '

						<div class="room-items scrollable-container">
							' . $__templater->callMacro(null, 'search_container', array(), $__vars) . '

							' . $__templater->callMacro(null, 'real_time_chat_macros::loader', array(
		'position' => 'top',
	), $__vars) . '

							<div class="scrollable js-scrollable">
								<div class="room-items-container js-roomItems"  
									 data-xf-init="inline-mod" 
									 data-type="conversation" 
									 data-href="' . $__templater->func('link', array('inline-mod', ), true) . '"
								></div>
							</div>

							' . $__templater->callMacro(null, 'real_time_chat_macros::loader', array(), $__vars) . '
						</div>

						';
	if ($__templater->method($__vars['xf']['visitor'], 'canStartConversation', array())) {
		$__finalCompiled .= '
							<button href="' . $__templater->func('link', array('conversations/add', ), true) . '" 
								class="btn-corner js-createRoom" 
								data-xf-click="rtc-toggle-slide-menu"
								data-menu="< .js-roomsList"
							>' . $__templater->fontAwesome('fas fa-pencil', array(
		)) . '</button>
						';
	}
	$__finalCompiled .= '
					</div>
					
					';
	if ($__templater->method($__vars['xf']['visitor'], 'canStartConversation', array())) {
		$__finalCompiled .= '
						<div class="right-slide">
							' . $__templater->callMacro(null, 'create_room_form', array(
			'form' => $__vars['createForm'],
			'attachmentData' => $__vars['attachmentData'],
		), $__vars) . '
						</div>
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
			<div class="center-column">
				<div class="communication-content">
					' . $__templater->callMacro(null, 'real_time_chat_macros::wallpaper', array(
		'theme' => $__vars['defaultTheme'],
	), $__vars) . '
					' . $__templater->callMacro(null, 'header', array(
		'draggable' => $__vars['draggable'],
	), $__vars) . '
					' . $__templater->callMacro(null, 'real_time_chat_macros::connecting', array(), $__vars) . '
					
					<div class="content-inner">
						' . $__templater->callMacro(null, 'real_time_chat_macros::content', array(), $__vars) . '
						' . $__templater->callMacro(null, 'editor', array(
		'classes' => 'message-editor js-chatEditor',
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
		
		' . $__templater->callMacro(null, 'real_time_chat_macros::mustache_templates', array(), $__vars) . '
	</div>

	' . $__templater->callMacro(null, 'real_time_chat_macros::smilie_menu', array(), $__vars) . '
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
		<div class="header-button header-button--pl-sm header-button--toggleLeft js-resetRoom">
			' . $__templater->fontAwesome('fa-arrow-left', array(
	)) . '
		</div>
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
		' . $__templater->callMacro(null, 'real_time_chat_macros::header_popup_buttons', array(), $__vars) . '
		
		<div class="header-button" data-xf-click="menu" aria-expanded="false" aria-haspopup="true">
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
				
				' . $__templater->callMacro(null, 'real_time_chat_macros::typer', array(), $__vars) . '
			</div>
		</div>
		
		' . $__templater->callMacro(null, 'header_buttons_after', array(
		'draggable' => $__vars['draggable'],
	), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'search_box' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'bs/messenger/search.js',
		'min' => '1',
	));
	$__finalCompiled .= '
	<div class="search-box js-searchBox">
		<div class="actions big-icon" data-xf-click="menu" aria-expanded="false" aria-haspopup="true">
			' . $__templater->fontAwesome('fa-ellipsis-v', array(
	)) . '
		</div>
		<div class="menu rtc-flat-menu" 
			 data-menu="menu" 
			 aria-hidden="true"
		>
			<div class="menu-content">
				<a class="menu-linkRow" href="' . ($__templater->escape($__vars['xf']['homePageUrl']) ?: $__templater->escape($__vars['xf']['options']['boardUrl'])) . '">
					' . $__templater->fontAwesome('fa-house', array(
	)) . '
					' . 'Home' . '
				</a>
				';
	if ($__templater->func('contains', array($__templater->method($__vars['xf']['request'], 'getRequestUri', array()), 'messenger', ), false) AND (!$__vars['xf']['options']['xfmReplaceConversationsWithMessenger'])) {
		$__finalCompiled .= '
					<a class="menu-linkRow" href="' . $__templater->func('link', array('conversations', ), true) . '">
						' . $__templater->fontAwesome('fa-comments', array(
		)) . '
						' . 'Conversations' . '
					</a>
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
		<div class="return-back big-icon js-searchClose">
			' . $__templater->fontAwesome('fa-arrow-left', array(
	)) . '
		</div>
		<div class="search-input">
			' . $__templater->fontAwesome('fa-search search-icon input-icon', array(
	)) . '
			' . $__templater->formTextBox(array(
		'placeholder' => 'Search',
		'data-xf-init' => 'messenger-rooms-search',
		'data-search-url' => $__templater->func('link', array('conversations/messenger/search', ), false),
	)) . '
			' . $__templater->fontAwesome('fa-times reset-icon input-icon js-searchReset', array(
	)) . '
		</div>
		' . $__templater->form('
			' . $__templater->formTextBox(array(
		'name' => 'filter[starter]',
		'ac' => 'single',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		'placeholder' => 'Started by',
	)) . '

			' . $__templater->formTextBox(array(
		'name' => 'filter[receiver]',
		'ac' => 'single',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		'placeholder' => 'Received by',
	)) . '

			' . $__templater->formCheckBox(array(
	), array(array(
		'name' => 'filter[starred]',
		'label' => 'Starred',
		'_type' => 'option',
	),
	array(
		'name' => 'filter[unread]',
		'label' => 'Unread',
		'_type' => 'option',
	))) . '
		', array(
		'class' => 'search-filters js-searchFilters',
	)) . '
	</div>
';
	return $__finalCompiled;
}
),
'search_container' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="search-container js-searchContainer">
		<div class="tabs tabs--standalone">
			<div class="hScroller" data-xf-init="h-scroller">
				<span class="hScroller-scroll">
					<span class="tabs-tab js-searchTab is-active" 
						  role="tab" 
						  tabindex="0" 
						  aria-controls="' . $__templater->func('unique_id', array('conversations', ), true) . '"
						  data-type="conversations"
					>' . 'Conversations' . '</span>

					<span class="tabs-tab js-searchTab" 
						  role="tab" 
						  tabindex="1" 
						  aria-controls="' . $__templater->func('unique_id', array('attachments', ), true) . '"
						  data-type="attachments"
					>' . 'Attachments' . '</span>
				</span>
			</div>
		</div>
		<div class="search-results">
			' . $__templater->callMacro(null, 'real_time_chat_macros::loader', array(
		'position' => 'top',
	), $__vars) . '
			<div class="search-result-items js-searchResults"></div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'create_room_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'attachmentData' => null,
		'maxRecipients' => '-1',
		'draft' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['formId'] = $__templater->func('unique_id', array(), false);
	$__finalCompiled .= '
	
	<div class="chat-form js-createRoomForm create-conv-form">
		<div class="title">
			<div class="return-back js-toggleSlide">
				' . $__templater->fontAwesome('fa-arrow-left', array(
	)) . '
			</div>
			' . 'Start conversation' . '
		</div>

		' . $__templater->form('
			<div class="form-body-content form-body-content--big">
				' . $__templater->formTextBox(array(
		'name' => 'title',
		'value' => ($__vars['form']['title'] ?: $__vars['draft']['extra_data']['title']),
		'class' => 'input--title',
		'maxlength' => $__templater->func('max_length', array('XF:ConversationMaster', 'title', ), false),
		'placeholder' => 'Title',
	)) . '
				
				' . $__templater->formTokenInput(array(
		'name' => 'recipients',
		'value' => ($__vars['form']['to'] ?: $__vars['draft']['extra_data']['recipients']),
		'href' => $__templater->func('link', array('members/find', ), false),
		'placeholder' => ((($__vars['maxRecipients'] == -1) OR ($__vars['maxRecipients'] > 1)) ? 'Recipients' : 'Recipient'),
		'min-length' => '1',
		'max-tokens' => (($__vars['maxRecipients'] > -1) ? $__vars['maxRecipients'] : null),
	)) . '

				' . $__templater->callMacro(null, 'editor', array(
		'classes' => 'input-line',
		'draftUrl' => $__templater->func('link', array('conversations/draft', ), false),
		'value' => ($__vars['form']['message'] ?: $__vars['draft']['message']),
		'shown' => 'true',
		'withSubmit' => false,
		'attachmentData' => $__vars['attachmentData'],
		'forceHash' => $__vars['draft']['attachment_hash'],
	), $__vars) . '

				' . $__templater->formCheckBox(array(
	), array(array(
		'name' => 'open_invite',
		'checked' => $__vars['draft']['extra_data']['open_invite'],
		'label' => '
						' . 'Allow anyone in the conversation to invite others' . '
					',
		'_type' => 'option',
	),
	array(
		'name' => 'conversation_locked',
		'checked' => $__vars['draft']['extra_data']['conversation_locked'],
		'label' => '
						' . 'Lock conversation (no responses will be allowed)' . '
					',
		'_type' => 'option',
	))) . '
			</div>
		', array(
		'action' => $__templater->func('link', array('conversations/add', ), false),
		'id' => $__vars['formId'],
		'ajax' => 'true',
		'data-redirect' => 'off',
		'data-reset-complete' => 'on',
		'data-clear-complete' => 'on',
	)) . '

		<button class="btn-corner" type="submit" form="' . $__templater->escape($__vars['formId']) . '">
			' . $__templater->fontAwesome('fas fa-arrow-right', array(
	)) . '
		</button>
	</div>
';
	return $__finalCompiled;
}
),
'rooms' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'userConvs' => '!',
		'filters' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['userConvs'])) {
		foreach ($__vars['userConvs'] AS $__vars['userConv']) {
			$__finalCompiled .= '
		' . $__templater->callMacro(null, 'room', array(
				'userConv' => $__vars['userConv'],
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
		'userConv' => '!',
		'classes' => 'js-room',
		'filters' => array(),
		'allowInlineMod' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="room js-inlineModContainer ' . $__templater->escape($__vars['classes']) . '" 
	   data-room-tag="' . $__templater->escape($__vars['userConv']['conversation_id']) . '"
	   data-room-title="' . $__templater->escape($__vars['userConv']['Master']['title']) . '"
	   data-room-menu-href="' . $__templater->func('link', array('conversations/messenger/menu', array('tag' => $__vars['userConv']['conversation_id'], ), ), true) . '"
	   data-history-url="' . ($__templater->func('contains', array($__templater->method($__vars['xf']['request'], 'filter', array('_xfRequestUri', 'str', )), 'messenger', ), false) ? $__templater->func('link', array('conversations/messenger', array('tag' => $__vars['userConv']['conversation_id'], ), ), true) : $__templater->func('link', array('conversations', $__vars['userConv'], ), true)) . '"
	   data-can-post-message="' . ($__templater->method($__vars['userConv']['Master'], 'canReply', array()) ? 'true' : 'false') . '"
	   data-theme="' . $__templater->filter($__vars['userConv']['Master']['theme'], array(array('json', array()),), true) . '"
	   data-draft-url="' . $__templater->func('link', array('conversations/draft', $__vars['userConv']['Master'], ), true) . '"
	   data-pinned="0"
	   data-xf-click=""
	   data-last-message="' . $__templater->escape($__vars['userConv']['xfm_last_message_date']) . '"
	>
		<div class="room-avatar">
			' . $__templater->func('avatar', array($__vars['userConv']['AvatarUser'], 's', false, array(
		'class' => 'js-roomAvatar',
		'notooltip' => 'true',
		'href' => '',
	))) . '
		</div>
		
		<div class="room-content">
			<div class="room-title-with-markers">
				<div class="room-title">
					' . $__templater->escape($__vars['userConv']['Master']['title']) . '
				</div>
				<div class="room-extra">
					<ul class="room-extraInfo">
						<li>' . $__templater->func('rtc_relative_date', array($__vars['userConv']['last_message_date'], ), true) . '</li>

						';
	if ($__vars['allowInlineMod']) {
		$__finalCompiled .= '
							<li>
								' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => $__vars['userConv']['conversation_id'],
			'class' => 'js-inlineModToggle',
			'_type' => 'option',
		))) . '
							</li>
						';
	}
	$__finalCompiled .= '
					</ul>
				</div>
			</div>
			<div class="room-latest-message js-roomLatestMessage">
				';
	$__vars['lastMessage'] = $__vars['userConv']['Master']['LastMessage'];
	$__finalCompiled .= '

				<div class="message-text">
					';
	if ($__vars['lastMessage']['user_id'] !== $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
						<span class="message-sender text-highlight">' . $__templater->escape($__vars['lastMessage']['username']) . ':</span>
					';
	}
	$__finalCompiled .= '
					<div class="bbWrapper">
						' . ($__templater->func('snippet', array($__vars['lastMessage']['message'], 150, array('bbWrapper' => false, 'stripQuote' => true, ), ), true) ?: '[MEDIA]') . '
					</div>
				</div>
				' . $__templater->callMacro(null, 'real_time_chat_macros::typer', array(), $__vars) . '

				<div class="room-extra">
					<ul class="room-extraInfo">
						';
	if (!$__vars['userConv']['Master']['conversation_open']) {
		$__finalCompiled .= '
							<li class="extra-item" data-xf-init="tooltip" title="' . $__templater->filter('Locked', array(array('for_attr', array()),), true) . '">
								' . $__templater->fontAwesome('fas fa-lock', array(
		)) . '
							</li>
						';
	}
	$__finalCompiled .= '
						';
	if ($__vars['userConv']['is_starred']) {
		$__finalCompiled .= '
							<li class="extra-item extra-item--attention" data-xf-init="tooltip" title="' . $__templater->filter('Starred', array(array('for_attr', array()),), true) . '">
								' . $__templater->fontAwesome('fas fa-star', array(
		)) . '
							</li>
						';
	}
	$__finalCompiled .= '
						<li class="badge badge--unread js-unreadCountBadge' . (($__vars['userConv']['unread_count'] <= 0) ? ' is-hidden' : '') . '">' . $__templater->escape($__vars['userConv']['unread_count']) . '</li>
					</ul>
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
		'value' => '',
		'draftUrl' => '',
		'classes' => '',
		'withSubmit' => true,
		'shown' => false,
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
		' . $__templater->callMacro(null, 'real_time_chat_macros::edit_message', array(), $__vars) . '
		
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
	';
	$__vars['attrs'] = $__templater->preEscaped(($__vars['draftUrl'] ? (('data-draft-url="' . $__templater->escape($__vars['draftUrl'])) . '"') : ''));
	$__finalCompiled .= '
	
	<div class="' . $__templater->escape($__vars['classes']) . ($__vars['shown'] ? ' is-shown' : '') . '" data-xf-init="' . (!$__templater->test($__vars['attachmentData'], 'empty', array()) ? 'attachment-manager' : '') . '">
		' . $__templater->func('quill_editor', array(array('active' => true, 'submitByEnter' => true, 'prepend' => $__vars['prepend'], 'append' => $__vars['append'], 'attrsHtml' => $__vars['attrs'], 'leftButtons' => $__vars['leftButtons'], 'rightButtons' => $__vars['rightButtons'], 'placeholder' => 'Message', 'content' => $__vars['value'], ), ), true) . '
		
		';
	if ($__vars['withSubmit']) {
		$__finalCompiled .= '
			<div class="btn-send-container">
				<div class="btn-send js-actionSubmit">
					' . $__templater->fontAwesome('fas fa-paper-plane', array(
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

';
	return $__finalCompiled;
}
);