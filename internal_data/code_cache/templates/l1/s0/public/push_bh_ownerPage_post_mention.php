<?php
// FROM HASH: 2e6ce01ef1c302e35e4e707e86303bf9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' mentioned you in a message on ' . $__templater->escape($__vars['content']['OwnerPage']['title']) . '\'s owner-page.' . '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);