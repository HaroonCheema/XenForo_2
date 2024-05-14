<?php
// FROM HASH: 1f1549c0e3236348300ca4b8ca9888f7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' mentioned you in <a ' . (('href="' . $__templater->func('link', array('owner-page-posts', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>a message</a> on ' . $__templater->escape($__vars['content']['OwnerPage']['title']) . '\'s owner-page.';
	return $__finalCompiled;
}
);