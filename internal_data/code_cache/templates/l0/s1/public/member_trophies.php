<?php
// FROM HASH: 3f808562a1a14f660e968ff6d2f6c170
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Trophies awarded to ' . $__templater->escape($__vars['user']['username']) . '');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'noindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['user']['username'])), $__templater->func('link', array('members', $__vars['user'], ), false), array(
	));
	$__finalCompiled .= '

' . $__templater->includeTemplate('thuserimprovements_member_trophies', $__vars);
	return $__finalCompiled;
}
);