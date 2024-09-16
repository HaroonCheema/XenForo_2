<?php
// FROM HASH: 9862fdd83921b389d6f8c5e8f40bcbb0
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
		'contentParent' => $__vars['category'],
		'type' => 'resource',
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);