<?php
// FROM HASH: 0d503213357aa2d6eb14025ae0c08b13
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' <a href="' . $__templater->func('link', array('chat/messages/to', $__vars['content'], ), true) . '" class="fauxBlockLink-blockLink">quoted</a> your chat message.';
	return $__finalCompiled;
}
);