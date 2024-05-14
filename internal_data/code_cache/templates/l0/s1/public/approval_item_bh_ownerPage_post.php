<?php
// FROM HASH: 3d5e2ecbdb6e65982d454db3e83f8e66
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('approval_queue_macros', 'item_message_type', array(
		'content' => $__vars['content'],
		'user' => $__vars['content']['User'],
		'messageHtml' => $__templater->func('bb_code', array($__vars['content']['message'], 'bh_ownerPage_post', $__vars['content'], ), false),
		'typePhraseHtml' => 'Owner page post',
		'spamDetails' => $__vars['spamDetails'],
		'unapprovedItem' => $__vars['unapprovedItem'],
		'handler' => $__vars['handler'],
		'headerPhraseHtml' => 'Posted on owner page <a href="' . $__templater->func('link', array('owner-page-posts', $__vars['content'], ), true) . '">' . $__templater->escape($__vars['content']['OwnerPage']['title']) . '</a>',
	), $__vars);
	return $__finalCompiled;
}
);