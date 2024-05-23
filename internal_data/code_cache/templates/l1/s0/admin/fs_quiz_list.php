<?php
// FROM HASH: 15d6a41e971c13358a5da74e03eeb5a3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Quiz List');
	$__finalCompiled .= '

' . $__templater->callMacro('quiz_tree_macros', 'page_action', array(
		'linkPrefix' => 'quiz',
	), $__vars) . '

' . $__templater->callMacro('quiz_tree_macros', 'quiz_list', array(
		'quizTree' => $__vars['quiz'],
		'filterKey' => 'quiz',
		'linkPrefix' => 'quiz',
		'idKey' => 'quiz_id',
	), $__vars);
	return $__finalCompiled;
}
);