<?php
// FROM HASH: 78ad1573bfa2520679e57e41dff61ce6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Quiz Categories');
	$__finalCompiled .= '

' . $__templater->callMacro('category_tree_macros', 'page_action', array(
		'linkPrefix' => 'quiz-categories',
	), $__vars) . '

' . $__templater->callMacro('category_tree_macros', 'category_list', array(
		'categoryTree' => $__vars['categoryTree'],
		'filterKey' => 'quiz-categories',
		'linkPrefix' => 'quiz-categories',
		'idKey' => 'category_id',
	), $__vars);
	return $__finalCompiled;
}
);