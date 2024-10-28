<?php
// FROM HASH: 58a98c215f2354bf2677c4beb0d38732
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Sort categories');
	$__finalCompiled .= '

' . $__templater->callMacro('category_tree_macros', 'sortable_form', array(
		'categoryTree' => $__vars['categoryTree'],
		'linkPrefix' => 'zoom-categories',
	), $__vars);
	return $__finalCompiled;
}
);