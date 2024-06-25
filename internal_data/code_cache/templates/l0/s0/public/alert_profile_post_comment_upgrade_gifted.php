<?php
// FROM HASH: 8d3edf6eeb97585ab1cfc16d9c259769
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' gifted your <a ' . (('href="' . $__templater->func('link', array('profile-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>comment</a> on ' . $__templater->escape($__vars['content']['ProfilePost']['ProfileUser']['username']) . '\'s profile.';
	return $__finalCompiled;
}
);