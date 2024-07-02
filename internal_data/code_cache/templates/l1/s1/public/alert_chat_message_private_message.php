<?php
// FROM HASH: 7b11b11633a74c9fd04671359bf3d85a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' sent you <a href="' . $__templater->func('link', array('chat/messages/to', $__vars['content'], ), true) . '" class="fauxBlockLink-blockLink">private message</a> in chat.';
	return $__finalCompiled;
}
);