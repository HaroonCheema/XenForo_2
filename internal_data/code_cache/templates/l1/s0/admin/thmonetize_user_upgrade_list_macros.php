<?php
// FROM HASH: bbabd6acea2c12646d9042914bdc76c8
return array(
'macros' => array('actions_bottom' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'upgrade' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a href="' . $__templater->func('link', array('user-upgrades/share', $__vars['upgrade'], ), true) . '" data-xf-click="overlay" class="menu-linkRow">
		' . 'Share upgrade link' . '
	</a>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);