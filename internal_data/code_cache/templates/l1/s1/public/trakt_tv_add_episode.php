<?php
// FROM HASH: 5a001d75a9da8acfe3f274319886e493
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('tvthreads_interface', 'new_episode', ))) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('
			' . 'trakt_tv_add_episode' . '
		', array(
			'href' => $__templater->func('link', array('forums/newepisode', $__vars['forum'], ), false),
			'class' => 'button--cta',
			'icon' => 'write',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);