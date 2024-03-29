<?php
// FROM HASH: 0b05b7acb876593e626b8f222c32cd7c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->isTraversable($__vars['profilePostComments'])) {
		foreach ($__vars['profilePostComments'] AS $__vars['profilePostComment']) {
			$__finalCompiled .= '
	' . $__templater->callMacro('bh_owner_page_post_macros', 'comment', array(
				'profilePost' => $__vars['profilePost'],
				'comment' => $__vars['profilePostComment'],
			), $__vars) . '
';
		}
	}
	return $__finalCompiled;
}
);