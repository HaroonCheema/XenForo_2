<?php
// FROM HASH: 7a5e3a6206cdc9eb338b6e60ca78d652
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['content'], 'isFirstPost', array())) {
		$__finalCompiled .= '
	';
		if (($__vars['content']['Thread']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) AND ($__vars['content']['Thread']['escrow_id'] != 0)) {
			$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' started a escrow named ' . (((('<a href="' . $__templater->func('link', array('threads', $__vars['content']['Thread'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '.' . '
	';
		} else {
			$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' started a thread called ' . ((((('<a href="' . $__templater->func('link', array('threads', $__vars['content']['Thread'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '. There may be more posts after this.' . '
';
		}
		$__finalCompiled .= '	

';
	} else {
		$__finalCompiled .= '
	';
		if (($__vars['content']['Thread']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) AND ($__vars['content']['Thread']['escrow_id'] != 0)) {
			$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' replied to the escrow ' . (((('<a href="' . $__templater->func('link', array('threads', $__vars['content']['Thread'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '.' . '
	';
		} else {
			$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' replied to the thread ' . ((((('<a href="' . $__templater->func('link', array('posts', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '. There may be more posts after this.' . '
';
		}
		$__finalCompiled .= '	
';
	}
	return $__finalCompiled;
}
);