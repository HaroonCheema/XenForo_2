<?php
// FROM HASH: 1d40a80ce44a1d494fa56b380fa5d028
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('trakt_movies.less');
	$__finalCompiled .= '
<img class="moviePoster" src="' . $__templater->escape($__templater->method($__vars['thread']['Movie'], 'getImageUrl', array('s', ))) . '" />';
	return $__finalCompiled;
}
);