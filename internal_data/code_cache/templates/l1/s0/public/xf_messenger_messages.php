<?php
// FROM HASH: 7f8bcb3d4ebd2cfed64305f483405fb1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['messages'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro(null, 'xf_messenger_message_macros::list', array(
			'userConv' => $__vars['userConv'],
			'messages' => $__vars['messages'],
			'filter' => $__vars['filter'],
		), $__vars) . '
';
	}
	return $__finalCompiled;
}
);