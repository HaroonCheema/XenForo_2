<?php
// FROM HASH: 0e136090e2f1e12ad5f9bd565d512ce4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' gifted your post in the thread ' . ((((('<a href="' . $__templater->func('link', array('threads', $__vars['content']['Thread'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '.';
	return $__finalCompiled;
}
);