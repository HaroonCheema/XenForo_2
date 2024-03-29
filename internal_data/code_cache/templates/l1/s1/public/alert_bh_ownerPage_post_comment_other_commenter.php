<?php
// FROM HASH: f36e22d260af919c1f2f0bdde7a0204c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['content']['OwnerPagePost']['OwnerPage']['user_id'] == $__vars['content']['OwnerPagePost']['user_id']) {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' also commented on <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s update</a>.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' also commented on <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s owner-page post</a>.' . '
';
	}
	return $__finalCompiled;
}
);