<?php
// FROM HASH: 56a44a7f4cfffce7b1596a36da38e892
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['userConvs'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro('xf_messenger_chat_macros', 'rooms', array(
			'userConvs' => $__vars['userConvs'],
			'filters' => $__vars['filters'],
		), $__vars) . '
';
	}
	return $__finalCompiled;
}
);