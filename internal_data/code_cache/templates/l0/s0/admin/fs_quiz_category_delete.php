<?php
// FROM HASH: 4bc75ad79f2eb51e15430bd45f179818
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->callMacro('category_tree_macros', 'category_delete_form', array(
		'linkPrefix' => 'quiz-categories',
		'category' => $__vars['category'],
	), $__vars);
	return $__finalCompiled;
}
);