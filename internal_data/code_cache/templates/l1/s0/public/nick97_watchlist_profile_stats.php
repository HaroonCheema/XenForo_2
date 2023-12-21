<?php
// FROM HASH: 42fa56f6afa0b3316af35641945021e4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['stats']) {
		$__finalCompiled .= '
	' . $__templater->callMacro('nick97_watch_list_movies_macro', 'stats', array(
			'stats' => $__vars['stats'],
		), $__vars) . '
	';
	} else {
		$__finalCompiled .= '

	';
		if ($__vars['limit']) {
			$__finalCompiled .= '
		<div class="blockMessage">' . 'This member limits who may view their stats.' . '</div>
		';
		} else {
			$__finalCompiled .= '
		<div class="blockMessage">' . 'This member have no any stats.' . '</div>
	';
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);