<?php
// FROM HASH: f7967b34e92404d8c61a8c99fcdd23f4
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
		'type' => 'dbtechEcommerceProduct',
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);