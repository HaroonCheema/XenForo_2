<?php
// FROM HASH: 0e70acc64c2d191d5aeca426c4da30d1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' mentioned you in <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>a comment</a> on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . ' owner-page.';
	return $__finalCompiled;
}
);