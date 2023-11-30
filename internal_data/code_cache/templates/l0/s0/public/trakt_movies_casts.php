<?php
// FROM HASH: ea08797d6c7f443850cc649abe683339
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('' . $__templater->escape($__vars['movie']['trakt_title']) . ' casts');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

<div class="block">
	' . $__templater->callMacro('trakt_movies_casts_macros', 'cast_list', array(
		'movie' => $__vars['movie'],
		'casts' => $__vars['casts'],
		'page' => $__vars['page'],
		'hasMore' => $__vars['hasMore'],
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);