<?php
// FROM HASH: 487f3a96e4d12f40d567e74426fbbc59
return array(
'macros' => array('list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'room' => '!',
		'messages' => '!',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('bb_code.less');
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['messages'], 'empty', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->isTraversable($__vars['messages'])) {
			foreach ($__vars['messages'] AS $__vars['message']) {
				$__finalCompiled .= '
			' . $__templater->callMacro(null, 'item', array(
					'message' => $__vars['message'],
					'filter' => $__vars['filter'],
				), $__vars) . '
		';
			}
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->filter($__templater->method($__vars['message'], 'render', array($__vars['filter'], )), array(array('raw', array()),), true) . '
';
	return $__finalCompiled;
}
),
'type_system' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message js-message message--system' . (((($__vars['xf']['visitor']['user_id'] === $__vars['message']['user_id']) AND $__vars['message']['has_been_read']) ? ' has-been-read' : '') . ($__templater->method($__vars['message'], 'isUnread', array()) ? ' is-unread' : '')) . '" 
		 data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
		 data-message-date="' . $__templater->escape($__vars['message']['message_date']) . '"
		 data-user-id="' . $__templater->escape($__vars['message']['user_id']) . '"
		 data-day="' . $__templater->func('rtc_day', array($__vars['message']['message_date'], ), true) . '"
		 data-day-ts="' . $__templater->func('rtc_day_ts', array($__vars['message']['message_date'], ), true) . '"
	>
		<div class="message-text js-messageContext">
			' . $__templater->func('bb_code', array($__templater->filter($__vars['message']['message'], array(array('censor', array()),), false), 'chat:system_message', $__vars['message'], ), true) . '
		</div>
		<div class="menu rtc-flat-menu js-messageMenu" 
			 data-xf-init="rtc-unique-menu" 
			 id="js-rtcMessageMenu-' . $__templater->escape($__vars['message']['message_id']) . '" 
			 data-menu="menu" 
			 aria-hidden="true"
		>';
	$__compilerTemp1 = '';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
						';
	if ($__templater->method($__vars['message'], 'canDelete', array())) {
		$__compilerTemp2 .= '
							<span class="menu-linkRow menu-linkRow--warning" 
								  data-xf-click="chat-message-action" 
								  data-action="delete"
								  data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
								  data-menu-closer=""
							>
								' . $__templater->fontAwesome('fa-trash', array(
		)) . '
								' . 'Delete' . '
							</span>
						';
	}
	$__compilerTemp2 .= '
					';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
				<div class="menu-content">
					' . $__compilerTemp2 . '
				</div>
			';
	}
	$__finalCompiled .= trim('
			' . $__compilerTemp1 . '
		') . '</div>
	</div>
';
	return $__finalCompiled;
}
),
'type_bubble' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
		'author' => '',
		'text' => '',
		'actions' => '',
		'besideButtons' => '',
		'filter' => array(),
		'form' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->test($__vars['author'], 'empty', array())) {
		$__finalCompiled .= '
		';
		$__vars['author'] = $__templater->preEscaped('
			' . $__templater->func('username_link', array($__vars['message']['User'], true, array(
		))) . '
		');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->test($__vars['besideButtons'], 'empty', array())) {
		$__finalCompiled .= '
		';
		$__vars['besideButtons'] = $__templater->preEscaped('
			' . $__templater->callMacro(null, 'message_beside_buttons', array(
			'message' => $__vars['message'],
		), $__vars) . '
		');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->test($__vars['text'], 'empty', array())) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__vars['message']['attach_count']) {
			$__compilerTemp1 .= '
				' . $__templater->callMacro(null, 'message_macros::attachments', array(
				'attachments' => $__vars['message']['Attachments'],
				'message' => $__vars['message'],
				'canView' => true,
			), $__vars) . '
			';
		}
		$__vars['text'] = $__templater->preEscaped('
			' . $__compilerTemp1 . '
			' . $__templater->func('bb_code', array($__templater->filter($__vars['message']['translation_message'], array(array('censor', array()),), false), 'chat:message', $__vars['message'], ), true) . '
		');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	
	';
	$__vars['menu'] = $__templater->preEscaped('
		' . $__templater->callMacro(null, 'message_menu', array(
		'message' => $__vars['message'],
	), $__vars) . '
	');
	$__finalCompiled .= '
	';
	$__vars['footer'] = $__templater->preEscaped('
		' . $__templater->callMacro(null, 'message_footer', array(
		'message' => $__vars['message'],
	), $__vars) . '
	');
	$__finalCompiled .= '
	';
	$__compilerTemp2 = '';
	if ($__vars['message']['translation']['error']) {
		$__compilerTemp2 .= '
			<span class="iconic translation-error" data-xf-init="tooltip" title="' . 'An error occurred while translating this message. Try again.' . '"></span>
		';
	}
	$__vars['markers'] = $__templater->preEscaped('
		' . $__templater->callMacro(null, 'message_markers', array(
		'message' => $__vars['message'],
	), $__vars) . '
		' . $__compilerTemp2 . '
	');
	$__finalCompiled .= '
	
	';
	$__vars['bubble'] = $__templater->preEscaped('
		' . $__templater->callMacro(null, 'bubble', array(
		'author' => $__vars['author'],
		'text' => $__vars['text'],
		'menu' => $__vars['menu'],
		'menuId' => 'js-rtcMessageMenu-' . $__vars['message']['message_id'],
		'footer' => $__vars['footer'],
		'markers' => $__vars['markers'],
		'actions' => $__vars['actions'],
		'besideButtons' => $__vars['besideButtons'],
		'lbContainer' => array('id' => 'message-' . $__vars['message']['message_id'], 'captionDesc' => (($__vars['message']['User'] ? $__vars['message']['User']['username'] : '') . ' · ') . $__templater->func('date_time', array($__vars['message']['message_date'], ), false), ),
	), $__vars) . '
	');
	$__finalCompiled .= '
	
	' . $__templater->callMacro(null, 'rtc_message_macros::container', array(
		'classes' => (((($__vars['form'] ? ' is-form' : '') . (!$__templater->test($__vars['actions'], 'empty', array()) ? ' has-actions' : '')) . ((($__vars['xf']['visitor']['user_id'] === $__vars['message']['user_id']) AND $__vars['message']['has_been_read']) ? ' has-been-read' : '')) . ($__templater->method($__vars['message'], 'isUnread', array()) ? ' is-unread' : '')),
		'message' => $__vars['message'],
		'content' => $__vars['bubble'],
		'filter' => $__vars['filter'],
		'withIcon' => ($__vars['message']['user_id'] !== $__vars['xf']['visitor']['user_id']),
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'message_beside_buttons' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['mentionCommand'] = $__templater->preEscaped(($__templater->method($__vars['message'], 'isPm', array()) ? '/pm' : '/to'));
	$__finalCompiled .= '
	';
	$__vars['privateCommand'] = $__templater->preEscaped(($__templater->method($__vars['message'], 'isPm', array()) ? '/to' : '/pm'));
	$__finalCompiled .= '

	';
	if (($__vars['message']['user_id'] !== $__vars['xf']['visitor']['user_id']) AND $__templater->method($__vars['message']['Room'], 'canPostMessage', array())) {
		$__finalCompiled .= '
		<div class="btn" 
			 data-xf-click="chat-command-setter" 
			 data-command="' . $__templater->escape($__vars['mentionCommand']) . ' ' . $__templater->escape($__vars['message']['User']['username']) . ', "
			 data-second-command="' . $__templater->escape($__vars['privateCommand']) . ' ' . $__templater->escape($__vars['message']['User']['username']) . ', "
		>
			' . $__templater->fontAwesome('fa-at', array(
		)) . '
		</div>

		';
		if ($__vars['xf']['options']['realTimeChatEnabledBbCodes']['quote']) {
			$__finalCompiled .= '
			<div class="btn" 
				 data-xf-click="chat-message-action" 
				 data-action="quote"
				 data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
				 data-href="' . $__templater->func('link', array('chat/messages/quote', $__vars['message'], ), true) . '"
			>
				' . $__templater->fontAwesome('fa-quote-right', array(
			)) . '
			</div>
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'message_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['message'], 'canReact', array())) {
		$__finalCompiled .= '
		<div class="menu-reactions">
			<div class="menu-linkReactions">
				';
		if ($__templater->isTraversable($__vars['xf']['reactionsActive'])) {
			foreach ($__vars['xf']['reactionsActive'] AS $__vars['reactionId'] => $__vars['reaction']) {
				$__finalCompiled .= '
					<div class="message-react' . ($__templater->method($__vars['message'], 'hasVisitorReaction', array($__vars['reactionId'], )) ? ' is-selected' : '') . '"
						 data-href="' . $__templater->func('link', array('chat/messages/react', $__vars['message'], array('reaction_id' => $__vars['reactionId'], ), ), true) . '"
						 data-xf-click="chat-message-action" 
						 data-action="react"
						 data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
						 data-menu-closer=""
					>
						' . $__templater->func('reaction', array(array(
					'id' => $__vars['reactionId'],
					'tooltip' => 'true',
				))) . '
					</div>
				';
			}
		}
		$__finalCompiled .= '
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
	<div class="menu-content">
		';
	if (($__vars['xf']['visitor']['user_id'] !== $__vars['message']['user_id']) AND $__templater->method($__vars['message']['Room'], 'canPostMessage', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-click="chat-command-setter" 
				  data-command="/to ' . $__templater->escape($__vars['message']['User']['username']) . ',"
				  data-menu-closer=""
				  >
				' . $__templater->fontAwesome('fa-at', array(
		)) . '
				' . 'Mention' . '
			</span>
		';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['realTimeChatEnabledBbCodes']['quote'] AND $__templater->method($__vars['message']['Room'], 'canPostMessage', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-click="chat-message-action" 
				  data-action="quote"
				  data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
				  data-href="' . $__templater->func('link', array('chat/messages/quote', $__vars['message'], ), true) . '"
				  data-menu-closer=""
			>
				' . $__templater->fontAwesome('fa-quote-right', array(
		)) . '
				' . 'Quote' . '
			</span>
		';
	}
	$__finalCompiled .= '
		';
	if (($__vars['xf']['visitor']['user_id'] !== $__vars['message']['user_id']) AND $__templater->method($__vars['message']['Room'], 'canPostMessage', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-click="chat-command-setter" 
				  data-command="/pm ' . $__templater->escape($__vars['message']['User']['username']) . '," 
				  data-menu-closer=""
				  >
				' . $__templater->fontAwesome('fa-envelope', array(
		)) . '
				' . 'Send private message' . '
			</span>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->method($__vars['message'], 'canCopy', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-init="copy-to-clipboard" 
				  data-xf-click=""
				  data-copy-text="' . $__templater->escape($__vars['message']['message']) . '"
				  data-menu-closer=""
			>
				' . $__templater->fontAwesome('fa-copy', array(
		)) . '
				' . 'Copy' . '
			</span>
		';
	}
	$__finalCompiled .= '
		<span class="menu-linkRow" 
			  data-xf-init="copy-to-clipboard" 
			  data-xf-click=""
			  data-copy-text="' . $__templater->func('link', array('canonical:chat/messages/to', $__vars['message'], ), true) . '"
			  data-menu-closer=""
		>
			' . $__templater->fontAwesome('fa-link', array(
	)) . '
			' . 'Copy link' . '
		</span>
		';
	if ($__templater->method($__vars['message'], 'canTranslate', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-click="switch"
				  href="' . $__templater->func('link', array('chat/messages/translate', $__vars['message'], ), true) . '"
				  data-sk-translate="' . 'Translate' . '"
				  data-sk-untranslate="' . 'Restore original' . '"
				  data-menu-closer=""
			>
				' . $__templater->fontAwesome('fa-language', array(
		)) . '
				<span class="js-label">
					' . $__templater->func('phrase_dynamic', array(($__templater->method($__vars['message'], 'hasTranslationForUser', array($__vars['xf']['visitor']['user_id'], )) ? 'rtc_restore_original' : 'rtc_translate'), ), true) . '
				</span>
			</span>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->method($__vars['message'], 'canEdit', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-click="chat-message-action" 
				  data-action="edit"
				  data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
				  data-menu-closer=""
				  >
				' . $__templater->fontAwesome('fa-pencil', array(
		)) . '
				' . 'Edit' . '
			</span>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->method($__vars['message'], 'canReport', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-click="chat-message-action" 
				  data-action="report"
				  data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
				  data-menu-closer=""
				  >
				' . $__templater->fontAwesome('fa-bullhorn', array(
		)) . '
				' . 'Report' . '
			</span>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->method($__vars['message'], 'canDelete', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow menu-linkRow--warning" 
				  data-xf-click="chat-message-action" 
				  data-action="delete"
				  data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
				  data-menu-closer=""
				  >
				' . $__templater->fontAwesome('fa-trash', array(
		)) . '
				' . 'Delete' . '
			</span>
		';
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}
),
'message_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				' . $__templater->func('reactions', array($__vars['message'], 'chat/messages/reactions', array())) . '
			';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="reactionsBar js-rtcMessageReactionsList ' . ($__vars['message']['reactions'] ? 'is-active' : '') . '" 
			 id=#js-rtcMessageReactionsList-' . $__templater->escape($__vars['message']['message_id']) . '>
			' . $__compilerTemp1 . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'message_markers' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['message'], 'isPm', array())) {
		$__finalCompiled .= '
		<span class="pm italic bold" 
			data-xf-init="tooltip" 
			title="' . 'Private message' . '"
		>' . 'pm' . '</span>
	';
	}
	$__finalCompiled .= '
	';
	if ($__vars['message']['last_edit_date']) {
		$__finalCompiled .= '
		<span class="edited italic">' . 'edited' . '</span>
	';
	}
	$__finalCompiled .= '
	<span class="time iconic">' . $__templater->func('date', array($__vars['message']['message_date'], 'H:i', ), true) . '</span>
