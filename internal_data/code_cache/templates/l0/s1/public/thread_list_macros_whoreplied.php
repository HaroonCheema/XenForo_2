<?php
// FROM HASH: 88d0e9cd57fae0ec4e5597765909d80f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['thread']['discussion_type'] == 'redirect') {
		$__finalCompiled .= '&ndash;
';
	} else if ($__vars['thread']['reply_count'] AND $__templater->method($__vars['thread'], 'canViewWhoReplied', array())) {
		$__finalCompiled .= '
	<a href="' . $__templater->func('link', array('threads/who-replied', $__vars['thread'], ), true) . '"
	   title="' . $__templater->filter('Who Replied?', array(array('for_attr', array()),), true) . '"
	   data-xf-click="overlay" data-xf-init="tooltip"
	   >' . $__templater->escape($__vars['threadReplyCount']) . '</a>
';
	} else {
		$__finalCompiled .= $__templater->escape($__vars['threadReplyCount']) . '
';
	}
	return $__finalCompiled;
}
);