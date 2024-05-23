<?php
// FROM HASH: 7db6cfa8d83316966244767bf14a7760
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Questions');
	$__finalCompiled .= '

' . $__templater->callMacro('qsn_tree_macros', 'page_action', array(
		'linkPrefix' => 'quiz-qsn',
	), $__vars) . '

' . $__templater->callMacro('qsn_tree_macros', 'qsn_list', array(
		'qsnTree' => $__vars['question'],
		'filterKey' => 'fs_questions_list',
		'linkPrefix' => 'quiz-qsn',
		'idKey' => 'question_id',
	), $__vars);
	return $__finalCompiled;
}
);