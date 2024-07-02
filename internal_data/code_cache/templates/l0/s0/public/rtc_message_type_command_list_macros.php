<?php
// FROM HASH: 42bbccea166d8ac6d0984aa85eae27ef
return array(
'macros' => array('type_command_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'commands' => '!',
		'message' => '!',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['author'] = $__templater->preEscaped('
		' . $__templater->func('username_link', array($__vars['message']['User'], true, array(
	))) . '
	');
	$__finalCompiled .= '
	
	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['commands'])) {
		foreach ($__vars['commands'] AS $__vars['command']) {
			$__compilerTemp1 .= '
					<div class="form-line form-line--margined">
						<div><b>/' . $__templater->escape($__templater->method($__vars['command'], 'getName', array())) . '</b></div>
						<div style="margin-left: 15px">' . $__templater->filter($__templater->method($__vars['command'], 'getDescription', array()), array(array('raw', array()),), true) . '</div>
					</div>
				';
		}
	}
	$__vars['list'] = $__templater->preEscaped('
		<div class="chat-message-form">
			<div class="form-body">
				' . $__compilerTemp1 . '
			</div>
		</div>
	');
	$__finalCompiled .= '
	
	' . $__templater->callMacro(null, 'rtc_message_macros::type_bubble', array(
		'message' => $__vars['message'],
		'text' => $__vars['list'],
		'filter' => $__vars['filter'],
	), $__vars) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);