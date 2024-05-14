<?php
// FROM HASH: 85c606b662d82dfee307136214aa7ded
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('approval_queue_macros', 'item_message_type', array(
		'content' => $__vars['content'],
		'contentDate' => $__vars['content']['comment_date'],
		'user' => $__vars['content']['User'],
		'messageHtml' => $__templater->func('bb_code', array($__vars['content']['message'], 'bh_ownerPage_post_comment', $__vars['content'], ), false),
		'typePhraseHtml' => 'Owner page post comment',
		'spamDetails' => $__vars['spamDetails'],
		'unapprovedItem' => $__vars['unapprovedItem'],
		'handler' => $__vars['handler'],
		'headerPhraseHtml' => 'Posted on owner-page post by <a href="' . $__templater->func('link', array('owner-page-posts/comments', $__vars['content'], ), true) . '">' . $__templater->escape($__vars['content']['OwnerPagePost']['username']) . '</a>',
	), $__vars);
	return $__finalCompiled;
}
);