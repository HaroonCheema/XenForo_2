<?php
// FROM HASH: 35db462409e650a81b0a1adde6d8d233
return array(
'extends' => function($__templater, array $__vars) { return 'thread_view'; },
'extensions' => array('content_top' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	';
	$__templater->includeCss('trakt_tv.less');
	$__finalCompiled .= '
';
	return $__finalCompiled;
},
'thread_action_buttons' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	
	';
	if (($__vars['thread']['traktTV'] AND (((($__vars['xf']['visitor']['user_id'] == $__vars['thread']['user_id']) OR $__vars['xf']['visitor']['is_admin']) OR $__vars['xf']['visitor']['is_moderator']) AND ($__vars['thread']['discussion_type'] == 'trakt_tv')))) {
		$__finalCompiled .= '

		' . $__templater->button('
			' . 'Sync' . '
		', array(
			'href' => $__templater->func('link', array('tvTrakt/sync', $__vars['thread']['traktTV'], ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '

	';
	}
	$__finalCompiled .= '
	
	';
	if ((($__templater->func('property', array('trakt_tv_posterUpdateButtonPosition', ), false) == 'default') AND ($__vars['thread']['traktTV'] AND ($__vars['xf']['visitor']['is_admin'] OR $__vars['xf']['visitor']['is_moderator'])))) {
		$__finalCompiled .= '
		' . $__templater->button('
			' . 'Check for new poster' . '
		', array(
			'href' => $__templater->func('link', array('tvTrakt/poster', $__vars['thread']['traktTV'], ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
	';
	}
	$__finalCompiled .= '
	';
	if ($__vars['xf']['options']['traktTvThreads_update'] AND ((!$__vars['thread']['traktTV']) AND $__vars['canAddInfo'])) {
		$__finalCompiled .= '
		' . $__templater->button('
			' . 'trakt_tv_add_info' . '
		', array(
			'href' => $__templater->func('link', array('tvTrakt/add-info', $__vars['thread'], ), false),
			'class' => 'button--link',
			'overlay' => 'true',
		), '', array(
		)) . '
	';
	}
	$__finalCompiled .= '
	' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '
';
	return $__finalCompiled;
},
'above_messages_below_pinned' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['thread']['traktTV'], 'empty', array()) AND ($__vars['page'] <= 1)) {
		$__finalCompiled .= '
		<span class="tvhint">' . 'Show information in first post provided by <a href="https://trakt.tv/" target="_blank" >Trakt Database</a>' . '</span>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->renderExtension('content_top', $__vars, $__extensions) . '

' . $__templater->renderExtension('thread_action_buttons', $__vars, $__extensions) . '

' . $__templater->renderExtension('above_messages_below_pinned', $__vars, $__extensions);
	return $__finalCompiled;
}
);