<?php
// FROM HASH: df0d7a701ca1d43e74c4b9c7b9113292
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Someone gifted your post in the thread ' . ((((('<a href="' . $__templater->func('link', array('threads', $__vars['content']['Thread'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '.';
	return $__finalCompiled;
}
);