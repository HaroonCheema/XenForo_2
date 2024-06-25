<?php
// FROM HASH: c2f3a8b3811db3e5ef6cfc3d1943a16b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Somebody gifted your <a ' . (('href="' . $__templater->func('link', array('profile-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>comment</a> on ' . $__templater->escape($__vars['content']['ProfilePost']['ProfileUser']['username']) . '\'s profile.';
	return $__finalCompiled;
}
);