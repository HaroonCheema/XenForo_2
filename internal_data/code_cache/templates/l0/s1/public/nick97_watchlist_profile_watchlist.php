<?php
// FROM HASH: c2083750de2569d5421b73d90d8e4fc4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['limit']) {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'This member limits who may view their watch list.' . '</div>

	';
	} else {
		$__finalCompiled .= '
	' . $__templater->callMacro('nick97_watch_list_movies_macro', 'movies', array(
			'movies' => $__vars['movies'],
		), $__vars) . '

	' . $__templater->callMacro('nick97_watch_list_movies_macro', 'tvShow', array(
			'tvShows' => $__vars['tvShows'],
		), $__vars) . '
';
	}
	return $__finalCompiled;
}
);