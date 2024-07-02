<?php
// FROM HASH: 440136ef8b8d72cff9e1c375f24700a3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['messages'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro(null, 'rtc_message_macros::list', array(
			'room' => $__vars['room'],
			'messages' => $__vars['messages'],
			'filter' => $__vars['filter'],
		), $__vars) . '
';
	}
	return $__finalCompiled;
}
);