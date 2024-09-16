<?php
// FROM HASH: 9cf3c55ecb44d8d5972f1f42793ef90d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="prefixContainer">
	' . $__templater->callMacro('sv_multiprefix_prefix_macros', 'select', array(
		'name' => 'na',
		'prefixes' => $__vars['prefixes'],
		'includeAny' => $__vars['includeAny'],
		'includeNone' => $__vars['includeNone'],
		'contentParent' => $__vars['forum'],
		'type' => 'thread',
		'forumPrefixesLimit' => $__vars['force_limit_prefix'],
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);