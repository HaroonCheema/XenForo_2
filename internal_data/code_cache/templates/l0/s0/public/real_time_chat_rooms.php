<?php
// FROM HASH: fa636f35fb579c3d36dd123fc79eb502
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['rooms'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro('real_time_chat_macros', 'rooms', array(
			'rooms' => $__vars['rooms'],
			'filter' => $__vars['filter'],
		), $__vars) . '
';
	}
	return $__finalCompiled;
}
);