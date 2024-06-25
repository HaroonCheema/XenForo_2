<?php
// FROM HASH: beded39ea8043d1de465149b731cf190
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['visitor']['user_id'] == $__vars['content']['profile_user_id']) {
		$__finalCompiled .= '
	' . 'Somebody gifted <a ' . (('href="' . $__templater->func('link', array('profile-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your status</a>.' . '
';
	} else {
		$__finalCompiled .= '
	' . 'Somebody gifted <a ' . (('href="' . $__templater->func('link', array('profile-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your post</a> on {profile}\'s profile.' . '
';
	}
	return $__finalCompiled;
}
);