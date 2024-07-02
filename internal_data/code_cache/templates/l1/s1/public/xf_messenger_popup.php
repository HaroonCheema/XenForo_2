<?php
// FROM HASH: cb64f1a7c31736eec0f641af3c9a6f7f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'xf/inline_mod.js',
		'min' => '1',
	));
	$__finalCompiled .= '

<div class="chat-popup chat-popup--messenger is-loading js-draggableContainer">
	' . $__templater->callMacro(null, 'xf_messenger_chat_macros::chat', array(
		'createForm' => $__vars['createForm'],
		'roomTag' => $__vars['tag'],
		'attachmentData' => $__vars['attachmentData'],
		'latestMessageDate' => $__vars['latestMessageDate'],
		'compact' => true,
		'draggable' => true,
		'pushHistory' => false,
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);