<?php
// FROM HASH: 0b03fa7a3cecffc1e39df58443e9d426
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' mentioned you in a comment on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . ' owner-page.' . '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts/comments', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);