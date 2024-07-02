<?php
// FROM HASH: a5b4cc61955fa73601af633330efcd07
return array(
'macros' => array('list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'userConv' => '!',
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
	';
	$__vars['author'] = $__templater->preEscaped('
		' . $__templater->func('username_link', array($__vars['message']['User'], true, array(
	))) . '
	');
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
		' . $__templater->func('bb_code', array($__vars['message']['translation_message'], 'conversation_message', $__vars['message'], ), true) . '
	');
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
		' . $__templater->callMacro(null, 'rtc_message_macros::bubble', array(
		'author' => $__vars['author'],
		'text' => $__vars['text'],
		'menu' => $__vars['menu'],
		'menuId' => 'js-rtcMessageMenu-' . $__vars['message']['message_id'],
		'footer' => $__vars['footer'],
		'markers' => $__vars['markers'],
		'besideButtons' => $__vars['besideButtons'],
		'lbContainer' => array('id' => 'message-' . $__vars['message']['message_id'], 'captionDesc' => (($__vars['message']['User'] ? $__vars['message']['User']['username'] : '') . ' · ') . $__templater->func('date_time', array($__vars['message']['message_date'], ), false), ),
	), $__vars) . '
	');
	$__finalCompiled .= '
	
	<div class="message js-message' . ((((($__vars['message']['user_id'] === $__vars['xf']['visitor']['user_id']) ? ' is-visitor' : '') . (($__vars['filter']['around_message_id'] === $__vars['message']['message_id']) ? ' is-highlight' : '')) . ((($__vars['xf']['visitor']['user_id'] === $__vars['message']['user_id']) AND $__vars['message']['xfm_has_been_read']) ? ' has-been-read' : '')) . ($__templater->method($__vars['message'], 'isUnread', array()) ? ' is-unread' : '')) . '" 
		 id="convMessage-' . $__templater->escape($__vars['message']['message_id']) . '"
		 data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
		 data-message-date="' . $__templater->escape($__vars['message']['xfm_message_date']) . '"
		 data-user-id="' . $__templater->escape($__vars['message']['user_id']) . '"
		 data-day="' . $__templater->func('rtc_day', array($__vars['message']['message_date'], ), true) . '"
		 data-day-ts="' . $__templater->func('rtc_day_ts', array($__vars['message']['message_date'], ), true) . '"
	>
		';
	if ($__vars['message']['user_id'] !== $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			<div class="content-icon">
				' . $__templater->func('avatar', array($__vars['message']['User'], 'xs', false, array(
		))) . '
			</div>
		';
	}
	$__finalCompiled .= '

		' . $__templater->filter($__vars['bubble'], array(array('raw', array()),), true) . '
	</div>
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
	if (($__vars['message']['user_id'] !== $__vars['xf']['visitor']['user_id']) AND $__templater->method($__vars['message']['Conversation'], 'canReply', array())) {
		$__finalCompiled .= '
		<div class="btn" 
			 data-xf-click="chat-editor-insert" 
			 data-content="' . $__templater->filter(array('type' => 'mention', 'id' => $__vars['message']['User']['username'], 'denotationChar' => '@', ), array(array('json', array()),), true) . '"
		>
			' . $__templater->fontAwesome('fa-at', array(
		)) . '
		</div>

		<div class="btn" 
			 data-xf-click="chat-message-action" 
			 data-action="quote"
			 data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
			 data-href="' . $__templater->func('link', array('conversations/messages/quote', $__vars['message'], ), true) . '"
		>
			' . $__templater->fontAwesome('fa-quote-right', array(
		)) . '
		</div>
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
					<div class="message-react' . (($__templater->method($__vars['message'], 'getVisitorReactionId', array()) === $__vars['reactionId']) ? ' is-selected' : '') . '"
						 data-href="' . $__templater->func('link', array('conversations/messages/react', $__vars['message'], array('reaction_id' => $__vars['reactionId'], ), ), true) . '"
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
	if ($__templater->method($__vars['message']['Conversation'], 'canReply', array())) {
		$__finalCompiled .= '
			<span class="menu-linkRow" 
				  data-xf-click="chat-message-action" 
				  data-action="quote"
				  data-message-id="' . $__templater->escape($__vars['message']['message_id']) . '"
				  data-href="' . $__templater->func('link', array('conversations/messages/quote', $__vars['message'], ), true) . '"
				  data-menu-closer=""
			 >
				' . $__templater->fontAwesome('fa-reply', array(
		)) . '
				' . 'Reply' . '
			</span>
		';
	}
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
		<span class="menu-linkRow" 
			  data-xf-init="copy-to-clipboard" 
			  data-xf-click=""
			  data-copy-text="' . $__templater->func('link', array('canonical:conversations/messages', $__vars['message'], ), true) . '"
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
				  href="' . $__templater->func('link', array('conversations/messages/translate', $__vars['message'], ), true) . '"
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
	if ($__templater->method($__vars['message'], 'canCleanSpam', array())) {
		$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('spam-cleaner', $__vars['message'], ), true) . '"
			   class="menu-linkRow"
			   data-xf-click="overlay"
			   data-menu-closer=""
			   >
				' . $__templater->fontAwesome('fa-trash', array(
		)) . '
				' . 'Spam' . '
			</a>
		';
	}
	$__finalCompiled .= '
		';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewIps', array()) AND $__vars['message']['ip_id']) {
		$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('conversations/messages/ip', $__vars['message'], ), true) . '"
			   class="menu-linkRow"
			   data-xf-click="overlay"
			   data-menu-closer=""
			   >
				' . $__templater->fontAwesome('fa-info', array(
		)) . '
				' . 'IP' . '
			</a>
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
				' . $__templater->func('reactions', array($__vars['message'], 'conversations/messages/reactions', array())) . '
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
	if ($__vars['message']['xfm_last_edit_date']) {
		$__finalCompiled .= '
		<span class="edited">' . 'edited' . '</span>
	';
	}
	$__finalCompiled .= '
	<span class="time iconic">' . $__templater->func('date', array($__vars['message']['message_date'], 'H:i', ), true) . '</span>
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

';
	return $__finalCompiled;
}
);