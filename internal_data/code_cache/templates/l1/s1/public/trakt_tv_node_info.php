<?php
// FROM HASH: 07f3fef4748009add1e8dfaab797cfc6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('trakt_tv.less');
	$__finalCompiled .= '
<div class="node-description">
	';
	if ($__vars['node']['TVForum']['tv_genres']) {
		$__finalCompiled .= 'Genre' . ': ' . $__templater->filter($__vars['node']['TVForum']['tv_genres'], array(array('raw', array()),), true) . '<br />';
	}
	$__finalCompiled .= '
	';
	if ($__vars['node']['TVForum']['tv_director']) {
		$__finalCompiled .= 'trakt_tv_creator' . ': ' . $__templater->filter($__vars['node']['TVForum']['tv_director'], array(array('raw', array()),), true) . '<br />';
	}
	$__finalCompiled .= '
	';
	if ($__vars['node']['TVForum']['tv_release']) {
		$__finalCompiled .= 'First aired' . ': ' . $__templater->escape($__vars['node']['TVForum']['tv_release']);
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);