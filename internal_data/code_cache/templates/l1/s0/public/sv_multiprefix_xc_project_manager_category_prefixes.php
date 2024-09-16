<?php
// FROM HASH: 4b55a554c9812eff265150d8664194b1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="prefixContainer">
	' . $__templater->callMacro('sv_multiprefix_prefix_macros', 'select', array(
		'name' => 'na',
		'prefixes' => $__vars['prefixes'],
		'contentParent' => $__vars['category'],
		'includeAny' => $__vars['includeAny'],
		'includeNone' => $__vars['includeNone'],
		'type' => 'xcpm_project',
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);