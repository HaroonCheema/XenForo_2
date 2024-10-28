<?php
// FROM HASH: 3ef619091f91bbc72f722716a7890561
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->callMacro('category_tree_macros', 'category_delete_form', array(
		'linkPrefix' => 'zoom-categories',
		'category' => $__vars['category'],
	), $__vars);
	return $__finalCompiled;
}
);