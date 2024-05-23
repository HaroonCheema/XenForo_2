<?php
// FROM HASH: 4d825057ad4c8de6375a4d744dcb2466
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->callMacro('delete_quiz_macros', 'delete', array(
		'object' => $__vars['quiz'],
		'idKey' => 'quiz_id',
	), $__vars);
	return $__finalCompiled;
}
);