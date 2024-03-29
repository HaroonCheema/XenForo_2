<?php
// FROM HASH: c9d8848a97d33347aafd7e1c66d90e8e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('bh_owner_page_post_macros', 'comment', array(
		'profilePost' => $__vars['profilePost'],
		'comment' => $__vars['comment'],
	), $__vars);
	return $__finalCompiled;
}
);