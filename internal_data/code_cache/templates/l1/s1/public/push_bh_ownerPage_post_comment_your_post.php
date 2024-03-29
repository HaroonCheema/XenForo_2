<?php
// FROM HASH: 8f380b1c5de13016767971cd4ba7fa8e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' commented on your post on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . ' owner-page.' . '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts/comments', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);