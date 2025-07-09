<?php
// FROM HASH: 1481903d129699862efcc896243bba9b
return array(
'macros' => array('name' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'forum' => '!',
		'discThread' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__vars['forum']['Node']['disc_node_id']) {
		$__finalCompiled .= '
		' . $__templater->button('
				' . 'Discussion thread' . '
		', array(
			'href' => $__templater->func('link', array('threads/discussion_thread', $__vars['thread'], ), false),
			'class' => 'button--link',
		), '', array(
		)) . '
	';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);