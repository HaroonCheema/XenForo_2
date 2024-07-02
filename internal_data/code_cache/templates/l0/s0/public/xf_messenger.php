<?php
// FROM HASH: 4fe29a38e2a58b4dc93dc6440c910f35
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('template', 'RTC_PAGE_CONTAINER');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Conversations');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xf/inline_mod.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__templater->includeCss('real_time_chat_window.less');
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'xf_messenger_chat_macros::chat', array(
		'createForm' => $__vars['createForm'],
		'roomTag' => $__vars['tag'],
		'attachmentData' => $__vars['attachmentData'],
		'latestMessageDate' => $__vars['latestMessageDate'],
	), $__vars);
	return $__finalCompiled;
}
);