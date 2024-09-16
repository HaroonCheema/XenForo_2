<?php
// FROM HASH: 6db616e7da31d6f69461ef2e07107e9d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->callMacro('public:sv_multiprefix_prefix_macros', 'row', array(
		'prefixes' => $__vars['prefixes']['prefixesGrouped'],
		'label' => 'Add prefixes',
		'name' => 'actions[add_prefixes]',
		'multiple' => true,
		'includeAny' => false,
		'includeNone' => false,
		'type' => 'thread',
	), $__vars) . '

' . $__templater->callMacro('public:sv_multiprefix_prefix_macros', 'row', array(
		'prefixes' => $__vars['prefixes']['prefixesGrouped'],
		'label' => 'Remove Prefixes',
		'name' => 'actions[remove_prefixes]',
		'multiple' => true,
		'includeAny' => false,
		'includeNone' => false,
		'type' => 'thread',
	), $__vars);
	return $__finalCompiled;
}
);