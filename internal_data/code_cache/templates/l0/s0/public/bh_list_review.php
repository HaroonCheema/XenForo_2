<?php
// FROM HASH: ca880115b8af6c1d69f626a8c9d9553d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('bh_item_review_macros', 'review_simple', array(
		'review' => $__vars['itemReview'],
		'item' => $__vars['item'],
	), $__vars);
	return $__finalCompiled;
}
);