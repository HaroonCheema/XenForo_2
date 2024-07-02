<?php
// FROM HASH: 4659e3b10dc8b15140599fce91eb90c8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' mentioned you in <a href="' . $__templater->func('link', array('chat/messages/to', $__vars['content'], ), true) . '" class="fauxBlockLink-blockLink">chat message</a>.';
	return $__finalCompiled;
}
);