<?php
// FROM HASH: 8235bd137c05fb55fcafecc33b350155
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['room'], 'canEdit', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow" 
	   data-xf-click="chat-message-post"
	   data-text="/edit"
	   data-menu-closer=""
	>
		' . $__templater->fontAwesome('fa-pencil', array(
		)) . '
		' . 'Edit' . '
	</a>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['room'], 'canSetWallpaper', array()) OR $__templater->method($__vars['room'], 'canSetIndividualWallpaper', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow" 
	   data-xf-click="chat-message-post"
	   data-text="/wallpaper"
	   data-menu-closer=""
	>
		' . $__templater->fontAwesome('fa-paint-roller', array(
		)) . '
		' . 'Set wallpaper' . '
	</a>
';
	}
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['realTimeChatEnableSound']) {
		$__finalCompiled .= '
	<a data-xf-init="chat-toggle-sound"
	   data-xf-click=""
	   data-off-title="' . 'Mute' . '"
	   data-on-title="' . 'Unmute' . '"
	   class="menu-linkRow"
	>
		' . $__templater->fontAwesome('fa-volume', array(
		)) . '
		<span class="js-label">' . 'Mute' . '</span>
	</a>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['room'], 'canGetNewLink', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow" 
	   data-xf-click="chat-message-post"
	   data-text="/link"
	   data-menu-closer=""
	>
		' . $__templater->fontAwesome('fa-link', array(
		)) . '
		' . 'New link' . '
	</a>
';
	}
	$__finalCompiled .= '


';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				';
	if ($__templater->method($__vars['room'], 'canViewBannedList', array())) {
		$__compilerTemp1 .= '
					<a class="menu-linkRow" 
					   data-xf-click="chat-message-post"
					   data-text="/ban --list"
					   data-menu-closer=""
					>
						' . $__templater->fontAwesome('fa-list', array(
		)) . '
						' . 'View list' . '
					</a>
				';
	}
	$__compilerTemp1 .= '
				';
	if ($__templater->method($__vars['room'], 'canBan', array())) {
		$__compilerTemp1 .= '
					<a class="menu-linkRow" 
					   data-xf-click="chat-message-post"
					   data-text="/ban"
					   data-menu-closer=""
					>
						' . $__templater->fontAwesome('fa-user-slash', array(
		)) . '
						' . 'Ban user' . '
					</a>
				';
	}
	$__compilerTemp1 .= '
				
				';
	if ($__templater->method($__vars['room'], 'canLiftBan', array())) {
		$__compilerTemp1 .= '
					<a class="menu-linkRow" 
					   data-xf-click="chat-message-post"
					   data-text="/ban --lift"
					   data-menu-closer=""
					>
						' . $__templater->fontAwesome('fa-ban', array(
		)) . '
						' . 'Lift ban' . '
					</a>
				';
	}
	$__compilerTemp1 .= '
			';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	<a class="menu-linkRow" 
	   data-xf-click="menu"
	>
		' . $__templater->fontAwesome('fa-users-slash', array(
		)) . '
		' . 'Manage bans' . '
		<span class="enter-icon">' . $__templater->fontAwesome('fa-chevron-right', array(
		)) . '</span>
	</a>
	<div class="menu rtc-flat-menu" 
		data-xf-init="rtc-unique-menu" 
		id="js-rtcRoomBanMenu-' . $__templater->escape($__vars['room']['room_id']) . '" 
		data-menu="menu" 
		aria-hidden="true"
	>
		<div class="menu-content">
			' . $__compilerTemp1 . '
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['room'], 'canLeave', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow menu-linkRow--warning" 
	   data-xf-click="chat-message-post"
	   data-text="/leave"
	   data-menu-closer=""
	>
		' . $__templater->fontAwesome('fa-sign-out', array(
		)) . '
		' . 'Leave' . '
	</a>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['room'], 'canClear', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow menu-linkRow--warning" 
	   data-xf-click="chat-message-post"
	   data-text="/clear"
	   data-menu-closer=""
	>
		' . $__templater->fontAwesome('fa-broom', array(
		)) . '
		' . 'Clear' . '
	</a>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['room'], 'canDelete', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow menu-linkRow--warning" 
	   data-xf-click="overlay"
	   href="' . $__templater->func('link', array('chat/rooms/delete', $__vars['room'], ), true) . '"
	>
		' . $__templater->fontAwesome('fa-trash', array(
		)) . '
		' . 'Delete' . '
	</a>
';
	}
	return $__finalCompiled;
}
);