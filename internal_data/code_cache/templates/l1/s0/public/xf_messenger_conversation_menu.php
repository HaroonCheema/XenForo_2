<?php
// FROM HASH: 4e48bd2eeeb952a2f4b5cffc68cee5e5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<a class="menu-linkRow" 
   href="' . $__templater->func('link', array('conversations/messenger/recipients', array('tag' => $__vars['conversation']['conversation_id'], ), ), true) . '"
   data-xf-click="overlay"
>
	' . $__templater->fontAwesome('fa-users', array(
	)) . '
	' . 'Participants' . '
</a>

';
	if ($__templater->method($__vars['conversation'], 'canEdit', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow" 
	   href="' . $__templater->func('link', array('conversations/edit', $__vars['conversation'], ), true) . '" 
	   data-xf-click="overlay"
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
	if ($__templater->method($__vars['conversation'], 'canSetWallpaper', array()) OR $__templater->method($__vars['conversation'], 'canSetIndividualWallpaper', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow" 
	   href="' . $__templater->func('link', array('conversations/wallpaper', $__vars['conversation'], ), true) . '" 
	   data-xf-click="overlay"
	   data-cache="off"
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
	if ($__vars['xf']['options']['xfmEnableSound']) {
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

<a class="menu-linkRow" 
   href="' . $__templater->func('link', array('conversations/star', $__vars['conversation'], ), true) . '"
   data-xf-click="switch"
   data-sk-star="' . 'Star' . '"
   data-sk-unstar="' . 'Unstar' . '"
>
	' . $__templater->fontAwesome('fa-star', array(
	)) . '
	<span class="js-label">' . ($__vars['userConv']['is_starred'] ? 'Unstar' : 'Star') . '</span>
</a>

<a class="menu-linkRow" 
   href="' . $__templater->func('link', array('conversations/mark-unread', $__vars['conversation'], ), true) . '"
   data-xf-click="switch"
   data-sk-read="' . 'Mark read' . '"
   data-sk-unread="' . 'Mark unread' . '"
>
	' . $__templater->fontAwesome('fa-comment-check', array(
	)) . '
	<span class="js-label">' . ($__vars['userConv']['is_unread'] ? 'Mark read' : 'Mark unread') . '</span>
</a>

';
	if ($__templater->method($__vars['conversation'], 'canInvite', array())) {
		$__finalCompiled .= '
	<a class="menu-linkRow" 
	   href="' . $__templater->func('link', array('conversations/invite', $__vars['conversation'], ), true) . '"
	   data-xf-click="overlay"
	   data-menu-closer=""
	 >
		' . $__templater->fontAwesome('fa-plus', array(
		)) . '
		' . 'Invite more' . '
	</a>
';
	}
	$__finalCompiled .= '

<a class="menu-linkRow menu-linkRow--warning" 
   href="' . $__templater->func('link', array('conversations/leave', $__vars['conversation'], ), true) . '"
   data-xf-click="overlay"
   data-menu-closer=""
>
	' . $__templater->fontAwesome('fa-sign-out', array(
	)) . '
	' . 'Leave' . '
</a>';
	return $__finalCompiled;
}
);