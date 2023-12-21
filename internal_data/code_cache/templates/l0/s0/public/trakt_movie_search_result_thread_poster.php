<?php
// FROM HASH: ed7b45f0fbeb77f93d08957f4431e1d3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('trakt_movies.less');
	$__finalCompiled .= '
<img class="moviePoster" src="' . $__templater->escape($__templater->method($__vars['thread']['traktMovie'], 'getImageUrl', array('s', ))) . '" />';
	return $__finalCompiled;
}
);