<?php
// FROM HASH: 1d380936ca9a49d73bfdcd2008a615ec
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'AL/FilterFramework/search_form.js',
		'min' => '0',
	));
	$__finalCompiled .= '
<div id="itemFilterContainer" data-preload="' . $__templater->filter($__vars['input'], array(array('json', array()),), true) . '" data-api="' . $__templater->func('link', array('search/load-thread-filter', ), true) . '"></div>';
	return $__finalCompiled;
}
);