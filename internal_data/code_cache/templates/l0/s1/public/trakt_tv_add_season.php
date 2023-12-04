<?php
// FROM HASH: a4687b297cdbcc511edded21eae501ce
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('tvthreads_interface', 'new_season', ))) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('
			' . 'trakt_tv_add_season' . '
		', array(
			'href' => $__templater->func('link', array('forums/newseason', $__vars['forum'], ), false),
			'class' => 'button--cta',
			'icon' => 'write',
			'overlay' => 'true',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);