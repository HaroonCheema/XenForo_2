<?php
// FROM HASH: fa07b579c83752cf515806427663bae3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="chat-popup is-loading js-draggableContainer">
	' . $__templater->callMacro(null, 'real_time_chat_macros::chat', array(
		'roomTag' => $__vars['tag'],
		'attachmentData' => $__vars['attachmentData'],
		'latestMessageDate' => $__vars['latestMessageDate'],
		'autoSelectRoom' => false,
		'compact' => true,
		'draggable' => true,
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);