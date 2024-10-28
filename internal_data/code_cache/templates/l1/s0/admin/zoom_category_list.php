<?php
// FROM HASH: 3871b1357201cc83681ab676b8e2d0bc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Categories');
	$__finalCompiled .= '

' . $__templater->callMacro('category_tree_macros', 'page_action', array(
		'linkPrefix' => 'zoom-categories',
	), $__vars) . '

' . $__templater->callMacro('category_tree_macros', 'category_list', array(
		'categoryTree' => $__vars['categoryTree'],
		'filterKey' => 'zoom-categories',
		'linkPrefix' => 'zoom-categories',
		'idKey' => 'category_id',
	), $__vars);
	return $__finalCompiled;
}
);