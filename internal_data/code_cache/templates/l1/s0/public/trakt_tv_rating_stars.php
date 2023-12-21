<?php
// FROM HASH: 7c5f9338048b2a2b7bb8d750b66e8ee1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<li>
	' . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['thread']['traktTV']['tv_rating'],
	), $__vars) . '
</li>';
	return $__finalCompiled;
}
);