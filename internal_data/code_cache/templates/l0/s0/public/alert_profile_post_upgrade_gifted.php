<?php
// FROM HASH: 227e8f3707d6e3609a5c02d6fd8f6401
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['visitor']['user_id'] === $__vars['content']['profile_user_id']) {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' gifted your <a ' . (('href="' . $__templater->func('link', array('profile-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>status</a>.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' gifted <a ' . (('href="' . $__templater->func('link', array('profile-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your post</a> on {profile}\'s profile.' . '
';
	}
	return $__finalCompiled;
}
);