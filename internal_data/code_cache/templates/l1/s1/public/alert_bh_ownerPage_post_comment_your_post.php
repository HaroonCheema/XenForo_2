<?php
// FROM HASH: 94f6f85049af9c981f807ef9ce0a4514
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' commented on <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your post</a> on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s owner-page.';
	return $__finalCompiled;
}
);