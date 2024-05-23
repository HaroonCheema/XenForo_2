<?php
// FROM HASH: d26c5a60b556adde080612a3af7e694c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->callMacro('delete_qsn_macros', 'delete', array(
		'object' => $__vars['question'],
		'idKey' => 'question_id',
	), $__vars);
	return $__finalCompiled;
}
);