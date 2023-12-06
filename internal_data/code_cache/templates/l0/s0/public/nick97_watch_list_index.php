<?php
// FROM HASH: 3472c3b6c610b592b821fbd72f313be8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

<br>

' . $__templater->callMacro('nick97_watch_list_movies_macro', 'movies', array(
		'movies' => $__vars['movies'],
	), $__vars) . '

' . $__templater->callMacro('nick97_watch_list_movies_macro', 'tvShow', array(
		'tvShows' => $__vars['tvShows'],
	), $__vars) . '


<br>




';
	return $__finalCompiled;
}
);