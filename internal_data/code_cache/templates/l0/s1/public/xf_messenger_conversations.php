<?php
// FROM HASH: 02201d0e3da3c0dbdacbfe720d0b41dc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
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
	$__templater->includeCss('real_time_chat.less');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Open messenger', array(
		'href' => $__templater->func('link', array('conversations/messenger', ), false),
		'class' => 'button--cta',
		'icon' => 'conversation',
	), '', array(
	)) . '
');
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