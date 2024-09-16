<?php
// FROM HASH: 78a86d5404d35bb15e412a29c580bf47
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['options']['tagessTagsOnThreadList']) {
		$__finalCompiled .= '
	';
		$__vars['hideEditLink'] = true;
		$__finalCompiled .= '
	' . $__templater->includeTemplate('avForumsTagEss_thread_view_grouped_tags', $__vars) . '
';
	}
	return $__finalCompiled;
}
);