<?php
// FROM HASH: 91fef799bbda20b46631b40fe6a32a60
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['visitor']['user_id'] == $__vars['content']['OwnerPagePost']['user_id']) {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your comment</a> on your owner-page post with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['extra']['reaction_id'], ), false), array(array('preescaped', array()),), true) . '.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your comment</a> on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s owner-page post with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['extra']['reaction_id'], ), false), array(array('preescaped', array()),), true) . '.' . '
';
	}
	return $__finalCompiled;
}
);