<?php
// FROM HASH: 39eb5dbd44888c825640f6db66c4d106
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

<br>

';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('nick97_watch_list', 'view_own_stats', )) OR $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('nick97_watch_list', 'view_anyone_stats', ))) {
		$__finalCompiled .= '

' . $__templater->callMacro('nick97_watch_list_movies_macro', 'stats', array(
			'stats' => $__vars['stats'],
		), $__vars) . '
	
';
	}
	$__finalCompiled .= '

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