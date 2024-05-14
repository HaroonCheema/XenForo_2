<?php
// FROM HASH: ad5c5da72f4806199e37a60390dad9de
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['visitor']['user_id'] == $__vars['content']['OwnerPagePost']['user_id']) {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' commented on <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your owner-page update</a>.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' commented on <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s post</a> on your owner-page.' . '
';
	}
	return $__finalCompiled;
}
);