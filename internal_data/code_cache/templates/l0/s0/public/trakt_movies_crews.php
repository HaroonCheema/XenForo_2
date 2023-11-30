<?php
// FROM HASH: a9b0d527b8897d58bb283fa54eda1ed9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('trakt_movies_x_crews');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

<div class="block">
	' . $__templater->callMacro('trakt_movies_crews_macros', 'crew_list', array(
		'movie' => $__vars['movie'],
		'crews' => $__vars['crews'],
		'page' => $__vars['page'],
		'hasMore' => $__vars['hasMore'],
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);