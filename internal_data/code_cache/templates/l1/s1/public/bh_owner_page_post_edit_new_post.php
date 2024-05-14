<?php
// FROM HASH: 773215f1dfe222ac3d2915b6e1e8cb22
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('bh_owner_page_post_macros', 'profile_post', array(
		'profilePost' => $__vars['profilePost'],
		'allowInlineMod' => ($__vars['noInlineMod'] ? false : true),
		'attachmentData' => $__vars['attachmentData'],
	), $__vars);
	return $__finalCompiled;
}
);