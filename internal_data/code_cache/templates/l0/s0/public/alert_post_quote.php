<?php
// FROM HASH: eaf671bbbc75da6212602a9a4f4afb38
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (($__vars['content']['Thread']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) AND ($__vars['content']['Thread']['escrow_id'] != 0)) {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' quoted your post in the escrow ' . (((('<a href="' . $__templater->func('link', array('posts', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '.' . '
	';
	} else {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' quoted your post in the thread ' . ((((('<a href="' . $__templater->func('link', array('posts', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '.' . '
';
	}
	$__finalCompiled .= '	';
	return $__finalCompiled;
}
);