';
	return $__finalCompiled;
}
),
'container' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
		'content' => '',
		'withIcon' => true,
		'filter' => array(),
		'classes' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message js-message ' . $__templater->escape($__vars['classes']) . ($__templater->method($__vars['message'], 'isTo', array()) ? ' is-to' : '') . ($__templater->method($__vars['message'], 'isPm', array()) ? ' is-pm' : '') . (($__vars['message']['user_id'] === $__vars['xf']['visitor']['user_id']) ? ' is-visitor' : '') . (($__vars['filter']['around_message_id'] === $__vars['message']['message_id']) ? ' is-highlight' : '') . '" 
		 id="rtcMessage-' . $__templater->escape($__vars['message']['message_id']) . '"
		 data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
		 data-message-date="' . $__templater->escape($__vars['message']['message_date']) . '"
		 data-user-id="' . $__templater->escape($__vars['message']['user_id']) . '"
		 data-day="' . $__templater->func('rtc_day', array($__vars['message']['message_date'], ), true) . '"
		 data-day-ts="' . $__templater->func('rtc_day_ts', array($__vars['message']['message_date'], ), true) . '"
	>
		';
	if ($__vars['withIcon']) {
		$__finalCompiled .= '
			<div class="content-icon">
				' . $__templater->func('avatar', array($__vars['message']['User'], 's', false, array(
		))) . '
			</div>
		';
	}
	$__finalCompiled .= '

		' . $__templater->filter($__vars['content'], array(array('raw', array()),), true) . '
	</div>
