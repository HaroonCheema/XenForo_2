<?php
// FROM HASH: caaccfc32764f9feca1d35178cec4974
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
		'type' => 'dbtechShopItem',
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);