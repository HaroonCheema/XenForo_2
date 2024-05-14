<?php
// FROM HASH: 59daefb7096ca58404ce2874b7b76097
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('bh_item_owner_page_all', 'owner_page', array(
		'item' => $__vars['item'],
		'itemPage' => $__vars['userItemPage'],
	), $__vars);
	return $__finalCompiled;
}
);