';
	return $__finalCompiled;
}
),
'bubble' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'author' => '',
		'text' => '',
		'menu' => '',
		'menuId' => '',
		'footer' => '',
		'markers' => '',
		'actions' => '',
		'besideButtons' => '',
		'containerAttrs' => '',
		'contentAttrs' => '',
		'lbContainer' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="content-bubble-container' . (!$__templater->test($__vars['actions'], 'empty', array()) ? ' has-actions' : '') . '" ' . $__templater->filter($__vars['containerAttrs'], array(array('raw', array()),), true) . '>
		<div class="content-bubble js-messageContext lbContainer js-lbContainer" ' . $__templater->filter($__vars['contentAttrs'], array(array('raw', array()),), true) . '>
			<div class="js-messageContent">
				<div class="content' . ($__vars['lbContainer'] ? ' lbContainer js-lbContainer' : '') . '"
					 data-lb-id="' . $__templater->escape($__vars['lbContainer']['id']) . '"
					 data-lb-caption-desc="' . $__templater->escape($__vars['lbContainer']['captionDesc']) . '"
				>
					<div class="message-text">
						' . $__templater->filter($__vars['text'], array(array('raw', array()),), true) . '

						';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= $__templater->escape($__vars['footer']);
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
							<div class="message-footer">
								' . $__compilerTemp1 . '

								<div class="message-markers">
									' . $__templater->filter($__vars['markers'], array(array('raw', array()),), true) . '

									<div class="markers-inner">
										' . $__templater->filter($__vars['markers'], array(array('raw', array()),), true) . '
									</div>
								</div>
							</div>
							';
	} else {
		$__finalCompiled .= '
							<div class="message-markers">
								' . $__templater->filter($__vars['markers'], array(array('raw', array()),), true) . '

								<div class="markers-inner">
									' . $__templater->filter($__vars['markers'], array(array('raw', array()),), true) . '
								</div>
							</div>
						';
	}
	$__finalCompiled .= '
					</div> 
				</div>

				<div class="menu rtc-flat-menu js-messageMenu" 
					 data-xf-init="rtc-unique-menu" 
					 id="' . $__templater->escape($__vars['menuId']) . '" 
					 data-menu="menu" 
					 aria-hidden="true"
				>
					' . $__templater->filter($__vars['menu'], array(array('raw', array()),), true) . '
				</div>
			</div>
			
			<div class="content-author">
				' . $__templater->filter($__vars['author'], array(array('raw', array()),), true) . '
			</div>
		</div>
		';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
					' . $__templater->filter($__vars['actions'], array(array('raw', array()),), true) . '
				';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__finalCompiled .= '
			<div class="bubble-actions">
				' . $__compilerTemp2 . '
			</div>
		';
	}
	$__finalCompiled .= '
		';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
					' . $__templater->filter($__vars['besideButtons'], array(array('raw', array()),), true) . '
				';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__finalCompiled .= '
			<div class="beside-buttons">
				' . $__compilerTemp3 . '
			</div>
		';
	}
	$__finalCompiled .= '
		' . $__templater->callMacro(null, 'bubble_tail_svg', array(), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'bubble_template' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message js-message is-visitor"
		 data-message-id="' . $__templater->func('mustache', array('id', ), true) . '" 
		 data-user-id="' . $__templater->escape($__vars['xf']['visitor']['user_id']) . '" 
		 data-day="' . $__templater->func('rtc_day', array($__vars['xf']['time'], ), true) . '"
		 data-day-ts="' . $__templater->func('rtc_day_ts', array($__vars['xf']['time'], ), true) . '"
	>
		<div class="content-bubble-container">
			<div class="content-bubble js-messageContext">
				<div class="js-messageContent">
					<div class="content">
						<div class="message-text">
							' . $__templater->func('mustache', array('{text}', ), true) . '
							
							<div class="message-markers">
								<span class="time iconic">' . $__templater->func('mustache', array('time', ), true) . '</span>

								<div class="markers-inner">
									<span class="time iconic">' . $__templater->func('mustache', array('time', ), true) . '</span>
								</div>
							</div>
						</div> 
					</div>
				</div>
			</div>
			' . $__templater->callMacro(null, 'bubble_tail_svg', array(), $__vars) . '
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'notification_template' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message message--system message--notification">
		<div class="message-text js-messageContext">
			<div class="bbWrapper">' . $__templater->func('mustache', array('{text}', ), true) . '</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'bubble_tail' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<symbol id="bubble-tail" viewBox="0 0 11 20"><g transform="translate(9 -14)" fill="inherit" fill-rule="evenodd"><path d="M-6 16h6v17c-.193-2.84-.876-5.767-2.05-8.782-.904-2.325-2.446-4.485-4.625-6.48A1 1 0 01-6 16z" transform="matrix(1 0 0 -1 0 49)" id="corner-fill" fill="inherit"></path></g></symbol>
';
	return $__finalCompiled;
}
),
'bubble_tail_svg' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<svg viewBox="0 0 11 20" width="11" height="20" class="bubble-tail"><use href="#bubble-tail"></use></svg>
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

';
	return $__finalCompiled;
}
);