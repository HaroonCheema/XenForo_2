<?php
// FROM HASH: ad9702ab015a5b556c2e2dfeb292a33f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['visitor']['user_id'] == $__vars['content']['OwnerPagePost']['user_id']) {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' commented on your update.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' commented on ' . $__templater->escape($__vars['content']['OwnerPagePost']['username']) . '\'s post on your owner-page.' . '
';
	}
	$__finalCompiled .= '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts/comments', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);