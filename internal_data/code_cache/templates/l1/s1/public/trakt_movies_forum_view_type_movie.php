<?php
// FROM HASH: 5ced5a53e306e6b5f51d0abf6cf2be61
return array(
'extends' => function($__templater, array $__vars) { return 'forum_view'; },
'extensions' => array('above_node_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__templater->includeCss('trakt_movies.less');
	return $__finalCompiled;
},
'below_thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '<span class="moviehint">' . 'Movie information provided by <a href="https://trakt.tv/movies" target="_blank" >Trakt Movie Database</a>' . '</span>';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->renderExtension('above_node_list', $__vars, $__extensions) . '

' . $__templater->renderExtension('below_thread_list', $__vars, $__extensions);
	return $__finalCompiled;
}
);