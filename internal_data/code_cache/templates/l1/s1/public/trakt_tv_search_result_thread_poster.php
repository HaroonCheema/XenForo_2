<?php
// FROM HASH: d71227ac065a49e9057917c7bbdb0e88
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('trakt_tv.less');
	$__finalCompiled .= '
<img class="tvPoster" src="' . $__templater->escape($__templater->method($__vars['thread']['TV'], 'getImageUrl', array('s', ))) . '" />';
	return $__finalCompiled;
}
);