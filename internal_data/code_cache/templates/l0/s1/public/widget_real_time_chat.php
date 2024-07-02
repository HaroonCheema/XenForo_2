<?php
// FROM HASH: d5279095e23b65266af6c745599773c7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="widget-rtc block">
	' . $__templater->callMacro(null, 'real_time_chat_macros::chat', array(
		'attachmentData' => $__vars['attachmentData'],
		'latestMessageDate' => $__vars['latestMessageDate'],
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);