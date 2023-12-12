<?php
// FROM HASH: 83abbd438cb69bf67bf4fa44ff95fa09
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

<br>

' . $__templater->callMacro('nick97_watch_list_movies_macro', 'stats', array(
		'stats' => $__vars['stats'],
	), $__vars) . '

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