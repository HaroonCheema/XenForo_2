<?php
// FROM HASH: 4ba47cfedda848d4b92f04873b23375a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['content']['OwnerPagePost']['OwnerPage']['user_id'] == $__vars['content']['OwnerPagePost']['user_id']) {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' also commented on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s owner-page update.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' also commented on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s owner-page post.' . '
';
	}
	$__finalCompiled .= '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts/comments', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);