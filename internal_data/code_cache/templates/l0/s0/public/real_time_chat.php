<?php
// FROM HASH: c28ae8b49b76d3f1a7bccc919496a09f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('template', 'RTC_PAGE_CONTAINER');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Chat');
	$__finalCompiled .= '

';
	$__templater->includeCss('real_time_chat_window.less');
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'real_time_chat_macros::chat', array(
		'roomTag' => $__vars['tag'],
		'attachmentData' => $__vars['attachmentData'],
		'latestMessageDate' => $__vars['latestMessageDate'],
		'pushHistory' => true,
	), $__vars);
	return $__finalCompiled;
}
);