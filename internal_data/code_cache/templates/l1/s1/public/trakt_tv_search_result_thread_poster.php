<?php
// FROM HASH: c8243a481f630c19666355ba7180aa24
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('trakt_tv.less');
	$__finalCompiled .= '
<img class="tvPoster" src="' . $__templater->escape($__templater->method($__vars['thread']['traktTV'], 'getImageUrl', array('s', ))) . '" />';
	return $__finalCompiled;
}
);