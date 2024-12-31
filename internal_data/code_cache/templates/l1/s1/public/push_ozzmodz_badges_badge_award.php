<?php
// FROM HASH: 620e3f82ea18b9c1da395d1f6de186eb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'You have been awarded a badge: ' . $__templater->escape($__vars['content']['title']) . '' . '
<push:url>' . $__templater->func('link', array('canonical:members', $__vars['user'], ), true) . '#badges</push:url>';
	return $__finalCompiled;
}
);